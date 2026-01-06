<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Insert admin default
        $data = [
            'nama'       => 'Administrator',
            'email'      => 'admin@cucisepatu.com',
            'username'   => 'admin',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'role'       => 'admin',
            'telepon'    => '081234567890',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('users')->insert($data);

        // Insert sample layanan
        $layanan = [
            [
                'nama_layanan' => 'Cuci Sepatu Basic',
                'deskripsi'    => 'Cuci bersih sepatu dengan sabun khusus dan sikat lembut',
                'harga'        => 25000,
                'durasi'       => '2-3 hari',
                'status'       => 'aktif',
                'created_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan' => 'Cuci Sepatu Premium',
                'deskripsi'    => 'Cuci deep cleaning + poles + parfum',
                'harga'        => 40000,
                'durasi'       => '3-4 hari',
                'status'       => 'aktif',
                'created_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan' => 'Repaint Sepatu',
                'deskripsi'    => 'Cat ulang sepatu dengan warna pilihan',
                'harga'        => 75000,
                'durasi'       => '5-7 hari',
                'status'       => 'aktif',
                'created_at'   => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('layanan')->insertBatch($layanan);
    }
}
