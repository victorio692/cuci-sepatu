<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Config\Database;

class Dashboard extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        // Get statistics
        $db = db_connect();

        // Users statistics
        $total_users = $db->table('users')->countAllResults();
        $users_this_month = $db->table('users')
            ->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->countAllResults();

        // Bookings statistics
        $total_bookings = $db->table('bookings')->countAllResults();
        $bookings_this_month = $db->table('bookings')
            ->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->countAllResults();
        $completed_bookings = $db->table('bookings')
            ->where('status', 'completed')
            ->countAllResults();

        // Revenue
        $revenue = $db->table('bookings')
            ->selectSum('total')
            ->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->get()
            ->getRow();
        $total_revenue = $revenue->total ?? 0;

        // Recent bookings
        $recent_bookings = $db->table('bookings')
            ->select('bookings.*, users.full_name as customer_name')
            ->join('users', 'bookings.user_id = users.id')
            ->orderBy('bookings.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        // Pending bookings
        $pending_count = $db->table('bookings')
            ->where('status', 'pending')
            ->countAllResults();
        $pending_bookings = $db->table('bookings')
            ->select('bookings.*, users.full_name as customer_name')
            ->join('users', 'bookings.user_id = users.id')
            ->where('bookings.status', 'pending')
            ->orderBy('bookings.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        // Service statistics
        $service_stats = $db->table('bookings')
            ->select('service, COUNT(*) as count')
            ->groupBy('service')
            ->orderBy('count', 'DESC')
            ->get()
            ->getResultArray();

        // Recent users
        $recent_users = $db->table('users')
            ->select('id, full_name, email, created_at')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Dashboard Admin - SYH Cleaning',
            'total_users' => $total_users,
            'users_this_month' => $users_this_month,
            'total_bookings' => $total_bookings,
            'bookings_this_month' => $bookings_this_month,
            'completed_bookings' => $completed_bookings,
            'total_revenue' => $total_revenue,
            'recent_bookings' => $recent_bookings,
            'pending_bookings' => $pending_bookings,
            'pending_count' => $pending_count,
            'service_stats' => $service_stats,
            'recent_users' => $recent_users,
        ];

        return view('admin/dashboard', $data);
    }
}
