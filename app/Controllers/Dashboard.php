<?php

namespace App\Controllers;

use Config\Database;

class Dashboard extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Dashboard Index
    public function index()
    {
        $user_id = session()->get('user_id');
        $user = $this->db->table('users')->find($user_id);

        // Get booking stats
        $total_bookings = $this->db->table('bookings')
            ->where('user_id', $user_id)
            ->countAllResults();

        $active_bookings = $this->db->table('bookings')
            ->where('user_id', $user_id)
            ->whereIn('status', ['pending', 'approved', 'in_progress'])
            ->countAllResults();

        $completed_bookings = $this->db->table('bookings')
            ->where('user_id', $user_id)
            ->where('status', 'completed')
            ->countAllResults();

        $total_spent = $this->db->table('bookings')
            ->where('user_id', $user_id)
            ->selectSum('total')
            ->get()
            ->getRow();

        $recent_bookings = $this->db->table('bookings')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Dashboard - SYH Cleaning',
            'user' => $user,
            'total_bookings' => $total_bookings,
            'active_bookings' => $active_bookings,
            'completed_bookings' => $completed_bookings,
            'total_spent' => $total_spent->total ?? 0,
            'recent_bookings' => $recent_bookings,
        ];

        return view('pages/dashboard', $data);
    }

    // My Bookings
    public function myBookings()
    {
        $user_id = session()->get('user_id');

        $bookings = $this->db->table('bookings')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Pesanan Saya - SYH Cleaning',
            'bookings' => $bookings,
        ];

        return view('pages/my_bookings', $data);
    }

    // Profile
    public function profile()
    {
        $user_id = session()->get('user_id');
        $user = $this->db->table('users')->find($user_id);

        $data = [
            'title' => 'Profil - SYH Cleaning',
            'user' => $user,
        ];

        return view('pages/profile', $data);
    }

    // Update Profile
    public function updateProfile()
    {
        $user_id = session()->get('user_id');

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'province' => $this->request->getPost('province'),
            'zip_code' => $this->request->getPost('zip_code'),
        ];

        $this->db->table('users')->update($data, ['id' => $user_id]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // Change Password
    public function changePassword()
    {
        $user_id = session()->get('user_id');
        $current_password = $this->request->getPost('current_password');
        $new_password = $this->request->getPost('new_password');

        // Get user
        $user = $this->db->table('users')->find($user_id);

        // Verify current password
        if (!password_verify($current_password, $user['password_hash'])) {
            return redirect()->back()->with('error', 'Password saat ini salah');
        }

        // Update password
        $this->db->table('users')->update([
            'password_hash' => password_hash($new_password, PASSWORD_BCRYPT)
        ], ['id' => $user_id]);

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }
}

