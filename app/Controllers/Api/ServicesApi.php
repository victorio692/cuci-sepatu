<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use Config\Database;

class ServicesApi extends ResourceController
{
    protected $format = 'json';
    protected $db;


    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        $services = $this->db->table('services')
            ->select('id, kode_layanan, nama_layanan, deskripsi, harga_dasar, durasi_hari, icon_path, aktif')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();
        
        return $this->respond($services);
    }

    public function show($id = null)
    {
        $service = $this->db->table('services')
            ->select('id, kode_layanan, nama_layanan, deskripsi, harga_dasar, durasi_hari, icon_path, aktif')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$service) {
            return $this->failNotFound('Layanan tidak ditemukan');
        }

        return $this->respond($service);
    }

    public function create()
    {
        $data = $this->request->getJSON(true);

        if (!$data) {
            return $this->fail('Data JSON tidak valid');
        }

        $this->db->table('services')->insert([
            'kode_layanan' => $data['kode_layanan'],
            'nama_layanan' => $data['nama_layanan'],
            'deskripsi' => $data['deskripsi'],
            'harga_dasar' => $data['harga_dasar'],
            'durasi_hari' => $data['durasi_hari'],
            'aktif' => $data['aktif'] ?? 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $this->respondCreated([
            'success' => true,
            'message' => 'Layanan berhasil dibuat'
        ]);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        $service = $this->db->table('services')
            ->select('id, aktif')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$service) {
            return $this->failNotFound('Layanan tidak ditemukan');
        }

        $this->db->table('services')->where('id', $id)->update([
            'kode_layanan' => $data['kode_layanan'],
            'nama_layanan' => $data['nama_layanan'],
            'deskripsi' => $data['deskripsi'],
            'harga_dasar' => $data['harga_dasar'],
            'durasi_hari' => $data['durasi_hari'],
            'aktif' => $data['aktif'] ?? $service['aktif'],
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $this->respond([
            'success' => true,
            'message' => 'Layanan berhasil diupdate'
        ]);
    }

    public function delete($id = null)
    {
        $this->db->table('services')->where('id', $id)->delete();

        return $this->respondDeleted([
            'success' => true,
            'message' => 'Layanan berhasil dihapus'
        ]);
    }
}