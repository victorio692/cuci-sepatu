<?php

namespace App\Controllers;

use Config\Database;

class Home extends BaseController
{
    public function index()
    {
        $db = Database::connect();
        
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
