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
        // Cek login
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek role admin
        $db = db_connect();
        $user = $db->table('users')->where('id', $user_id)->get()->getRow();
        if (!$user || $user->role !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak. Anda bukan admin.');
        }

        // Get statistics

        // Users statistics
        $total_users = $db->table('users')->countAllResults();
        $users_this_month = $db->table('users')
            ->where('MONTH(dibuat_pada)', date('m'))
            ->where('YEAR(dibuat_pada)', date('Y'))
            ->countAllResults();

        // Bookings statistics
        $total_bookings = $db->table('bookings')->countAllResults();
        $bookings_this_month = $db->table('bookings')
            ->where('MONTH(dibuat_pada)', date('m'))
            ->where('YEAR(dibuat_pada)', date('Y'))
            ->countAllResults();
        $completed_bookings = $db->table('bookings')
            ->where('status', 'selesai')
            ->countAllResults();
        $proses_bookings = $db->table('bookings')
            ->where('status', 'proses')
            ->countAllResults();

        // Revenue
        $revenue = $db->table('bookings')
            ->selectSum('total')
            ->where('MONTH(dibuat_pada)', date('m'))
            ->where('YEAR(dibuat_pada)', date('Y'))
            ->get()
            ->getRow();
        $total_revenue = $revenue->total ?? 0;

        // Recent bookings - tampilkan semua
        $recent_bookings = $db->table('bookings')
            ->select('bookings.*, users.nama_lengkap as customer_name, users.no_hp')
            ->join('users', 'bookings.id_user = users.id')
            ->orderBy('bookings.dibuat_pada', 'DESC')
            ->get()
            ->getResultArray();

        // Pending bookings
        $pending_count = $db->table('bookings')
            ->where('status', 'pending')
            ->countAllResults();
        $pending_bookings = $db->table('bookings')
            ->select('bookings.*, users.nama_lengkap as customer_name')
            ->join('users', 'bookings.id_user = users.id')
            ->where('bookings.status', 'pending')
            ->orderBy('bookings.dibuat_pada', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        // Service statistics
        $service_stats = $db->table('bookings')
            ->select('layanan as service, COUNT(*) as count')
            ->groupBy('layanan')
            ->orderBy('count', 'DESC')
            ->get()
            ->getResultArray();

        // Recent users
        $recent_users = $db->table('users')
            ->select('id, nama_lengkap as full_name, email, dibuat_pada as created_at')
            ->orderBy('dibuat_pada', 'DESC')
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
            'proses_bookings' => $proses_bookings,
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
