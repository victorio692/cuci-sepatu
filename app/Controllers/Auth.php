<?php

namespace App\Controllers;

use Config\Database;

class Auth extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // tampilkan halaman login
    public function login()
    {
    if (session()->get('is_logged_in')) {

        $role = session()->get('role');

        if ($role === 'admin') {
            return redirect()->to('/admin')->with('info', 'Anda sudah login sebagai admin');
        } else {
            return redirect()->to('/')->with('info', 'Anda sudah login');
        }
    }

    return view('auth/login', ['title' => 'Login - SYH Cleaning']);
    }

    // Proses login
    public function loginSubmit()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validasi input
        if (!$this->validate([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Cari user berdasarkan email
        $user = $this->db->table('users')->where('email', $email)->get()->getRow();

        if (!$user) {
            return redirect()->back()->with('error', 'Email atau password salah');
        }

        if (isset($user->aktif) && (int)$user->aktif !== 1) {
            return redirect()->back()->with('error', 'Akun Anda telah dinonaktifkan. Hubungi admin untuk aktivasi.');
        }

        if (!password_verify($password, $user->password_hash)) {
            return redirect()->back()->with('error', 'Email atau password salah');
        }

        // Set session
        session()->set([
            'user_id' => $user->id,
            'username' => $user->fullname,
            'role' => $user->role,
            'is_logged_in' => true

        ]);

        if ($user->role === 'admin') {
            return redirect()->to('/admin')->with('success', 'Selamat datang, Admin!');
        } else {
            return redirect()->to('/')->with('success', 'Selamat datang!');
        }
    }

    // tampilkan halaman register
    public function register()
    {
        // Redirect jika sudah login
        if (session()->get('user_id')) {
            $user = $this->db->table('users')->where('id', session()->get('user_id'))->get()->getRow();
            if ($user) {
                if ($user->role === 'admin') {
                    return redirect()->to('/admin')->with('info', 'Anda sudah login sebagai admin');
                } else {
                    return redirect()->to('/')->with('info', message: 'Anda sudah login');
                }
            }
        }
        
        return view('auth/register', ['title' => 'Daftar - SYH Cleaning']);
    }

    // Proses register
    public function registerSubmit()
    {
        $data = [
            'nama_lengkap' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('phone'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'alamat' => '',
            'role' => 'pelanggan',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Validasi input
        if (!$this->validate([
            'full_name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'phone' => 'required|min_length[10]',
            'password' => 'required|min_length[6]',
        ])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // cek email sudah terdaftar
        $existing = $this->db->table('users')->where('email', $data['email'])->get()->getRow();
        if ($existing) {
            return redirect()->back()->with('error', 'Email sudah terdaftar');
        }

        // Simpan user baru
        $this->db->table('users')->insert($data);
        $user_id = $this->db->insertID();

        // redirect ke login dengan pesan sukses
        return redirect()->to('/login')->with('success', 'Pendaftaran berhasil! Silakan login dengan akun Anda.');
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Anda telah logout.');
    }

    // Lupa password
    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    public function forgotPasswordSubmit()
    {
        $email = $this->request->getPost('email');
        $noHp = $this->request->getPost('no_hp');

        // Validasi input
        if (empty($email) || empty($noHp)) {
            return redirect()->back()->with('error', 'Email dan nomor HP harus diisi');
        }

        // Cek user berdasarkan email dan nomor HP
        $user = $this->db->table('users')
            ->where('email', $email)
            ->where('no_hp', $noHp)
            ->get()
            ->getRowArray();

        if (!$user) {
            return redirect()->back()->with('error', 'Email atau nomor HP tidak sesuai dengan data kami');
        }

        // Generate reset token
        $token = bin2hex(random_bytes(32));
        
        // Simpan token di session (atau bisa juga disimpan di database dengan expiry)
        session()->set('reset_token', $token);
        session()->set('reset_email', $email);
        session()->setTempdata('reset_token', $token, 1800); // 30 minutes

        return redirect()->to('/reset-password/' . $token)->with('success', 'Silakan reset password Anda');
    }

    public function resetPassword($token = null)
    {
        if (!$token || $token !== session()->get('reset_token')) {
            return redirect()->to('/forgot-password')->with('error', 'Token tidak valid atau sudah kadaluarsa');
        }

        $email = session()->get('reset_email');
        
        return view('auth/reset_password', ['email' => $email, 'token' => $token]);
    }

    public function resetPasswordSubmit()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validasi token
        if ($token !== session()->get('reset_token')) {
            return redirect()->to('/forgot-password')->with('error', 'Token tidak valid');
        }

        // Validasi password
        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter');
        }

        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak sesuai');
        }

        // Ambil email dari session
        $email = session()->get('reset_email');

        // Update password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->db->table('users')
            ->where('email', $email)
            ->update(['password_hash' => $hashedPassword]);

        // Hapus session
        session()->remove('reset_token');
        session()->remove('reset_email');

        return redirect()->to('/login')->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
    }
}

