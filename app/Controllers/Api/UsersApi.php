<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class UsersApi extends BaseController
{
    use ResponseTrait;
    
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return $this->failUnauthorized('Silakan login terlebih dahulu');
        }

        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if (!$user || $user['role'] !== 'admin') {
            return $this->failForbidden('Akses ditolak. Hanya admin yang bisa mengakses');
        }

        $search = $this->request->getGet('search');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->request->getGet('per_page') ?? 10;
        $role = $this->request->getGet('role'); // Filter by role

        $builder = $this->db->table('users');

        if ($search) {
            $builder->groupStart()
                ->like('nama_lengkap', $search)
                ->orLike('email', $search)
                ->orLike('no_hp', $search)
                ->groupEnd();
        }

        if ($role) {
            $builder->where('role', $role);
        }

        
        $totalUsers = $builder->countAllResults(false);

        $users = $builder->orderBy('dibuat_pada', 'DESC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResultArray();

        
        foreach ($users as &$user) {
            unset($user['password_hash']);
        }

        return $this->respond([
            'success' => true,
            'data' => [
                'users' => $users,
                'pagination' => [
                    'current_page' => (int)$page,
                    'per_page' => (int)$perPage,
                    'total' => $totalUsers,
                    'total_pages' => ceil($totalUsers / $perPage)
                ]
            ]
        ]);
    }

    
    public function detail($id)
    {
        // Check if admin
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return $this->failUnauthorized('Silakan login terlebih dahulu');
        }

        $currentUser = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if (!$currentUser || $currentUser['role'] !== 'admin') {
            return $this->failForbidden('Akses ditolak. Hanya admin yang bisa mengakses');
        }

        $user = $this->db->table('users')->where('id', $id)->get()->getRowArray();

        if (!$user) {
            return $this->failNotFound('User tidak ditemukan');
        }

        
        unset($user['password_hash']);

        $bookings = $this->db->table('bookings')
            ->where('id_user', $id)
            ->orderBy('dibuat_pada', 'DESC')
            ->get()
            ->getResultArray();

        
        $stats = [
            'total_bookings' => count($bookings),
            'pending' => 0,
            'diproses' => 0,
            'selesai' => 0,
            'batal' => 0,
            'total_spent' => 0
        ];

        foreach ($bookings as $booking) {
            $stats[$booking['status']] = ($stats[$booking['status']] ?? 0) + 1;
            if ($booking['status'] === 'selesai') {
                $stats['total_spent'] += $booking['total'];
            }
        }

        return $this->respond([
            'success' => true,
            'data' => [
                'user' => $user,
                'bookings' => $bookings,
                'statistics' => $stats
            ]
        ]);
    }

    
    public function create()
    {
        // Check if admin
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return $this->failUnauthorized('Silakan login terlebih dahulu');
        }

        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if (!$user || $user['role'] !== 'admin') {
            return $this->failForbidden('Akses ditolak. Hanya admin yang bisa mengakses');
        }

        
        $json = $this->request->getJSON(true);

       
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'no_hp' => 'required|min_length[10]',
            'password' => 'required|min_length[6]',
            'role' => 'required|in_list[customer,admin]',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'nama_lengkap' => $json['nama_lengkap'],
            'email' => $json['email'],
            'no_hp' => $json['no_hp'],
            'password_hash' => password_hash($json['password'], PASSWORD_DEFAULT),
            'role' => $json['role'],
            'alamat' => $json['alamat'] ?? null,
            'dibuat_pada' => date('Y-m-d H:i:s'),
            'diupdate_pada' => date('Y-m-d H:i:s')
        ];

        try {
            if ($this->db->table('users')->insert($data)) {
                $newUserId = $this->db->insertID();
                $newUser = $this->db->table('users')->where('id', $newUserId)->get()->getRowArray();
                unset($newUser['password_hash']);

                return $this->respondCreated([
                    'success' => true,
                    'message' => 'User berhasil ditambahkan',
                    'data' => $newUser
                ]);
            }

            return $this->failServerError('Gagal menambahkan user');
        } catch (\Exception $e) {
            return $this->failServerError('Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    
    public function update($id)
    {
        // Check if admin
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return $this->failUnauthorized('Silakan login terlebih dahulu');
        }

        $currentUser = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if (!$currentUser || $currentUser['role'] !== 'admin') {
            return $this->failForbidden('Akses ditolak. Hanya admin yang bisa mengakses');
        }

        $user = $this->db->table('users')->where('id', $id)->get()->getRowArray();
        if (!$user) {
            return $this->failNotFound('User tidak ditemukan');
        }

        $json = $this->request->getJSON(true);

        
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'no_hp' => 'required|min_length[10]',
            'role' => 'required|in_list[customer,admin]',
        ];

        if (isset($json['password']) && !empty($json['password'])) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'nama_lengkap' => $json['nama_lengkap'],
            'email' => $json['email'],
            'no_hp' => $json['no_hp'],
            'role' => $json['role'],
            'alamat' => $json['alamat'] ?? $user['alamat'],
            'diupdate_pada' => date('Y-m-d H:i:s')
        ];

        // Update password if provided
        if (isset($json['password']) && !empty($json['password'])) {
            $data['password_hash'] = password_hash($json['password'], PASSWORD_DEFAULT);
        }

        try {
            if ($this->db->table('users')->where('id', $id)->update($data)) {
                $updatedUser = $this->db->table('users')->where('id', $id)->get()->getRowArray();
                unset($updatedUser['password_hash']);

                return $this->respond([
                    'success' => true,
                    'message' => 'User berhasil diupdate',
                    'data' => $updatedUser
                ]);
            }

            return $this->failServerError('Gagal mengupdate user');
        } catch (\Exception $e) {
            return $this->failServerError('Gagal mengupdate user: ' . $e->getMessage());
        }
    }

    
    public function delete($id)
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return $this->failUnauthorized('Silakan login terlebih dahulu');
        }

        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if (!$user || $user['role'] !== 'admin') {
            return $this->failForbidden('Akses ditolak. Hanya admin yang bisa mengakses');
        }

        $targetUser = $this->db->table('users')->where('id', $id)->get()->getRowArray();
        if (!$targetUser) {
            return $this->failNotFound('User tidak ditemukan');
        }

        if ($id == $user_id) {
            return $this->fail('Tidak dapat menghapus akun sendiri');
        }

        $bookingCount = $this->db->table('bookings')->where('id_user', $id)->countAllResults();

        if ($bookingCount > 0) {
            return $this->fail('Tidak dapat menghapus user yang memiliki booking. Total booking: ' . $bookingCount);
        }

        try {
            if ($this->db->table('users')->where('id', $id)->delete()) {
                return $this->respond([
                    'success' => true,
                    'message' => 'User berhasil dihapus'
                ]);
            }

            return $this->failServerError('Gagal menghapus user');
        } catch (\Exception $e) {
            return $this->failServerError('Gagal menghapus user: ' . $e->getMessage());
        }
    }

    
    public function toggleActive($id)
    {
        // Check if admin
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return $this->failUnauthorized('Silakan login terlebih dahulu');
        }

        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if (!$user || $user['role'] !== 'admin') {
            return $this->failForbidden('Akses ditolak. Hanya admin yang bisa mengakses');
        }

        $targetUser = $this->db->table('users')->where('id', $id)->get()->getRowArray();
        if (!$targetUser) {
            return $this->failNotFound('User tidak ditemukan');
        }

        return $this->respond([
            'success' => true,
            'message' => 'Status updated',
            'is_active' => true
        ]);
    }

    public function statistics()
    {
        
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return $this->failUnauthorized('Silakan login terlebih dahulu');
        }

        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if (!$user || $user['role'] !== 'admin') {
            return $this->failForbidden('Akses ditolak. Hanya admin yang bisa mengakses');
        }

        $totalUsers = $this->db->table('users')->countAllResults();
        $totalCustomers = $this->db->table('users')->where('role', 'customer')->countAllResults();
        $totalAdmins = $this->db->table('users')->where('role', 'admin')->countAllResults();

        $firstDayOfMonth = date('Y-m-01 00:00:00');
        $newUsersThisMonth = $this->db->table('users')
            ->where('dibuat_pada >=', $firstDayOfMonth)
            ->countAllResults();

        return $this->respond([
            'success' => true,
            'data' => [
                'total_users' => $totalUsers,
                'total_customers' => $totalCustomers,
                'total_admins' => $totalAdmins,
                'new_users_this_month' => $newUsersThisMonth
            ]
        ]);
    }
}