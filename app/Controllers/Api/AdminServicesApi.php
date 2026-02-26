<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminServicesApi extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    // GET /api/admin/services
    public function index(): ResponseInterface
    {
        try {
            $data = $this->db->table('services')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResult();

            return $this->response->setJSON([
                'code' => 200,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 500,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ]);
        }
    }

    // GET /api/admin/services/{id}
    public function show($id): ResponseInterface
    {
        try {
            if (!$id) {
                return $this->response->setJSON([
                    'code' => 400,
                    'message' => 'ID Tidak Boleh Kosong'
                ]);
            }

            $data = $this->db->table('services')
            ->where('id', $id)
            ->get()
            ->getRowArray();

            if (!$data) {
                return $this->response->setJSON([
                    'code' => 404,
                    'message' => 'Layanan Tidak Ditemukan'
                ]);
            }

            return $this->response->setJSON([
                'code' => 200,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 500,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ]);
        }
    }

    //POST /api/admin/services
    public function create(): ResponseInterface
    {
        try {
            // Support both JSON and form-data
            $input = $this->request->getJSON(true) ?? $this->request->getPost();
            
            $rules = [
                'kode_layanan' => 'required',
                'nama_layanan' => 'required|min_length[3]',
                'harga_dasar' => 'required|numeric',
                'durasi_hari' => 'required'
            ];

            if (!$this->validate($rules, $input)) {
                return $this->response->setJSON([
                    'code' => 400,
                    'message' => 'Validasi Gagal',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $data = [
                'kode_layanan' => $input['kode_layanan'],
                'nama_layanan' => $input['nama_layanan'],
                'deskripsi' => $input['deskripsi'] ?? null,
                'harga_dasar' => $input['harga_dasar'],
                'durasi_hari' => $input['durasi_hari'],
                'aktif' => 1,
                'dibuat_pada' => date('Y-m-d H:i:s'),
                'diupdate_pada' => date('Y-m-d H:i:s')
            ];

            $this->db->table('services')->insert($data);
            $id = $this->db->insertID();

            return $this->response->setJSON([
                'code' => 201,
                'message' => 'Layanan berhasil dibuat',
                'data' => array_merge($data, ['id' => $id])
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 500,
                'message' => 'Gagal menyimpan: ' . $e->getMessage()
            ]);
        }
    }

    // PUT /api/admin/services/{id}
    public function update($id = null): ResponseInterface
    {
        try {
            if (!$id) {
                return $this->response->setJSON([
                      'code' => 400,
                    'message' => 'ID Tidak Boleh Kosong'
                ]);
            }

            $cek = $this->db->table('services')
                ->where('id', $id)
                ->get()
                ->getRow();

            if (!$cek) {
                return $this->response->setJSON([
                    'code' => 404,
                    'message' => 'Layanan Tidak Ditemukan'
                ]);
            }

            // Support both JSON and form-data
            $input = $this->request->getJSON(true) ?? $this->request->getPost();
            $data = [];

            if (isset($input['kode_layanan'])) {
                $data['kode_layanan'] = $input['kode_layanan'];
            }

            if (isset($input['nama_layanan'])) {
                $data['nama_layanan'] = $input['nama_layanan'];
            }

            if (isset($input['deskripsi'])) {
                $data['deskripsi'] = $input['deskripsi'];
            }

            if (isset($input['harga_dasar'])) {
                $data['harga_dasar'] = $input['harga_dasar'];
            }

            if (isset($input['durasi_hari'])) {
                $data['durasi_hari'] = $input['durasi_hari'];
            }

            $data['diupdate_pada'] = date('Y-m-d H:i:s');

            $this->db->table('services')
                ->where('id', $id)
                ->update($data);

            return $this->response->setJSON([
                'code' => 200,
                'message' => 'Layanan berhasil diupdate',
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 500,
                'message' => 'Gagal update: ' . $e->getMessage()
            ]);
        }
    }

    //DELETE /api/admin/services/{id}
    public function delete($id = null): ResponseInterface
    {
        try {
            if (!$id) {
                return $this->response->setJSON([
                    'code' => 400,
                    'message' => 'ID Tidak Boleh Kosong'
                ]);
            }

            $cek = $this->db->table('services')
            ->where('id', $id)
            ->get()
            ->getRow();

            if (!$cek) {
                return $this->response->setJSON([
                    'code' => 404,
                    'message' => 'Layanan Tidak Ditemukan'
                ]);
            }

            $this->db->table('services')
            ->where('id', $id)
            ->delete();

            return $this->response->setJSON([
                'code' => 200,
                'message' => 'Layanan berhasil dihapus',
            ]);
        }catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 500,
                'message' => 'Gagal hapus: ' . $e->getMessage()
            ]);
        }
    }


    //PUT /api/admin/services/{id}/price
    public function updatePrice($id = null): ResponseInterface
    {
        try {
            if (!$id) {
                return $this->response->setJSON([
                    'code' => 400,
                    'message' => 'ID Tidak Boleh Kosong'
                ]);
            }

            // Support both JSON and form-data
            $input = $this->request->getJSON(true) ?? $this->request->getPost();
            $harga = $input['harga'] ?? null;

            if (!$harga) {
                return $this->response->setJSON([
                    'code' => 400,
                    'message' => 'Harga harus diisi'
                ]);
            }

            if (!is_numeric($harga)) {
                return $this->response->setJSON([
                    'code' => 400,
                    'message' => 'Harga harus berupa angka'
                ]);
            }

            $cek = $this->db->table('services')
                ->where('id', $id)
                ->get()
                ->getRow();

            if (!$cek) {
                return $this->response->setJSON([
                    'code' => 404,
                    'message' => 'Layanan Tidak Ditemukan'
                ]);
            }

            $this->db->table('services')
                ->where('id', $id)
                ->update([
                    'harga_dasar' => $harga, 
                    'diupdate_pada' => date('Y-m-d H:i:s')
                ]);

            return $this->response->setJSON([
                'code' => 200,
                'message' => 'Harga berhasil diupdate',
            ]);
        } catch(\Exception $e) {
            return $this->response->setJSON([
                'code' => 500,
                'message' => 'Gagal update harga: ' . $e->getMessage()
            ]);
        }
    }
    
}
