<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Config\Database;

class Profile extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $db = db_connect();

        $user = $db->table('users')
            ->where('id', $userId)
            ->get()
            ->getRowArray();

        if (!$user) {
            return redirect()->to('/logout');
        }

        $data = [
            'title' => 'Profil Admin - SYH Cleaning',
            'user' => $user,
        ];

        return view('admin/profile', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        $db = db_connect();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_lengkap' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'no_hp' => 'required|min_length[10]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $updateData = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        $db->table('users')->where('id', $userId)->update($updateData);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    public function changePassword()
    {
        $userId = session()->get('user_id');
        $db = db_connect();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('error', 'Validasi gagal: ' . implode(', ', $validation->getErrors()));
        }

        $user = $db->table('users')->where('id', $userId)->get()->getRowArray();

        // Verify current password
        if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai');
        }

        // Update password
        $newPassword = password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT);
        $db->table('users')->where('id', $userId)->update(['password' => $newPassword]);

        return redirect()->back()->with('success', 'Password berhasil diubah');
    }
}
