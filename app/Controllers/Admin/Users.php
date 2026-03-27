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
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10;

        $builder = $this->db->table('users');

        if ($search) {
            $builder->groupStart()
                ->like('nama_lengkap', $search)
                ->orLike('email', $search)
                ->orLike('no_hp', $search)
                ->groupEnd();
        }

        // Hitung total untuk pagination
        $totalUsers = $builder->countAllResults(false);

        // Ambil data dengan pagination 
        $users = $builder->orderBy('created_at', 'DESC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResultArray();
        
        // Mapping kolom ke format yang digunakan di view
        foreach ($users as &$user) {
            $user['full_name'] = $user['nama_lengkap'];
            $user['phone'] = $user['no_hp'];
            $user['created_at'] = $user['created_at'];
            $user['is_active'] = 1; // Sementara selalu aktif, bisa disesuaikan jika ada kolom status di database
        }

        // Hitung pagination 
        $totalPages = ceil($totalUsers / $perPage);

        $data = [
            'title' => 'Users - Admin SYH Cleaning',
            'users' => $users,
            'search' => $search,
            'pager' => [
                'currentPage' => (int)$page,
                'perPage' => $perPage,
                'total' => $totalUsers,
                'totalPages' => $totalPages,
            ],
        ];

        return view('admin/users', $data);
    }

    public function detail($id)
    {
        $user = $this->db->table('users')->where('id', $id)->get()->getRowArray();

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Tambahkan field aktif untuk kebutuhan view (sementara selalu true)
        $user['aktif'] = 1;
       
        // Pagination untuk booking user
        $page = (int)($this->request->getVar('page') ?? 1);
        $perPage = 5;

        // Hitung total booking untuk user ini
        $totalBookings = $this->db->table('bookings')
            ->where('id_user', $id)
            ->countAllResults();

        // Ambil data booking untuk halaman saat ini
        $bookings = $this->db->table('bookings')
            ->where('id_user', $id)
            ->orderBy('created_at', 'DESC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResultArray();

        // Hitung informasi pagination
        $totalPages = ceil($totalBookings / $perPage);
        $currentPage = min($page, max(1, $totalPages));

        $data = [
            'title' => 'Detail User - Admin SYH Cleaning',
            'user' => $user,
            'bookings' => $bookings,
            'bookingsPager' => [
                'currentPage' => $currentPage,
                'totalPages' => $totalPages,
                'perPage' => $perPage,
                'total' => $totalBookings,
            ],
        ];

        return view('admin/user_detail', $data);
    }

    /**
     * Tambah user baru
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah User - Admin SYH Cleaning'
        ];

        return view('admin/user_create', $data);
    }

    /**
     * Simpan user baru
     */
    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_lengkap' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'no_hp' => 'required|min_length[10]',
            'password' => 'required|min_length[6]',
            'role' => 'required|in_list[pelanggan,admin]',
        ], [
            'nama_lengkap' => [
                'required' => 'Nama lengkap harus diisi',
                'min_length' => 'Nama minimal 3 karakter'
            ],
            'email' => [
                'required' => 'Email harus diisi',
                'valid_email' => 'Email tidak valid',
                'is_unique' => 'Email sudah terdaftar'
            ],
            'no_hp' => [
                'required' => 'Nomor HP harus diisi',
                'min_length' => 'Nomor HP minimal 10 digit'
            ],
            'password' => [
                'required' => 'Password harus diisi',
                'min_length' => 'Password minimal 6 karakter'
            ],
            'role' => [
                'required' => 'Role harus dipilih',
                'in_list' => 'Role tidak valid'
            ]
        ]);

        if (!$validation->run($this->request->getPost())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'alamat' => $this->request->getPost('alamat'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->db->table('users')->insert($data)) {
            return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan user');
    }

    /**
     * Edit user
     */
    public function edit($id)
    {
        $user = $this->db->table('users')->where('id', $id)->get()->getRowArray();

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }

        $data = [
            'title' => 'Edit User - Admin SYH Cleaning',
            'user' => $user
        ];

        return view('admin/user_edit', $data);
    }

    /**
     * Update user
     */
    public function update($id)
    {
        $user = $this->db->table('users')->where('id', $id)->get()->getRowArray();

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }

        $validation = \Config\Services::validation();

        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'no_hp' => 'required|min_length[10]',
            'role' => 'required|in_list[pelanggan,admin]',
        ];

        // Validasi hanya jika password diisi
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        $validation->setRules($rules);

        if (!$validation->run($this->request->getPost())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'role' => $this->request->getPost('role'),
            'alamat' => $this->request->getPost('alamat'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Update password jika diisi
        if ($this->request->getPost('password')) {
            $data['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($this->db->table('users')->where('id', $id)->update($data)) {
            return redirect()->to('/admin/users')->with('success', 'User berhasil diupdate');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal mengupdate user');
    }

    /**
     * Hapus user
     */
    public function delete($id)
    {
        // Cek apakah user memiliki booking yang terkait
        $bookingCount = $this->db->table('bookings')->where('id_user', $id)->countAllResults();

        if ($bookingCount > 0) {
            return redirect()->to('/admin/users')->with('error', 'Tidak dapat menghapus user yang memiliki booking');
        }

        if ($this->db->table('users')->where('id', $id)->delete()) {
            return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus');
        }

        return redirect()->to('/admin/users')->with('error', 'Gagal menghapus user');
    }
}

