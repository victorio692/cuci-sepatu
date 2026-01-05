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
                'description' => 'Pembersihan cepat untuk sepatu Anda',
            ],
            [
                'id' => 'deep-cleaning',
                'name' => 'Deep Cleaning',
                'price' => 20000,
                'icon' => 'droplet',
                'description' => 'Pembersihan mendalam hingga ke sela-sela',
            ],
            [
                'id' => 'white-shoes',
                'name' => 'White Shoes',
                'price' => 35000,
                'icon' => 'star',
                'description' => 'Layanan khusus untuk sepatu putih',
            ],
            [
                'id' => 'coating',
                'name' => 'Coating',
                'price' => 25000,
                'icon' => 'shield',
                'description' => 'Perlindungan tahan lama untuk sepatu',
            ],
            [
                'id' => 'dyeing',
                'name' => 'Dyeing',
                'price' => 40000,
                'icon' => 'palette',
                'description' => 'Pewarnaan ulang untuk sepatu',
            ],
            [
                'id' => 'repair',
                'name' => 'Repair',
                'price' => 50000,
                'icon' => 'wrench',
                'description' => 'Perbaikan sepatu yang rusak',
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
