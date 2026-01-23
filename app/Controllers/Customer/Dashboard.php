<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use Config\Database;

class Dashboard extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Dashboard index page - displays summary and statistics
     */
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('user_id')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user_id = session()->get('user_id');

        // Get user data
        $user = $this->db->table('users')
            ->where('id', $user_id)
            ->get()
            ->getRow();

        if (!$user) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'User tidak ditemukan');
        }

        // Get booking statistics
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

        $total_spent_value = $total_spent->total ?? 0;

        // Get recent bookings (last 5)
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
            'total_spent' => $total_spent_value,
            'recent_bookings' => $recent_bookings,
        ];

        return view('customer/dashboard', $data);
    }

    /**
     * My bookings page - displays all customer bookings
     */
    public function myBookings()
    {
        // Check if user is logged in
        if (!session()->get('user_id')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user_id = session()->get('user_id');

        // Get all bookings with pagination
        $perPage = 10;
        $page = $this->request->getVar('page') ?? 1;
        $offset = ($page - 1) * $perPage;

        $bookings = $this->db->table('bookings')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->limit($perPage, $offset)
            ->get()
            ->getResultArray();

        $total_bookings = $this->db->table('bookings')
            ->where('user_id', $user_id)
            ->countAllResults();

        $pager = \Config\Services::pager();
        $pager->makeLinks($page, $perPage, $total_bookings);

        $data = [
            'title' => 'Pesanan Saya - SYH Cleaning',
            'bookings' => $bookings,
            'pager' => $pager,
            'total_bookings' => $total_bookings,
        ];

        return view('customer/my_bookings', $data);
    }

    /**
     * Booking detail page - shows full details of a specific booking
     */
    public function bookingDetail($id)
    {
        // Check if user is logged in
        if (!session()->get('user_id')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user_id = session()->get('user_id');

        // Get booking - ensure it belongs to the user
        $booking = $this->db->table('bookings')
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->get()
            ->getRow();

        if (!$booking) {
            return redirect()->to('/customer/my-bookings')
                ->with('error', 'Pesanan tidak ditemukan atau tidak memiliki akses');
        }

        $data = [
            'title' => 'Detail Pesanan #' . $id . ' - SYH Cleaning',
            'booking' => $booking,
        ];

        return view('customer/booking_detail', $data);
    }

    /**
     * Profile page - displays user profile information
     */
    public function profile()
    {
        // Check if user is logged in
        if (!session()->get('user_id')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user_id = session()->get('user_id');

        $user = $this->db->table('users')
            ->where('id', $user_id)
            ->get()
            ->getRow();

        if (!$user) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'User tidak ditemukan');
        }

        $data = [
            'title' => 'Profil Saya - SYH Cleaning',
            'user' => $user,
        ];

        return view('customer/profile', $data);
    }

    /**
     * Update profile - handles profile form submission
     */
    public function updateProfile()
    {
        // Check if user is logged in
        if (!session()->get('user_id')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Validate CSRF token
        if (!$this->validate([
            'csrf_token' => 'required',
        ])) {
            return redirect()->back()
                ->with('error', 'CSRF token tidak valid');
        }

        $user_id = session()->get('user_id');

        // Validate input
        if (!$this->validate([
            'full_name' => 'required|min_length[3]|max_length[255]',
            'phone' => 'required|min_length[10]|max_length[15]',
            'address' => 'permit_empty|max_length[500]',
            'city' => 'permit_empty|max_length[100]',
            'province' => 'permit_empty|max_length[100]',
            'zip_code' => 'permit_empty|max_length[10]',
        ])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Validasi data gagal. Periksa kembali input Anda');
        }

        // Prepare update data
        $update_data = [
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address') ?? '',
            'city' => $this->request->getPost('city') ?? '',
            'province' => $this->request->getPost('province') ?? '',
            'zip_code' => $this->request->getPost('zip_code') ?? '',
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Update database
        $this->db->table('users')
            ->where('id', $user_id)
            ->update($update_data);

        // Update session
        session()->set('full_name', $update_data['full_name']);
        session()->set('phone', $update_data['phone']);

        return redirect()->to('/customer/profile')
            ->with('success', '✓ Profil berhasil diperbarui');
    }

    /**
     * Change password - handles password change form submission
     */
    public function changePassword()
    {
        // Check if user is logged in
        if (!session()->get('user_id')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user_id = session()->get('user_id');

        // Validate input
        if (!$this->validate([
            'current_password' => 'required|min_length[6]',
            'new_password' => 'required|min_length[8]|differs[current_password]',
            'confirm_password' => 'required|matches[new_password]',
        ])) {
            return redirect()->back()
                ->with('error', 'Password tidak valid. Password minimal 8 karakter');
        }

        // Get current user
        $user = $this->db->table('users')
            ->where('id', $user_id)
            ->get()
            ->getRow();

        if (!$user) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'User tidak ditemukan');
        }

        // Verify current password
        $current_password = $this->request->getPost('current_password');
        if (!password_verify($current_password, $user->password_hash)) {
            return redirect()->back()
                ->with('error', 'Password saat ini tidak sesuai');
        }

        // Update password
        $new_password = password_hash($this->request->getPost('new_password'), PASSWORD_BCRYPT);
        $this->db->table('users')
            ->where('id', $user_id)
            ->update([
                'password_hash' => $new_password,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        return redirect()->to('/customer/profile')
            ->with('success', '✓ Password berhasil diubah');
    }
}
