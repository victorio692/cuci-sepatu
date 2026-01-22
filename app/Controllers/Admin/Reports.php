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

        // Get date range from query parameters
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-t');

        // Bookings statistics
        $total_bookings = $db->table('bookings')
            ->where('dibuat_pada >=', $startDate)
            ->where('dibuat_pada <=', $endDate . ' 23:59:59')
            ->countAllResults();

        $completed_bookings = $db->table('bookings')
            ->where('status', 'selesai')
            ->where('dibuat_pada >=', $startDate)
            ->where('dibuat_pada <=', $endDate . ' 23:59:59')
            ->countAllResults();

        $pending_bookings = $db->table('bookings')
            ->where('status', 'pending')
            ->where('dibuat_pada >=', $startDate)
            ->where('dibuat_pada <=', $endDate . ' 23:59:59')
            ->countAllResults();

        $cancelled_bookings = $db->table('bookings')
            ->where('status', 'batal')
            ->where('dibuat_pada >=', $startDate)
            ->where('dibuat_pada <=', $endDate . ' 23:59:59')
            ->countAllResults();

        // Revenue
        $revenue = $db->table('bookings')
            ->selectSum('total')
            ->where('status', 'selesai')
            ->where('dibuat_pada >=', $startDate)
            ->where('dibuat_pada <=', $endDate . ' 23:59:59')
            ->get()
            ->getRow();
        $total_revenue = $revenue->total ?? 0;

        // Service statistics
        $service_stats = $db->table('bookings')
            ->select('layanan as service, COUNT(*) as count, SUM(total) as revenue')
            ->where('dibuat_pada >=', $startDate)
            ->where('dibuat_pada <=', $endDate . ' 23:59:59')
            ->groupBy('layanan')
            ->orderBy('count', 'DESC')
            ->get()
            ->getResultArray();

        // Daily bookings for chart
        $daily_bookings = $db->table('bookings')
            ->select('DATE(dibuat_pada) as date, COUNT(*) as count')
            ->where('dibuat_pada >=', $startDate)
            ->where('dibuat_pada <=', $endDate . ' 23:59:59')
            ->groupBy('DATE(dibuat_pada)')
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
        // Same logic as index but with print view
        $db = db_connect();
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-t');

        // Get all data
        $bookings = $db->table('bookings')
            ->select('bookings.*, users.nama_lengkap as customer_name')
            ->join('users', 'bookings.id_user = users.id')
            ->where('bookings.dibuat_pada >=', $startDate)
            ->where('bookings.dibuat_pada <=', $endDate . ' 23:59:59')
            ->orderBy('bookings.dibuat_pada', 'DESC')
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
