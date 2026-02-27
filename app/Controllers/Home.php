<?php

namespace App\Controllers;

use Config\Database;

class Home extends BaseController
{
    public function index()
    {
        $db = Database::connect();
        
        // Cek jika user sudah login dan adalah admin, redirect ke dashboard admin
        $user_id = session()->get('user_id');
        if ($user_id) {
            $user = $db->table('users')->where('id', $user_id)->get()->getRowArray();
            if ($user && $user['role'] === 'admin') {
                return redirect()->to('/admin')->with('info', 'Anda login sebagai admin. Gunakan dashboard admin.');
            }
        }
        
        // Get all active services from database
        $services = $db->table('services')
            ->where('aktif', 1)
            ->orderBy("FIELD(kode_layanan, 'fast-cleaning', 'deep-cleaning', 'white-shoes', 'suede-treatment', 'unyellowing')", '', false)
            ->get()
            ->getResultArray();
        
        $data = [
            'title' => 'Home - SYH Cleaning',
            'services' => $services
        ];

        return view('pages/home', $data);
    }
}
