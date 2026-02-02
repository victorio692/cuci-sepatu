<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class AuthApi extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\UserModel';
    protected $format = 'json';

    /**
     * Register user baru
     * POST /api/auth/register
     */
    public function register()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'no_hp' => 'required|min_length[10]|max_length[15]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ], 400);
        }

        $json = $this->request->getJSON(true);

        $data = [
            'nama_lengkap' => $json['nama_lengkap'],
            'email' => strtolower(trim($json['email'])),
            'no_hp' => $json['no_hp'],
            'password_hash' => password_hash($json['password'], PASSWORD_BCRYPT),
            'alamat' => $json['alamat'] ?? '',
            'role' => 'pelanggan',
            'dibuat_pada' => date('Y-m-d H:i:s'),
            'diupdate_pada' => date('Y-m-d H:i:s')
        ];

        try {
            $userId = $this->model->insert($data);

            if (!$userId) {
                return $this->fail([
                    'status' => 'error',
                    'message' => 'Gagal membuat akun'
                ], 500);
            }

            // Get user data tanpa password
            $user = $this->model->find($userId);
            unset($user['password_hash']);

            // Create session
            session()->set([
                'user_id' => $user['id'],
                'email' => $user['email'],
                'full_name' => $user['full_name'],
                'is_logged_in' => true,
                'is_admin' => $user['is_admin']
            ]);

            return $this->respondCreated([
                'status' => 'success',
                'message' => 'Registrasi berhasil',
                'data' => [
                    'user' => $user,
                    'token' => session_id()
                ]
            ]);

        } catch (\Exception $e) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Login user
     * POST /api/auth/login
     */
    public function login()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Email dan password harus diisi',
                'errors' => $this->validator->getErrors()
            ], 400);
        }

        $json = $this->request->getJSON(true);
        $email = strtolower(trim($json['email']));
        $password = $json['password'];

        // Cari user berdasarkan email
        $user = $this->model->where('email', $email)->first();

        if (!$user) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Email atau password salah'
            ], 401);
        }

        // Verify password
        if (!password_verify($password, $user['password_hash'])) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Email atau password salah'
            ], 401);
        }

        // Remove password dari response
        unset($user['password_hash']);

        // Create session
        session()->set([
            'user_id' => $user['id'],
            'email' => $user['email'],
            'full_name' => $user['full_name'],
            'is_logged_in' => true,
            'is_admin' => $user['is_admin']
        ]);

        return $this->respond([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => [
                'user' => $user,
                'token' => session_id()
            ]
        ]);
    }

    /**
     * Logout user
     * POST /api/auth/logout
     */
    public function logout()
    {
        session()->destroy();

        return $this->respond([
            'status' => 'success',
            'message' => 'Logout berhasil'
        ]);
    }

    /**
     * Get current user profile
     * GET /api/auth/profile
     */
    public function profile()
    {
        if (!session()->get('is_logged_in')) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Unauthorized. Silakan login terlebih dahulu.'
            ], 401);
        }

        $userId = session()->get('user_id');
        $user = $this->model->find($userId);

        if (!$user) {
            return $this->fail([
                'status' => 'error',
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        unset($user['password_hash']);

        return $this->respond([
            'status' => 'success',
            'data' => [
                'user' => $user
            ]
        ]);
    }

    /**
     * Update user profile
     * PUT /api/auth/profile
     */
    public function updateProfile()
    {
        if (!session()->get('is_logged_in')) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Unauthorized. Silakan login terlebih dahulu.'
            ], 401);
        }

        $userId = session()->get('user_id');

        $rules = [
            'nama_lengkap' => 'permit_empty|min_length[3]|max_length[100]',
            'no_hp' => 'permit_empty|min_length[10]|max_length[15]',
            'alamat' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ], 400);
        }

        $json = $this->request->getJSON(true);
        $data = [];
        $allowedFields = ['nama_lengkap', 'no_hp', 'alamat'];

        foreach ($allowedFields as $field) {
            if (isset($json[$field])) {
                $data[$field] = $json[$field];
            }
        }

        if (empty($data)) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Tidak ada data yang diupdate'
            ], 400);
        }

        $data['diupdate_pada'] = date('Y-m-d H:i:s');

        try {
            $this->model->update($userId, $data);

            $user = $this->model->find($userId);
            unset($user['password_hash']);

            // Update session
            if (isset($data['nama_lengkap'])) {
                session()->set('nama_lengkap', $data['nama_lengkap']);
            }

            return $this->respond([
                'status' => 'success',
                'message' => 'Profile berhasil diupdate',
                'data' => [
                    'user' => $user
                ]
            ]);

        } catch (\Exception $e) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Gagal update profile: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change password
     * POST /api/auth/change-password
     */
    public function changePassword()
    {
        if (!session()->get('is_logged_in')) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Unauthorized. Silakan login terlebih dahulu.'
            ], 401);
        }

        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ], 400);
        }

        $json = $this->request->getJSON(true);
        $userId = session()->get('user_id');
        $user = $this->model->find($userId);

        // Verify old password
        if (!password_verify($json['old_password'], $user['password_hash'])) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Password lama tidak sesuai'
            ], 400);
        }

        try {
            $this->model->update($userId, [
                'password_hash' => password_hash($json['new_password'], PASSWORD_BCRYPT),
                'diupdate_pada' => date('Y-m-d H:i:s')
            ]);

            return $this->respond([
                'status' => 'success',
                'message' => 'Password berhasil diubah'
            ]);

        } catch (\Exception $e) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Gagal ubah password: ' . $e->getMessage()
            ], 500);
        }
    }
}
