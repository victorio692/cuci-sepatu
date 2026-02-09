<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin 1 - Owner
        $this->db->table('users')->insert([
            'nama_lengkap' => 'Rio Babang',
            'email' => 'rio@cuciriobabang.com',
            'no_hp' => '081298765432',
            'password_hash' => password_hash('password123', PASSWORD_BCRYPT),
            'foto_profil' => null,
            'alamat' => 'Jl. Raya Bogor KM 23 No. 45, Jakarta Timur',
            'role' => 'admin',
            'dibuat_pada' => '2025-11-12 08:23:11',
            'diupdate_pada' => date('Y-m-d H:i:s'),
        ]);

        // Admin 2 - Manager
        $this->db->table('users')->insert([
            'nama_lengkap' => 'Sarah Wijaya',
            'email' => 'admin@syhhcleaning@gmailcom',
            'no_hp' => '089898765432',
            'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
            'foto_profil' => null,
            'alamat' => 'Jl. Sudirman No. 88, Jakarta Pusat',
            'role' => 'admin',
            'dibuat_pada' => date('Y-m-d H:i:s'),
            'diupdate_pada' => date('Y-m-d H:i:s'),
        ]);

        // Petugas 1
        $this->db->table('users')->insert([
            'nama_lengkap' => 'Andi Prasetyo',
            'email' => 'andi@syhhcleaning.gmail.com',
            'no_hp' => '082123456789',
            'password_hash' => password_hash('petugas123', PASSWORD_BCRYPT),
            'foto_profil' => null,
            'alamat' => 'Jl. Cibubur No. 12, Bekasi',
            'role' => 'petugas',
            'dibuat_pada' => date('Y-m-d H:i:s'),
            'diupdate_pada' => date('Y-m-d H:i:s'),
        ]);

        // Customers
        $this->db->table('users')->insert([
            'nama_lengkap' => 'Budi Santoso',
            'email' => 'budisantoso88@gmail.com',
            'no_hp' => '082187654321',
            'password_hash' => password_hash('password123', PASSWORD_BCRYPT),
            'foto_profil' => null,
            'alamat' => 'Perum Cimanggis Indah Blok A3, Depok',
            'role' => 'pelanggan',
            'dibuat_pada' => '2025-12-20 14:22:00',
            'diupdate_pada' => '2025-12-20 14:22:00',
        ]);

        $this->db->table('users')->insert([
            'nama_lengkap' => 'Siti Nurhaliza',
            'email' => 'siti.nur@yahoo.com',
            'no_hp' => '085612345678',
            'password_hash' => password_hash('password123', PASSWORD_BCRYPT),
            'foto_profil' => null,
            'alamat' => 'Jl. Margonda Raya No. 156, Depok',
            'role' => 'pelanggan',
            'dibuat_pada' => '2026-01-05 09:15:00',
            'diupdate_pada' => '2026-01-05 09:15:00',
        ]);

        $this->db->table('users')->insert([
            'nama_lengkap' => 'Ahmad Fauzi',
            'email' => 'ahmadf92@gmail.com',
            'no_hp' => '087723456789',
            'password_hash' => password_hash('password123', PASSWORD_BCRYPT),
            'foto_profil' => null,
            'alamat' => 'Komplek Cibubur Country Blok C12, Bekasi',
            'role' => 'pelanggan',
            'dibuat_pada' => '2026-01-10 16:45:00',
            'diupdate_pada' => '2026-01-10 16:45:00',
        ]);
    }
}
