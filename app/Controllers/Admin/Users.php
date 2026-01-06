<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Halaman kelola pelanggan
     */
    public function index()
    {
        $data = [
            'title'      => 'Kelola Pelanggan',
            'pelanggan'  => $this->userModel->getPelanggan(),
        ];

        return view('admin/users', $data);
    }

    /**
     * Detail user
     */
    public function detail($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user || $user['role'] !== 'pelanggan') {
            return redirect()->to('/admin/users')->with('error', 'Pelanggan tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Pelanggan',
            'user'  => $user,
        ];

        return view('admin/user_detail', $data);
    }

    /**
     * Hapus user
     */
    public function delete($id)
    {
        $user = $this->userModel->find($id);
        
        // Tidak boleh hapus admin
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin/users')->with('error', 'Tidak dapat menghapus admin');
        }

        if ($this->userModel->delete($id)) {
            return redirect()->to('/admin/users')->with('success', 'Pelanggan berhasil dihapus');
        }

        return redirect()->to('/admin/users')->with('error', 'Gagal menghapus pelanggan');
    }
}
