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
}
