<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminReportsApi extends BaseController
{
    protected $db;
    protected $validation;
    
    public function __construct()
    {
        // Koneksi database langsung di construct
        $this->db = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
    }

    /**
     * GET /api/admin/reports
     * Ambil data statistik laporan berdasarkan range tanggal
     */
    public function index(): ResponseInterface
    {
        // Check admin authentication
        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 401,
                'error' => 'Silakan login terlebih dahulu'
            ]);
        }
        
        $user = $this->db->table('users')->where('id', $userId)->get()->getRowArray();
        if (!$user || $user['role'] !== 'admin') {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => 403,
                'error' => 'Akses ditolak. Hanya admin yang bisa mengakses'
            ]);
        }
        
        // Ambil parameter tanggal dari URL
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        
        // Kalau tidak ada parameter, pakai default awal bulan sampai akhir bulan
        if(empty($startDate)) {
            $startDate = date('Y-m-01'); // Tanggal 1 bulan ini
        }
        
        if(empty($endDate)) {
            $endDate = date('Y-m-t'); // Tanggal akhir bulan ini
        }
        
        // Validasi format tanggal
        if(!$this->validateDate($startDate) || !$this->validateDate($endDate)) {
            return $this->response->setJSON([
                'status' => 400,
                'error' => 'Format tanggal tidak valid. Gunakan YYYY-MM-DD'
            ]);
        }
        
        try {
            log_message('info', '[AdminReportsApi] Loading reports for ' . $startDate . ' to ' . $endDate);
            
            // Hitung total booking
            $builder = $this->db->table('bookings');
            $builder->where('created_at >=', $startDate . ' 00:00:00');
            $builder->where('created_at <=', $endDate . ' 23:59:59');
            $totalBookings = $builder->countAllResults();
            
            // Reset builder untuk query berikutnya
            $builder = $this->db->table('bookings');
            $builder->where('status', 'selesai');
            $builder->where('created_at >=', $startDate . ' 00:00:00');
            $builder->where('created_at <=', $endDate . ' 23:59:59');
            $completedBookings = $builder->countAllResults();
            
            // Hitung booking pending
            $builder = $this->db->table('bookings');
            $builder->where('status', 'pending');
            $builder->where('created_at >=', $startDate . ' 00:00:00');
            $builder->where('created_at <=', $endDate . ' 23:59:59');
            $pendingBookings = $builder->countAllResults();
            
            // Hitung booking batal
            $builder = $this->db->table('bookings');
            $builder->where('status', 'batal');
            $builder->where('created_at >=', $startDate . ' 00:00:00');
            $builder->where('created_at <=', $endDate . ' 23:59:59');
            $cancelledBookings = $builder->countAllResults();
            
            // Hitung booking proses
            $builder = $this->db->table('bookings');
            $builder->where('status', 'proses');
            $builder->where('created_at >=', $startDate . ' 00:00:00');
            $builder->where('created_at <=', $endDate . ' 23:59:59');
            $processingBookings = $builder->countAllResults();
            
            // Hitung total pendapatan dari booking yang selesai
            $builder = $this->db->table('bookings');
            $builder->select('COALESCE(SUM(total), 0) as total');
            $builder->where('status', 'selesai');
            $builder->where('created_at >=', $startDate . ' 00:00:00');
            $builder->where('created_at <=', $endDate . ' 23:59:59');
            $query = $builder->get();
            $row = $query->getRow();
            $totalRevenue = $row ? (int)$row->total : 0;
            
            // Statistik per layanan
            $builder = $this->db->table('bookings');
            $builder->select('layanan, COUNT(*) as jumlah, COALESCE(SUM(total), 0) as pendapatan');
            $builder->where('created_at >=', $startDate . ' 00:00:00');
            $builder->where('created_at <=', $endDate . ' 23:59:59');
            $builder->groupBy('layanan');
            $builder->orderBy('jumlah', 'DESC');
            $query = $builder->get();
            $serviceStats = $query->getResultArray();
            
            // Data booking per hari untuk chart
            $builder = $this->db->table('bookings');
            $builder->select('DATE(created_at) as tanggal, COUNT(*) as jumlah');
            $builder->where('created_at >=', $startDate . ' 00:00:00');
            $builder->where('created_at <=', $endDate . ' 23:59:59');
            $builder->groupBy('DATE(created_at)');
            $builder->orderBy('tanggal', 'ASC');
            $query = $builder->get();   
            $dailyBookings = $query->getResultArray();
            
            // Breakdown status booking
            $builder = $this->db->table('bookings');
            $builder->select('status, COUNT(*) as jumlah');
            $builder->where('created_at >=', $startDate . ' 00:00:00');
            $builder->where('created_at <=', $endDate . ' 23:59:59');
            $builder->groupBy('status');
            $query = $builder->get();
            $statusBreakdown = $query->getResultArray();
            
            $response = [
                'status' => 200,
                'data' => [
                    'rentang_tanggal' => [
                        'dari' => $startDate,
                        'sampai' => $endDate
                    ],
                    'ringkasan' => [
                        'total_booking' => $totalBookings,
                        'booking_selesai' => $completedBookings,
                        'booking_pending' => $pendingBookings,
                        'booking_proses' => $processingBookings,
                        'booking_batal' => $cancelledBookings,
                        'total_pendapatan' => $totalRevenue
                    ],
                    'statistik_layanan' => $serviceStats,
                    'booking_harian' => $dailyBookings,
                    'status_booking' => $statusBreakdown
                ]
            ];
            
            return $this->response->setJSON($response);
            
        } catch (\Exception $e) {
            log_message('error', '[AdminReportsApi] Error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => 500,
                'error' => 'Gagal mengambil data laporan. Silakan coba lagi.'
            ]);
        }
    }

    /**
     * GET /api/admin/reports/bookings
     * Ambil detail semua booking untuk keperluan print/export
     */
    public function bookings(): ResponseInterface
    {
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        
        if(empty($startDate)) {
            $startDate = date('Y-m-01');
        }
        
        if(empty($endDate)) {
            $endDate = date('Y-m-t');
        }
        
        try {
            $builder = $this->db->table('bookings');
            $builder->select('bookings.*, users.nama_lengkap as nama_customer, users.email as email_customer');
            $builder->join('users', 'users.id = bookings.id_user', 'left');
            $builder->where('bookings.created_at >=', $startDate . ' 00:00:00');
            $builder->where('bookings.created_at <=', $endDate . ' 23:59:59');
            $builder->orderBy('bookings.created_at', 'DESC');
            $query = $builder->get();
            $bookings = $query->getResultArray();
            
            return $this->response->setJSON([
                'status' => 200,
                'data' => [
                    'rentang_tanggal' => [
                        'dari' => $startDate,
                        'sampai' => $endDate
                    ],
                    'booking' => $bookings,
                    'total_data' => count($bookings)
                ]
            ]);
            
        } catch (\Exception $e) {
            log_message('error', '[AdminReportsApi] Error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => 500,
                'error' => 'Gagal mengambil data booking. Silakan coba lagi.'
            ]);
        }
    }

    /**
     * GET /api/admin/reports/revenue
     * Laporan pendapatan per periode (harian/bulanan)
     */
    public function revenue(): ResponseInterface
    {
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $groupBy = $this->request->getGet('group_by'); // daily atau monthly
        
        if(empty($startDate)) {
            $startDate = date('Y-m-01');
        }
        
        if(empty($endDate)) {
            $endDate = date('Y-m-t');
        }
        
        if(empty($groupBy)) {
            $groupBy = 'daily';
        }
        
        try {
            $builder = $this->db->table('bookings');
            
            if($groupBy == 'monthly') {
                // Group per bulan
                $builder->select("DATE_FORMAT(created_at, '%Y-%m') as periode, COALESCE(SUM(total), 0) as pendapatan, COUNT(*) as jumlah_booking");
            } else {
                // Group per hari
                $builder->select("DATE(created_at) as periode, COALESCE(SUM(total), 0) as pendapatan, COUNT(*) as jumlah_booking");
            }
            
            $builder->where('status', 'selesai');
            $builder->where('created_at >=', $startDate . ' 00:00:00');
            $builder->where('created_at <=', $endDate . ' 23:59:59');
            $builder->groupBy('periode');
            $builder->orderBy('periode', 'ASC');
            $query = $builder->get();
            $revenueData = $query->getResultArray();
            
            // Hitung total
            $totalPendapatan = 0;
            $totalBooking = 0;
            
            foreach($revenueData as $row) {
                $totalPendapatan += $row['pendapatan'];
                $totalBooking += $row['jumlah_booking'];
            }
            
            $rataPendapatan = $totalBooking > 0 ? round($totalPendapatan / $totalBooking) : 0;
            
            return $this->response->setJSON([
                'status' => 200,
                'data' => [
                    'rentang_tanggal' => [
                        'dari' => $startDate,
                        'sampai' => $endDate,
                        'group_by' => $groupBy
                    ],
                    'ringkasan' => [
                        'total_pendapatan' => $totalPendapatan,
                        'total_booking' => $totalBooking,
                        'rata_pendapatan' => $rataPendapatan
                    ],
                    'data_pendapatan' => $revenueData
                ]
            ]);
            
        } catch (\Exception $e) {
            log_message('error', '[AdminReportsApi] Error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => 500,
                'error' => 'Gagal mengambil data pendapatan. Silakan coba lagi.'
            ]);
        }
    }

    /**
     * GET /api/admin/reports/customers
     * Statistik customer dan top customer
     */
    public function customers(): ResponseInterface
    {
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        
        if(empty($startDate)) {
            $startDate = date('Y-m-01');
        }
        
        if(empty($endDate)) {
            $endDate = date('Y-m-t');
        }
        
        try {
            // Top 10 customer berdasarkan total belanja
            $builder = $this->db->table('bookings');
            $builder->select('users.id, users.nama_lengkap, users.email, COUNT(bookings.id) as jumlah_booking, SUM(bookings.total) as total_belanja');
            $builder->join('users', 'users.id = bookings.id_user');
            $builder->where('bookings.status', 'selesai');
            $builder->where('bookings.created_at >=', $startDate . ' 00:00:00');
            $builder->where('bookings.created_at <=', $endDate . ' 23:59:59');
            $builder->groupBy('users.id');
            $builder->orderBy('total_belanja', 'DESC');
            $builder->limit(10);
            $query = $builder->get();
            $topCustomers = $query->getResultArray();
            
            // Hitung customer baru di periode ini
            $builder = $this->db->table('users');
            $builder->where('users.created_at >=', $startDate . ' 00:00:00');
            $builder->where('users.created_at <=', $endDate . ' 23:59:59');
            $newCustomers = $builder->countAllResults();
            
            return $this->response->setJSON([
                'status' => 200,
                'data' => [
                    'rentang_tanggal' => [
                        'dari' => $startDate,
                        'sampai' => $endDate
                    ],
                    'customer_baru' => $newCustomers,
                    'top_customer' => $topCustomers
                ]
            ]);
            
        } catch (\Exception $e) {
            log_message('error', '[AdminReportsApi] Error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => 500,
                'error' => 'Gagal mengambil data customer. Silakan coba lagi.'
            ]);
        }
    }
    
    /**
     * Fungsi helper untuk validasi format tanggal
     */
    private function validateDate($date)
    {
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
}