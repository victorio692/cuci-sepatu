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

        return redirect()->to('/dashboard')->with('success', 'Selamat datang!');
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
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'address' => '',
            'city' => '',
            'province' => '',
            'zip_code' => '',
            'is_active' => 1,
            'is_admin' => 0,
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
}

