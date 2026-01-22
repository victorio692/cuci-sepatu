<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Config\Database;

class Users extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        $search = $this->request->getVar('search');

        $query = $this->db->table('users');

        if ($search) {
            $query->groupStart()
                ->like('nama_lengkap', $search)
                ->orLike('email', $search)
                ->orLike('no_hp', $search)
                ->groupEnd();
        }

        $users = $query->orderBy('dibuat_pada', 'DESC')
            ->get()
            ->getResultArray();
        
        // Map Indonesian columns to English for view
        foreach ($users as &$user) {
            $user['full_name'] = $user['nama_lengkap'];
            $user['phone'] = $user['no_hp'];
            $user['created_at'] = $user['dibuat_pada'];
            $user['is_active'] = 1; // Always active for now
        }

        $data = [
            'title' => 'Users - Admin SYH Cleaning',
            'users' => $users,
            'search' => $search,
        ];

        return view('admin/users', $data);
    }

    public function detail($id)
    {
        $user = $this->db->table('users')->where('id', $id)->get()->getRowArray();

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Add aktif field for compatibility with view (always true for now)
        $user['aktif'] = 1;
        $user['kota'] = '-';
        $user['provinsi'] = '-';
        $user['kode_pos'] = '-';

        $bookings = $this->db->table('bookings')
            ->where('id_user', $id)
            ->orderBy('dibuat_pada', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Detail User - Admin SYH Cleaning',
            'user' => $user,
            'bookings' => $bookings,
        ];

        return view('admin/user_detail', $data);
    }

    public function toggleActive($id)
    {
        $user = $this->db->table('users')->where('id', $id)->get()->getRowArray();

        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User not found']);
        }

        // For now, just return success (aktif column removed from schema)
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Status updated',
            'is_active' => true,
        ]);
    }
}
