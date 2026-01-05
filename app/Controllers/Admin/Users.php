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
                ->like('full_name', $search)
                ->orLike('email', $search)
                ->orLike('phone', $search)
                ->groupEnd();
        }

        $users = $query->orderBy('created_at', 'DESC')
            ->paginate(20);

        $data = [
            'title' => 'Users - Admin SYH Cleaning',
            'users' => $users,
            'pager' => $this->db->pager,
            'search' => $search,
        ];

        return view('admin/users', $data);
    }

    public function detail($id)
    {
        $user = $this->db->table('users')->find($id);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $bookings = $this->db->table('bookings')
            ->where('user_id', $id)
            ->orderBy('created_at', 'DESC')
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
        $user = $this->db->table('users')->find($id);

        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User not found']);
        }

        $new_status = !$user->is_active;
        $this->db->table('users')->update(['is_active' => $new_status], ['id' => $id]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Status updated',
            'is_active' => $new_status,
        ]);
    }
}
