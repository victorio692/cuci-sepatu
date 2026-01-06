<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Halaman login
     */
    public function login()
    {
        // Jika sudah login, redirect sesuai role
        if (session()->has('user_id')) {
            return $this->redirectByRole();
        }

        return view('auth/login');
    }

    /**
     * Proses login
     */
    public function attemptLogin()
    {
        // Validasi input
        $rules = [
            'email_or_username' => 'required',
            'password'          => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $emailOrUsername = $this->request->getPost('email_or_username');
        $password = $this->request->getPost('password');

        // Cek login dengan UserModel
        $user = $this->userModel->login($emailOrUsername, $password);

        if ($user) {
            // Set session
            session()->set([
                'user_id'   => $user['id'],
                'nama'      => $user['nama'],
                'email'     => $user['email'],
                'username'  => $user['username'],
                'role'      => $user['role'],
                'logged_in' => true
            ]);

            // Redirect sesuai role
            if ($user['role'] === 'admin') {
                return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang, ' . $user['nama']);
            } else {
                return redirect()->to('/pelanggan/dashboard')->with('success', 'Selamat datang, ' . $user['nama']);
            }
        }

        return redirect()->back()->withInput()->with('error', 'Email/Username atau password salah');
    }

    /**
     * Halaman register
     */
    public function register()
    {
        // Jika sudah login, redirect sesuai role
        if (session()->has('user_id')) {
            return $this->redirectByRole();
        }

        return view('auth/register');
    }

    /**
     * Proses register - JANGAN auto login
     */
    public function attemptRegister()
    {
        // Validasi input
        $rules = [
            'nama'             => 'required|min_length[3]|max_length[100]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'username'         => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
            'telepon'          => 'permit_empty|numeric|min_length[10]',
        ];

        $messages = [
            'email' => [
                'is_unique' => 'Email sudah terdaftar',
            ],
            'username' => [
                'is_unique' => 'Username sudah digunakan',
            ],
            'password_confirm' => [
                'matches' => 'Konfirmasi password tidak cocok',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan data user baru (role default = pelanggan)
        $data = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'telepon'  => $this->request->getPost('telepon'),
            'alamat'   => $this->request->getPost('alamat'),
            'role'     => 'pelanggan', // Default pelanggan
        ];

        if ($this->userModel->save($data)) {
            // JANGAN auto login - redirect ke login
            return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda');
        }

        return redirect()->back()->withInput()->with('error', 'Registrasi gagal, silakan coba lagi');
    }

    /**
     * Logout
     */
    public function logout()
    {
        // Destroy session
        session()->destroy();
        
        return redirect()->to('/login')->with('success', 'Anda telah logout');
    }

    /**
     * Helper: Redirect berdasarkan role
     */
    private function redirectByRole()
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/admin/dashboard');
        }
        return redirect()->to('/pelanggan/dashboard');
    }
}

