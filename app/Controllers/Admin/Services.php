<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Config\Database;

class Services extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        $services = [
            [
                'id' => 'fast-cleaning',
                'name' => 'Fast Cleaning',
                'price' => 15000,
                'icon' => 'bolt',
                'description' => 'Pembersihan cepat untuk sepatu',
            ],
            [
                'id' => 'deep-cleaning',
                'name' => 'Deep Cleaning',
                'price' => 20000,
                'icon' => 'droplet',
                'description' => 'Pembersihan mendalam hingga bersih',
            ],
            [
                'id' => 'white-shoes',
                'name' => 'White Shoes',
                'price' => 35000,
                'icon' => 'star',
                'description' => 'Khusus sepatu putih yang menguning',
            ],
            [
                'id' => 'suede-treatment',
                'name' => 'Suede Treatment',
                'price' => 30000,
                'icon' => 'sparkles',
                'description' => 'Perawatan khusus untuk sepatu suede',
            ],
            [
                'id' => 'unyellowing',
                'name' => 'Unyellowing',
                'price' => 30000,
                'icon' => 'sun',
                'description' => 'Menghilangkan kuning pada sole sepatu',
            ],
        ];

        $data = [
            'title' => 'Layanan - Admin SYH Cleaning',
            'services' => $services,
        ];

        return view('admin/services', $data);
    }

    public function updatePrice()
    {
        $service = $this->request->getPost('service');
        $price = $this->request->getPost('price');

        if (!$service || !$price) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid data']);
        }

        // Update price in session or database
        // For now, just return success
        return $this->response->setJSON(['success' => true, 'message' => 'Price updated']);
    }
}
