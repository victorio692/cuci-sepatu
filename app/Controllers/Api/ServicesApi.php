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
            ->orderBy("FIELD(kode_layanan, 'fast-cleaning', 'deep-cleaning', 'white-shoes', 'suede-treatment', 'unyellowing')", '', false)
            ->get()
            ->getResultArray();

        return $this->respond($services);
    }

    public function show($id = null)
    {
        $service = $this->db->table('services')
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
            'dibuat_pada' => date('Y-m-d H:i:s'),
            'diupdate_pada' => date('Y-m-d H:i:s')
        ]);

        return $this->respondCreated([
            'success' => true,
            'message' => 'Layanan berhasil dibuat'
        ]);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        $service = $this->db->table('services')->where('id', $id)->get()->getRowArray();

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
            'diupdate_pada' => date('Y-m-d H:i:s')
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