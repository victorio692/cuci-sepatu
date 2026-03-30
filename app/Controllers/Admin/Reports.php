<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Config\Database;

class Reports extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        $db = db_connect();

        // Ambil rentang tanggal dari parameter query, default ke bulan ini
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-t');

        // Statistik booking
        $total_bookings = $db->table('bookings')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDate . ' 23:59:59')
            ->countAllResults();

        $completed_bookings = $db->table('bookings')
            ->where('status', 'selesai')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDate . ' 23:59:59')
            ->countAllResults();

        $pending_bookings = $db->table('bookings')
            ->where('status', 'pending')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDate . ' 23:59:59')
            ->countAllResults();

        $cancelled_bookings = $db->table('bookings')
            ->where('status', 'batal')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDate . ' 23:59:59')
            ->countAllResults();

        // Pendapatan
        $revenue = $db->table('bookings')
            ->selectSum('total')
            ->where('status', 'selesai')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDate . ' 23:59:59')
            ->get()
            ->getRow();
        $total_revenue = $revenue->total ?? 0;

        // Statistik layanan
        $service_stats = $db->table('bookings')
            ->select('layanan as service, COUNT(*) as count, COALESCE(SUM(total), 0) as revenue')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDate . ' 23:59:59')
            ->groupBy('layanan')
            ->orderBy('count', 'DESC')
            ->get()
            ->getResultArray();

        // Data booking harian untuk grafik
        $daily_bookings = $db->table('bookings')
            ->select('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDate . ' 23:59:59')
            ->groupBy('DATE(created_at)')
            ->orderBy('date', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Laporan - Admin SYH Cleaning',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_bookings' => $total_bookings,
            'completed_bookings' => $completed_bookings,
            'pending_bookings' => $pending_bookings,
            'cancelled_bookings' => $cancelled_bookings,
            'total_revenue' => $total_revenue,
            'service_stats' => $service_stats,
            'daily_bookings' => $daily_bookings,
        ];

        return view('admin/reports', $data);
    }

    public function print()
    {
        // logika sama dengan index(), tapi kita akan load view yang berbeda untuk cetak
        $db = db_connect();
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-t');

        
        $bookings = $db->table('bookings')
            ->select('bookings.*, users.nama_lengkap as customer_name')
            ->join('users', 'bookings.id_user = users.id')
            ->where('bookings.created_at >=', $startDate)
            ->where('bookings.created_at <=', $endDate . ' 23:59:59')
            ->orderBy('bookings.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Cetak Laporan',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'bookings' => $bookings,
        ];

        return view('admin/reports_print', $data);
    }

    /**
     * Export reports to Excel format (CSV)
     */
    public function exportExcel()
    {
        $db = db_connect();
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-t');

        try {
            // Get statistics
            $stats = $db->table('bookings')
                ->selectSum('total', 'total_revenue')
                ->selectCount('id', 'total_bookings')
                ->where('created_at >=', $startDate)
                ->where('created_at <=', $endDate . ' 23:59:59')
                ->get()
                ->getRow();

            $completedCount = $db->table('bookings')
                ->where('status', 'selesai')
                ->where('created_at >=', $startDate)
                ->where('created_at <=', $endDate . ' 23:59:59')
                ->countAllResults();

            $pendingCount = $db->table('bookings')
                ->where('status', 'pending')
                ->where('created_at >=', $startDate)
                ->where('created_at <=', $endDate . ' 23:59:59')
                ->countAllResults();

            $cancelledCount = $db->table('bookings')
                ->where('status', 'batal')
                ->where('created_at >=', $startDate)
                ->where('created_at <=', $endDate . ' 23:59:59')
                ->countAllResults();

            // Get service statistics
            $serviceStats = $db->table('bookings')
                ->select('layanan, COUNT(*) as jumlah, COALESCE(SUM(total), 0) as pendapatan')
                ->where('created_at >=', $startDate)
                ->where('created_at <=', $endDate . ' 23:59:59')
                ->groupBy('layanan')
                ->orderBy('jumlah', 'DESC')
                ->get()
                ->getResultArray();

            // Get bookings data with user info
            $bookings = $db->table('bookings')
                ->select('bookings.id, bookings.id_user, bookings.layanan, bookings.created_at, bookings.status, bookings.total, users.nama_lengkap, users.no_hp')
                ->join('users', 'bookings.id_user = users.id')
                ->where('bookings.created_at >=', $startDate)
                ->where('bookings.created_at <=', $endDate . ' 23:59:59')
                ->orderBy('bookings.created_at', 'DESC')
                ->get()
                ->getResultArray();

            // Create CSV content
            $csv = "\xEF\xBB\xBF"; // UTF-8 BOM
            
            // Header
            $csv .= "SYH CLEANING - LAPORAN PESANAN\n";
            $csv .= "Jasa Cuci Sepatu Profesional\n\n";
            
            // Period info
            $csv .= "PERIODE LAPORAN\n";
            $csv .= "Dari," . date('d/m/Y', strtotime($startDate)) . "\n";
            $csv .= "Sampai," . date('d/m/Y', strtotime($endDate)) . "\n";
            $csv .= "Tanggal Cetak," . date('d/m/Y H:i:s') . "\n\n";
            
            // Summary statistics
            $csv .= "RINGKASAN STATISTIK\n";
            $csv .= "Metrik,Nilai\n";
            $csv .= "Total Pesanan," . ($stats->total_bookings ?? 0) . "\n";
            $csv .= "Pesanan Selesai," . $completedCount . "\n";
            $csv .= "Menunggu Proses," . $pendingCount . "\n";
            $csv .= "Pesanan Batal," . $cancelledCount . "\n";
            $csv .= "Total Pendapatan,Rp " . number_format($stats->total_revenue ?? 0, 0, ',', '.') . "\n";
            $csv .= "Rata-rata per Pesanan,Rp " . number_format(($stats->total_bookings > 0 ? ($stats->total_revenue ?? 0) / $stats->total_bookings : 0), 0, ',', '.') . "\n\n";
            
            // Service statistics
            $csv .= "STATISTIK PER LAYANAN\n";
            $csv .= "No,Layanan,Jumlah Pesanan,Total Pendapatan,Rata-rata\n";
            $no = 1;
            foreach ($serviceStats as $stat) {
                $serviceName = match($stat['layanan']) {
                    'fast-cleaning' => 'Fast Cleaning',
                    'deep-cleaning' => 'Deep Cleaning',
                    'white-shoes' => 'White Shoes',
                    'suede-treatment' => 'Suede Treatment',
                    'unyellowing' => 'Unyellowing',
                    'repair' => 'Repair',
                    'coating' => 'Coating',
                    'dyeing' => 'Dyeing',
                    default => ucfirst(str_replace('-', ' ', $stat['layanan']))
                };
                
                $average = $stat['jumlah'] > 0 ? $stat['pendapatan'] / $stat['jumlah'] : 0;
                $csv .= $no . "," . $serviceName . "," . $stat['jumlah'] . ",Rp " . number_format($stat['pendapatan'], 0, ',', '.') . ",Rp " . number_format($average, 0, ',', '.') . "\n";
                $no++;
            }
            
            // Detail bookings
            $csv .= "\nDETAIL PESANAN\n";
            $csv .= "No,ID Pesanan,Pelanggan,No HP,Layanan,Tanggal,Status,Total\n";
            
            $no = 1;
            foreach ($bookings as $booking) {
                $serviceName = match($booking['layanan']) {
                    'fast-cleaning' => 'Fast Cleaning',
                    'deep-cleaning' => 'Deep Cleaning',
                    'white-shoes' => 'White Shoes',
                    'suede-treatment' => 'Suede Treatment',
                    'unyellowing' => 'Unyellowing',
                    'repair' => 'Repair',
                    'coating' => 'Coating',
                    'dyeing' => 'Dyeing',
                    default => ucfirst(str_replace('-', ' ', $booking['layanan']))
                };

                $statusText = match($booking['status']) {
                    'pending' => 'Pending',
                    'diproses' => 'Diproses',
                    'selesai' => 'Selesai',
                    'batal' => 'Batal',
                    default => $booking['status']
                };

                // Safe array access
                $customerName = isset($booking['nama_lengkap']) ? $booking['nama_lengkap'] : '-';
                $phoneNumber = isset($booking['no_hp']) ? $booking['no_hp'] : '-';

                $csv .= $no . "," . $booking['id'] . "," . $customerName . "," . $phoneNumber . "," . $serviceName . "," . date('d/m/Y', strtotime($booking['created_at'])) . "," . $statusText . ",Rp " . number_format($booking['total'], 0, ',', '.') . "\n";
                $no++;
            }
            
            // Footer
            $csv .= "\n\nLaporan ini dibuat oleh sistem SYH Cleaning\n";
            $csv .= "Untuk pertanyaan lebih lanjut, silakan hubungi admin\n";

            // Set header untuk download
            $filename = 'Laporan_Pesanan_' . $startDate . '_' . $endDate . '.csv';
            
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Pragma: no-cache');
            header('Expires: 0');
            
            echo $csv;
            exit;
        } catch (\Exception $e) {
            $this->response->setStatusCode(500);
            return $this->response->setJSON([
                'error' => 'Gagal export Excel: ' . $e->getMessage()
            ]);
        }
    }
}
