<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminDashboardApi extends BaseController
{
    protected $db;
    public function __construct()
    {
        // Koneksi database
        $this->db = \Config\Database::connect();
    }

    /**
     * GET /api/admin/dashboard
     * Ambil semua statistik untuk halaman dashboard admin
     */
    public function index(): ResponseInterface
    {
        try {
            // STATISTIK USER
            //Hitung total semua user
            $builder = $this->db->table('users');
            $totalUsers = $builder->countAllResults();

            // Hitung user yang daftar bulan ini
            $builder = $this->db->table('users');
            $builder->where('MONTH(dibuat_pada)', date('m'));
            $builder->where('YEAR(dibuat_pada)', date('Y'));
            $usersThisMonth = $builder->countAllResults();

            // STATISTIK BOOKING
            // Hitung semua booking
            $builderBooking = $this->db->table('bookings');
            $totalBooking = $builderBooking->countAllResults();

            // Booking bulan ini
            $builderBooking = $this->db->table('bookings');
            $builderBooking->where('MONTH(dibuat_pada)', date('m'));
            $builderBooking->where('YEAR(dibuat_pada)', date('Y'));
            $builderBulanIini = $builderBooking->countAllResults();

            // Booking selesai
            $builderBooking = $this->db->table('bookings');
            $builderBooking->where('status', 'selesai');
            $bookingSelesai = $builderBooking->countAllResults();

            //Booking proses
            $builderBooking = $this->db->table('bookings');
            $builderBooking->where('status', 'proses');
            $bookingProses = $builderBooking->countAllResults();

            // Booking pending 
            $builderBooking = $this->db->table('bookings');
            $builderBooking->where('status', 'pending');
            $bookingPending = $builderBooking->countAllResults();

            // STATISTIK PENDAPATAN
            // Pendapatan bulan (hanya booking selesai)
            $builderRevenue = $this->db->table('bookings');
            $builderRevenue->select('SUM(total) as total');
            $builderRevenue->where('status', 'selesai');    
            $builderRevenue->where('MONTH(dibuat_pada)', date('m'));
            $builderRevenue->where('YEAR(dibuat_pada)', date('Y'));
            $queryRevenue = $builderRevenue->get();
            $rowRevenue = $queryRevenue->getRow();
            $revenueThisMonth = $rowRevenue ? (int)$rowRevenue->total : 0;

            // Total pendapatan semua waktu
            $builderRevenue = $this->db->table('bookings');
            $builderRevenue->select('SUM(total) as total');
            $builderRevenue->where('status', 'selesai');
            $queryRevenue = $builderRevenue->get();
            $rowRevenue = $queryRevenue->getRow();
            $totalRevenue = $rowRevenue ? (int)$rowRevenue->total : 0;

            // Response
            $response = [
                'status' => '200',
                'data' => [
                    'pengguna' => [
                        'total' => $totalUsers,
                        'bulan_ini' => $usersThisMonth
                    ],
                    'booking' => [
                        'total' => $totalBooking,
                        'bulan_ini' => $builderBulanIini,
                        'selesai' => $bookingSelesai,
                        'proses' => $bookingProses,
                        'pending' => $bookingPending
                    ],
                    'pendapatan' => [
                        'bulan_ini' => $revenueThisMonth,
                        'total' => $totalRevenue
                    ]
                ]
            ];
            return $this->response->setJSON($response);
        } catch (\Exception $e) {
            // Tangani error
            return $this->response->setJSON([
                'status' => '500',
                'error' => 'Gagal mengambil data dashboard. Coba lagi nanti.'
            ]); 
        }
    }

    /**
     * GET /api/admin/dashboard/recent-bookings
     * Ambil booking terbaru dengan halaman (pagination)
     * Parameter: page (halaman berapa), limit (berapa data per halaman)
     */
    public function recentBookings(): ResponseInterface
    {
        try {
            // Ambil parameter dari URL
            $halaman = $this->request->getGet('page');
            $batas = $this->request->getGet('limit');

            // Kalau gaada parameter, pake default
            if (empty($halaman) || !is_numeric($halaman) || $halaman < 1) {
                $halaman = 1;
            }

            if (empty($batas) || !is_numeric($batas) || $batas < 1) {
                $batas = 10;
            }

            $mulaiDari = ($halaman - 1) * $batas;

            // Hitung total data
            $builderTotal = $this->db->table('bookings');
            $totalData = $builderTotal->countAllResults();

            // Ambil dengan join ke tabel users
            $builder = $this->db->table('bookings');
            $builder->select('bookings.*, users.nama_lengkap as nama_customer, users.email as email_customer, users.no_hp');
            $builder->join('users', 'users.id = bookings.id_user', 'left');
            $builder->orderBy('bookings.dibuat_pada', 'DESC');
            $builder->limit($batas, $mulaiDari);
            $query = $builder->get();
            $dataBooking = $query->getResultArray();

            // Hitung total halaman
            $totalHalaman = ceil($totalData / $batas);

            return $this->response->setJSON([
                'status' => 200,
                'data' => [
                    'booking' => $dataBooking,
                    'halaman' => [
                        'current' => (int)$halaman,
                        'per_halaman' => (int)$batas,
                        'total_data' => $totalData,
                        'total_halaman' => $totalHalaman
                    ]
                ]
            ]);
            
        } catch (\Exception $e) {
            log_message('error', '[Dashboard] Gagal ambil recent bookings: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => 500,
                'error' => 'Gagal mengambil data booking terbaru.'
            ]);
        }
    }

    /**
     * GET /api/admin/dashboard/pending-bookings
     * Ambil booking yang statusnya pending
     * Parameter: limit (berapa data yang mau diambil)
     */
    public function pendingBookings(): ResponseInterface
    {
        try {
            $batas = $this->request->getGet('limit');
            
            if(empty($batas) || !is_numeric($batas)) {
                $batas = 10;
            }

            // Hitung total pending
            $builderPending = $this->db->table('bookings');
            $builderPending->where('status', 'pending');
            $totalPending = $builderPending->countAllResults();

            // Ambil data pending
            $builder = $this->db->table('bookings');
            $builder->select('bookings.*, users.nama_lengkap as nama_customer, users.email as email_customer, users.no_hp');
            $builder->join('users', 'users.id = bookings.id_user', 'left');
            $builder->where('bookings.status', 'pending');
            $builder->orderBy('bookings.dibuat_pada', 'DESC');
            $builder->limit($batas);
            $query = $builder->get();
            $dataPending = $query->getResultArray();

            return $this->response->setJSON([
                'status' => 200,
                'data' => [
                    'total_pending' => $totalPending,
                    'booking' => $dataPending
                ]
            ]);
            
        } catch (\Exception $e) {
            log_message('error', '[Dashboard] Gagal ambil pending bookings: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => 500,
                'error' => 'Gagal mengambil data booking pending.'
            ]);
        }
    }

    /**
     * GET /api/admin/dashboard/service-stats
     * Statistik per layanan (berapa banyak booking, total pendapatan)
     */
    public function serviceStats(): ResponseInterface
    {
        try {
            $builder = $this->db->table('bookings');
            $builder->select('layanan, COUNT(*) as jumlah_booking, SUM(total) as total_pendapatan');
            $builder->groupBy('layanan');
            $builder->orderBy('jumlah_booking', 'DESC');
            $query = $builder->get();
            $statistik = $query->getResultArray();

            return $this->response->setJSON([
                'status' => 200,
                'data' => $statistik
            ]);
            
        } catch (\Exception $e) {
            log_message('error', '[Dashboard] Gagal ambil service stats: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => 500,
                'error' => 'Gagal mengambil statistik layanan.'
            ]);
        }
    }

    /**
     * GET /api/admin/dashboard/recent-users
     * Ambil user yang baru daftar
     * Parameter: limit
     */
    public function recentUsers(): ResponseInterface
    {
        try {
            $batas = $this->request->getGet('limit');
            
            if(empty($batas) || !is_numeric($batas)) {
                $batas = 10;
            }

            $builder = $this->db->table('users');
            $builder->select('id, nama_lengkap, email, no_hp, role, dibuat_pada');
            $builder->orderBy('dibuat_pada', 'DESC');
            $builder->limit($batas);
            $query = $builder->get();
            $dataUser = $query->getResultArray();

            return $this->response->setJSON([
                'status' => 200,
                'data' => $dataUser
            ]);
            
        } catch (\Exception $e) {
            log_message('error', '[Dashboard] Gagal ambil recent users: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => 500,
                'error' => 'Gagal mengambil data user terbaru.'
            ]);
        }
    }

    /**
     * GET /api/admin/dashboard/monthly-chart
     * Data buat chart booking 12 bulan terakhir
     */
    public function monthlyChart(): ResponseInterface
    {
        try {
            // Hitung tanggal 12 bulan yang lalu
            $setahunLalu = date('Y-m-d', strtotime('-12 months'));

            $builder = $this->db->table('bookings');
            $builder->select("DATE_FORMAT(dibuat_pada, '%Y-%m') as bulan, COUNT(*) as jumlah_booking, SUM(total) as total_pendapatan");
            $builder->where('dibuat_pada >=', $setahunLalu . ' 00:00:00');
            $builder->groupBy('bulan');
            $builder->orderBy('bulan', 'ASC');
            $query = $builder->get();
            $dataChart = $query->getResultArray();

            return $this->response->setJSON([
                'status' => 200,
                'data' => $dataChart
            ]);
            
        } catch (\Exception $e) {
            log_message('error', '[Dashboard] Gagal ambil chart data: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => 500,
                'error' => 'Gagal mengambil data chart.'
            ]);
        }
    }

    /**
     * GET /api/admin/dashboard/status-breakdown
     * Breakdown jumlah booking berdasarkan status
     */
    public function statusBreakdown(): ResponseInterface
    {
        try {
            $builder = $this->db->table('bookings');
            $builder->select('status, COUNT(*) as jumlah');
            $builder->groupBy('status');
            $query = $builder->get();
            $breakdown = $query->getResultArray();

            return $this->response->setJSON([
                'status' => 200,
                'data' => $breakdown
            ]);
            
        } catch (\Exception $e) {
            log_message('error', '[Dashboard] Gagal ambil status breakdown: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => 500,
                'error' => 'Gagal mengambil data status booking.'
            ]);
        }
    }
}