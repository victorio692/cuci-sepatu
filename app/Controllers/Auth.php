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

    // Show Login Page
    public function login()
    {
        return view('auth/login', ['title' => 'Login - SYH Cleaning']);
    }

    // Process Login
    public function loginSubmit()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validate
        if (!$this->validate([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Find user
        $user = $this->db->table('users')->where('email', $email)->get()->getRow();

        if (!$user || !password_verify($password, $user->password_hash)) {
            return redirect()->back()->with('error', 'Email atau password salah');
        }

        // Set session
        session()->set('user_id', $user->id);

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->to('/admin')->with('success', 'Selamat datang, Admin!');
        } else {
            return redirect()->to('/dashboard')->with('success', 'Selamat datang!');
        }
    }

    // Show Register Page
    public function register()
    {
        return view('auth/register', ['title' => 'Daftar - SYH Cleaning']);
    }

    // Process Register
    public function registerSubmit()
    {
        $data = [
            'nama_lengkap' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('phone'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'alamat' => '',
            'role' => 'pelanggan',
            'dibuat_pada' => date('Y-m-d H:i:s'),
            'diupdate_pada' => date('Y-m-d H:i:s'),
        ];

        // Validate
        if (!$this->validate([
            'full_name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'phone' => 'required|min_length[10]',
            'password' => 'required|min_length[6]',
        ])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Check if email exists
        $existing = $this->db->table('users')->where('email', $data['email'])->get()->getRow();
        if ($existing) {
            return redirect()->back()->with('error', 'Email sudah terdaftar');
        }

        // Insert user
        $this->db->table('users')->insert($data);
        $user_id = $this->db->insertID();

        // Set session
        session()->set('user_id', $user_id);

        return redirect()->to('/dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang!');
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Anda telah logout.');
    }

    // Forgot Password
    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    public function forgotPasswordSubmit()
    {
        $email = $this->request->getPost('email');
        $noHp = $this->request->getPost('no_hp');

        // Validate
        if (empty($email) || empty($noHp)) {
            return redirect()->back()->with('error', 'Email dan nomor HP harus diisi');
        }

        // Check if user exists with email and phone number
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
        
        // Store token in session (simplified for local app without email)
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

        // Validate token
        if ($token !== session()->get('reset_token')) {
            return redirect()->to('/forgot-password')->with('error', 'Token tidak valid');
        }

        // Validate password
        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter');
        }

        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak sesuai');
        }

        // Get email from session
        $email = session()->get('reset_email');

        // Update password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->db->table('users')
            ->where('email', $email)
            ->update(['password_hash' => $hashedPassword]);

        // Clear session
        session()->remove('reset_token');
        session()->remove('reset_email');

        return redirect()->to('/login')->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
    }
}

