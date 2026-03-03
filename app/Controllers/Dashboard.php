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
        
        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        
        if (!$user) {
            return redirect()->to('/login')->with('error', 'User tidak ditemukan');
        }

        // Cek jika user adalah admin, redirect ke halaman admin
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin')->with('info', 'Anda login sebagai admin. Silakan gunakan dashboard admin.');
        }

        // Hitung jumlah pesanan berdasarkan status (untuk fallback jika JavaScript tidak berjalan)
        $statusCounts = [
            'pending' => 0,
            'disetujui' => 0,
            'proses' => 0,
            'selesai' => 0,
            'batal' => 0,
            'ditolak' => 0,
        ];

        $data = [
            'title' => 'Dashboard Saya',
            'user' => $user,
            'statusCounts' => $statusCounts
        ];

        return view('pages/dashboard', $data);

        $total_spent = $this->db->table('bookings')
            ->where('id_user', $user_id)
            ->selectSum('total')
            ->get()
            ->getRow();

        $recent_bookings = $this->db->table('bookings')
            ->where('id_user', $user_id)
            ->orderBy('dibuat_pada', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        // Get services untuk ditampilkan
        $services = $this->db->table('services')
            ->where('aktif', 1)
            ->orderBy("FIELD(kode_layanan, 'fast-cleaning', 'deep-cleaning', 'white-shoes', 'suede-treatment', 'unyellowing')", '', false)
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
            'services' => $services,
        ];

        return view('pages/dashboard', $data);
    }

    // My Bookings
    public function myBookings()
    {
        $user_id = session()->get('user_id');

        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();

        // Cek jika user adalah admin, redirect ke halaman admin bookings
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin/bookings')->with('info', 'Anda login sebagai admin. Silakan gunakan dashboard admin untuk melihat semua bookings.');
        }

        // Get status filter from query parameter
        $statusFilter = $this->request->getGet('status');

        // Get all bookings for count
        $allBookings = $this->db->table('bookings')
            ->where('id_user', $user_id)
            ->orderBy('dibuat_pada', 'DESC')
            ->get()
            ->getResultArray();

        // Filter bookings based on status
        if ($statusFilter && $statusFilter !== 'all') {
            $bookings = $this->db->table('bookings')
                ->where('id_user', $user_id)
                ->where('status', $statusFilter)
                ->orderBy('dibuat_pada', 'DESC')
                ->get()
                ->getResultArray();
        } else {
            $bookings = $allBookings;
        }

        // Count bookings by status
        $statusCounts = [
            'pending' => 0,
            'disetujui' => 0,
            'proses' => 0,
            'selesai' => 0,
            'batal' => 0,
            'ditolak' => 0,
        ];

        foreach ($allBookings as $booking) {
            if (isset($statusCounts[$booking['status']])) {
                $statusCounts[$booking['status']]++;
            }
        }

        $data = [
            'title' => 'Pesanan Saya - SYH Cleaning',
            'bookings' => $bookings,
            'allBookings' => $allBookings,
            'statusCounts' => $statusCounts,
            'user' => $user,
        ];

        return view('pages/my_bookings', $data);
    }

    // Profile
    public function profile()
    {
        $user_id = session()->get('user_id');
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();

        // Cek jika user adalah admin, redirect ke halaman admin
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin/profile')->with('info', 'Silakan gunakan dashboard admin.');
        }

        // Hitung jumlah pesanan berdasarkan status
        $statusCounts = [
            'pending' => $this->db->table('bookings')->where(['id_user' => $user_id, 'status' => 'pending'])->countAllResults(),
            'disetujui' => $this->db->table('bookings')->where(['id_user' => $user_id, 'status' => 'disetujui'])->countAllResults(),
            'proses' => $this->db->table('bookings')->where(['id_user' => $user_id, 'status' => 'proses'])->countAllResults(),
            'selesai' => $this->db->table('bookings')->where(['id_user' => $user_id, 'status' => 'selesai'])->countAllResults(),
            'batal' => $this->db->table('bookings')->where(['id_user' => $user_id, 'status' => 'batal'])->countAllResults(),
            'ditolak' => $this->db->table('bookings')->where(['id_user' => $user_id, 'status' => 'ditolak'])->countAllResults(),
        ];

        $data = [
            'title' => 'Profil - SYH Cleaning',
            'user' => $user,
            'statusCounts' => $statusCounts
        ];

        return view('pages/profile', $data);
    }

    // Profile Detail (untuk edit detail)
    public function profileDetail()
    {
        $user_id = session()->get('user_id');
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();

        // Cek jika user adalah admin, redirect ke halaman admin
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin/profile')->with('info', 'Silakan gunakan dashboard admin.');
        }

        $data = [
            'title' => 'Detail Profil - SYH Cleaning',
            'user' => $user
        ];

        return view('pages/profile_detail', $data);
    }

    // Update Profile
    public function updateProfile()
    {
        $user_id = session()->get('user_id');

        // Cek jika user adalah admin
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin')->with('error', 'Akses ditolak.');
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('full_name'),
            'no_hp' => $this->request->getPost('phone'),
            'alamat' => $this->request->getPost('address'),
        ];

        $this->db->table('users')->update($data, ['id' => $user_id]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // Update Profile Photo
    public function updateProfilePhoto()
    {
        $user_id = session()->get('user_id');

        // Cek jika user adalah admin
        $checkUser = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if ($checkUser && $checkUser['role'] === 'admin') {
            return redirect()->to('/admin')->with('error', 'Akses ditolak.');
        }

        // Validate file upload
        $validationRule = [
            'profile_photo' => [
                'label' => 'Foto Profil',
                'rules' => 'uploaded[profile_photo]'
                    . '|is_image[profile_photo]'
                    . '|mime_in[profile_photo,image/jpg,image/jpeg,image/png]'
                    . '|max_size[profile_photo,2048]', // 2MB in KB
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()->with('error', 'Gagal unggah foto. Pastikan file format PNG/JPG/JPEG dan maksimal 2MB');
        }

        // Get old photo
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        $oldPhoto = $user['foto_profil'];

        // Handle file upload
        $file = $this->request->getFile('profile_photo');
        $fileName = null;
        
        if ($file->isValid() && !$file->hasMoved()) {
            // Generate unique filename
            $fileName = 'profile_' . $user_id . '_' . time() . '.' . $file->getExtension();
            // Move to public/uploads directory
            $uploadPath = FCPATH . 'uploads';
            
            // Create directory if not exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $file->move($uploadPath, $fileName);

            // Delete old photo if exists
            if ($oldPhoto && file_exists($uploadPath . '/' . $oldPhoto)) {
                unlink($uploadPath . '/' . $oldPhoto);
            }
        }

        // Update database
        $this->db->table('users')->update([
            'foto_profil' => $fileName
        ], ['id' => $user_id]);

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    // Change Password
    public function changePassword()
    {
        $user_id = session()->get('user_id');
        $current_password = $this->request->getPost('current_password');
        $new_password = $this->request->getPost('new_password');

        // Get user
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();

        // Cek jika user adalah admin
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin')->with('error', 'Akses ditolak.');
        }

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

    // Change Password Page
    public function changePasswordPage()
    {
        $user_id = session()->get('user_id');
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();

        // Cek jika user adalah admin
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin')->with('info', 'Silakan gunakan dashboard admin.');
        }

        $data = [
            'title' => 'Ubah Password - SYH Cleaning',
            'user' => $user
        ];

        return view('auth/change_password', $data);
    }

    // Change Email Page
    public function changeEmailPage()
    {
        $user_id = session()->get('user_id');
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();

        // Cek jika user adalah admin
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin')->with('info', 'Silakan gunakan dashboard admin.');
        }

        $data = [
            'title' => 'Ubah Email - SYH Cleaning',
            'user' => $user
        ];

        return view('pages/change_email', $data);
    }

    // Change Email
    public function changeEmail()
    {
        $user_id = session()->get('user_id');
        $new_email = $this->request->getPost('new_email');
        $current_password = $this->request->getPost('current_password');

        // Get user
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();

        // Cek jika user adalah admin
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin')->with('error', 'Akses ditolak.');
        }

        // Verify current password
        if (!password_verify($current_password, $user['password_hash'])) {
            return redirect()->back()->with('error', 'Password tidak sesuai');
        }

        // Check if email already exists
        $emailExists = $this->db->table('users')->where('email', $new_email)->where('id !=', $user_id)->countAllResults();
        if ($emailExists) {
            return redirect()->back()->with('error', 'Email sudah terdaftar');
        }

        // Update email
        $this->db->table('users')->update([
            'email' => $new_email
        ], ['id' => $user_id]);

        return redirect()->to('/profile/detail')->with('success', 'Email berhasil diubah!');
    }

    // Change Phone Page
    public function changePhonePage()
    {
        $user_id = session()->get('user_id');
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();

        // Cek jika user adalah admin
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin')->with('info', 'Silakan gunakan dashboard admin.');
        }

        $data = [
            'title' => 'Ubah Nomor Telepon - SYH Cleaning',
            'user' => $user
        ];

        return view('pages/change_phone', $data);
    }

    // Change Phone
    public function changePhone()
    {
        $user_id = session()->get('user_id');
        $new_phone = $this->request->getPost('new_phone');
        $current_password = $this->request->getPost('current_password');

        // Get user
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Cek jika user adalah admin
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin')->with('error', 'Akses ditolak.');
        }

        // Verify current password
        if (!password_verify($current_password, $user['password_hash'])) {
            return redirect()->back()->with('error', 'Password tidak sesuai');
        }

        // Validate phone format
        if (empty($new_phone)) {
            return redirect()->back()->with('error', 'Nomor telepon tidak boleh kosong');
        }

        // Remove non-numeric characters for validation
        $phone_digits = preg_replace('/\D/', '', $new_phone);
        
        // Check if phone starts with 08 and has at least 11 digits
        if (!preg_match('/^08\d{9,}$/', $phone_digits)) {
            return redirect()->back()->with('error', 'Nomor telepon harus dimulai dengan 08 dan minimal 11 digit');
        }

        // Update phone
        if ($this->db->table('users')->update([
            'no_hp' => $new_phone
        ], ['id' => $user_id])) {
            return redirect()->to('/profile/detail')->with('success', 'Nomor telepon berhasil diubah!');
        }

        return redirect()->back()->with('error', 'Gagal mengubah nomor telepon');
    }
}

