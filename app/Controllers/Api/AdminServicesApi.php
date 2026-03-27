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
            ->select('id, kode_layanan, nama_layanan, deskripsi, harga_dasar, durasi_hari, icon_path, aktif')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResult();

            // Tambahkan informasi ikon pada setiap layanan
            $iconMap = [
                'fast-cleaning' => 'bolt',
                'deep-cleaning' => 'water',
                'white-shoes' => 'shoe-prints',
                'suede-treatment' => 'spray-can',
                'unyellowing' => 'sun',
            ];

            foreach ($data as &$service) {
                // Ubah field numerik menjadi integer agar diproses dengan benar
                $service->harga_dasar = (int)$service->harga_dasar;
                $service->durasi_hari = (int)$service->durasi_hari;
                $service->aktif = (int)$service->aktif;
                
                if (!empty($service->icon_path)) {
                    $service->icon_type = 'image';
                    $service->icon = $service->icon_path;
                } else {
                    $service->icon_type = 'font';
                    $service->icon = $iconMap[$service->kode_layanan] ?? 'star';
                }
            }

            return $this->response->setJSON([
                'code' => 200,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Gagal mengambil layanan: ' . $e->getMessage());
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
            ->select('id, kode_layanan, nama_layanan, deskripsi, harga_dasar, durasi_hari, icon_path, aktif, created_at, updated_at')
            ->where('id', $id)
            ->get()
            ->getRowArray();

            if (!$data) {
                return $this->response->setJSON([
                    'code' => 404,
                    'message' => 'Layanan Tidak Ditemukan'
                ]);
            }

            // Ubah harga_dasar ke integer untuk mencegah error parsing
            $data['harga_dasar'] = (int)$data['harga_dasar'];
            $data['durasi_hari'] = (int)$data['durasi_hari'];
            $data['aktif'] = (int)$data['aktif'];

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
            log_message('info', 'Create service API called');
            
            // Ambil tipe konten request
            $contentType = $this->request->getHeaderLine('Content-Type');
            
            // Mendukung JSON dan form-data
            if (strpos($contentType, 'application/json') !== false) {
                $input = $this->request->getJSON(true);
            } else {
                // untuk multipart/form-data (upload file) atau application/x-www-form-urlencoded
                $input = [
                    'kode_layanan' => $this->request->getPost('kode_layanan'),
                    'nama_layanan' => $this->request->getPost('nama_layanan'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'harga_dasar' => $this->request->getPost('harga_dasar'),
                    'durasi_hari' => $this->request->getPost('durasi_hari'),
                    'aktif' => $this->request->getPost('aktif'),
                    'icon_file' => $this->request->getFile('icon_image')
                ];
            }
            
            log_message('info', 'Create data received: Kode=' . ($input['kode_layanan'] ?? 'null') . ', Nama=' . ($input['nama_layanan'] ?? 'null'));
            
            $rules = [
                'kode_layanan' => 'required',
                'nama_layanan' => 'required|min_length[3]',
                'harga_dasar' => 'required|numeric',
                'durasi_hari' => 'required|numeric'
            ];

            $validation = \Config\Services::validation();
            $validation->setRules($rules);
            
            if (!$validation->run($input)) {
                log_message('warning', 'Validation failed: ' . json_encode($validation->getErrors()));
                return $this->response->setJSON([
                    'code' => 400,
                    'message' => 'Validasi Gagal',
                    'errors' => $validation->getErrors()
                ]);
            }

            $data = [
                'kode_layanan' => $input['kode_layanan'],
                'nama_layanan' => $input['nama_layanan'],
                'deskripsi' => $input['deskripsi'] ?? null,
                'harga_dasar' => (int)$input['harga_dasar'],
                'durasi_hari' => (int)($input['durasi_hari'] ?? 1), 
                'aktif' => isset($input['aktif']) ? (int)$input['aktif'] : 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];            // Proses upload file ikon jika ada
            $iconFile = $this->request->getFile('icon_image');
            log_message('info', 'Icon file check: ' . ($iconFile ? 'EXISTS' : 'NULL'));
            
            if ($iconFile && is_object($iconFile) && $iconFile->isValid()) {
                try {
                    log_message('info', 'Processing icon upload: ' . $iconFile->getClientName() . ' Size: ' . $iconFile->getSize());
                    
                    // Simpan ke folder uploads di public agar bisa diakses dari web
                    $uploadsDir = FCPATH . 'uploads';
                    $servicesDir = $uploadsDir . DIRECTORY_SEPARATOR . 'services';
                    
                    if (!is_dir($uploadsDir)) {
                        mkdir($uploadsDir, 0755, true);
                        log_message('info', 'Created uploads directory: ' . $uploadsDir);
                    }
                    
                    if (!is_dir($servicesDir)) {
                        mkdir($servicesDir, 0755, true);
                        log_message('info', 'Created services directory: ' . $servicesDir);
                    }
                    
                    // Validasi ukuran file (maks 2MB)
                    if ($iconFile->getSize() > 2 * 1024 * 1024) {
                        log_message('warning', 'File too large: ' . $iconFile->getSize());
                        // Lanjut tanpa ikon jika file jika tidak ada
                    } else {
                        // Buat nama file unik untuk mencegah konflik
                        $newName = 'service_' . time() . '_' . $iconFile->getRandomName();
                        
                        // Pindahkan file ke folder uploads/services
                        if ($iconFile->move($servicesDir, $newName)) {
                            $data['icon_path'] = 'uploads/services/' . $newName;
                            log_message('info', 'Icon uploaded successfully: ' . $newName . ' at path: ' . $servicesDir . DIRECTORY_SEPARATOR . $newName);
                        } else {
                            log_message('error', 'Failed to move file: ' . $iconFile->getClientName());
                        }
                    }
                } catch (\Exception $e) {
                    log_message('error', 'File upload exception: ' . $e->getMessage());
                    // Lanjut tanpa ikon jika terjadi error saat upload
                }
            }

            log_message('info', 'Inserting service with data: ' . json_encode($data));
            
            $this->db->table('services')->insert($data);
            $id = $this->db->insertID();

            // Pastikan semua field numerik bertipe integer pada response
            $data['id'] = $id;
            $data['harga_dasar'] = (int)$data['harga_dasar'];
            $data['durasi_hari'] = (int)$data['durasi_hari'];
            $data['aktif'] = (int)$data['aktif'];

            return $this->response->setJSON([
                'code' => 201,
                'message' => 'Layanan berhasil dibuat',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Create service error: ' . $e->getMessage());
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
            log_message('info', 'Update service API called for ID: ' . $id);
            
            if (!$id) {
                return $this->response->setJSON([
                      'code' => 400,
                    'message' => 'ID Tidak Boleh Kosong'
                ]);
            }

            $cek = $this->db->table('services')
                ->select('id')
                ->where('id', $id)
                ->get()
                ->getRow();

            if (!$cek) {
                log_message('warning', 'Service not found: ' . $id);
                return $this->response->setJSON([
                    'code' => 404,
                    'message' => 'Layanan Tidak Ditemukan'
                ]);
            }

            // Cek tipe konten untuk menentukan cara parsing input
            $contentType = $this->request->getHeaderLine('Content-Type');
            log_message('info', 'Content-Type: ' . $contentType);
            
            // Parse input berdasarkan tipe konten 
            $input = [];
            if (strpos($contentType, 'application/json') !== false) {
                // Request JSON
                $input = $this->request->getJSON(true) ?? [];
            } else {
                // Request form-data atau multipart
                $input = [
                    'kode_layanan' => $this->request->getPost('kode_layanan'),
                    'nama_layanan' => $this->request->getPost('nama_layanan'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'harga_dasar' => $this->request->getPost('harga_dasar'),
                    'durasi_hari' => $this->request->getPost('durasi_hari'),
                    'aktif' => $this->request->getPost('aktif')
                ];
            }
            
            log_message('info', 'Update data received: ' . json_encode($input));
            
            $data = [];

            if (isset($input['kode_layanan']) && !empty($input['kode_layanan'])) {
                $data['kode_layanan'] = $input['kode_layanan'];
            }

            if (isset($input['nama_layanan']) && !empty($input['nama_layanan'])) {
                $data['nama_layanan'] = $input['nama_layanan'];
            }

            if (isset($input['deskripsi']) && !empty($input['deskripsi'])) {
                $data['deskripsi'] = $input['deskripsi'];
            }

            if (isset($input['harga_dasar']) && $input['harga_dasar'] !== '') {
                $data['harga_dasar'] = (int)$input['harga_dasar'];
            }

            if (isset($input['durasi_hari']) && $input['durasi_hari'] !== '') {
                $data['durasi_hari'] = (int)$input['durasi_hari'];
            }

            // Handle upload file ikon jika ada
            $file = $this->request->getFile('icon_image');

            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Buat folder uploads/services jika belum ada
                $uploadDir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'services';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $newName = $file->getRandomName();
                if ($file->move($uploadDir, $newName)) {
                    $data['icon_path'] = 'uploads/services/' . $newName;
                }
            }
            // Handle status aktif
            if (isset($input['aktif'])) {
                $data['aktif'] = $input['aktif'] ? 1 : 0;
            } else {
                // Jika tidak di set, berarti checkbox tidak dicentang, set aktif ke 0
                $data['aktif'] = 0;
            }

            $data['updated_at'] = date('Y-m-d H:i:s');

            log_message('info', 'Updating service with data: ' . json_encode($data));
            
            $this->db->table('services')
                ->where('id', $id)
                ->update($data);

            log_message('info', 'Service updated successfully: ' . $id);
            
            return $this->response->setJSON([
                'code' => 200,
                'message' => 'Layanan berhasil diupdate',
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Gagal update layanan: ' . $e->getMessage());
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

            $service = $this->db->table('services')
                ->select('id, kode_layanan')
                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$service) {
                return $this->response->setJSON([
                    'code' => 404,
                    'message' => 'Layanan Tidak Ditemukan'
                ]);
            }

            // Cek apakah layanan digunakan pada booking yang masih aktif (bukan selesai/batal/ditolak)
            $bookingCount = $this->db->table('bookings')
                ->where('layanan', $service['kode_layanan'])
                ->whereIn('status', ['pending', 'proses', 'disetujui'])
                ->countAllResults();

            if ($bookingCount > 0) {
                return $this->response->setJSON([
                    'code' => 409,
                    'message' => 'Tidak dapat menghapus layanan yang masih digunakan dalam ' . $bookingCount . ' pesanan aktif (pending/proses)'
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
            log_message('error', 'Gagal hapus layanan: ' . $e->getMessage());
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

            // Dukung request JSON dan form-data
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
                ->select('id')
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
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            return $this->response->setJSON([
                'code' => 200,
                'message' => 'Harga berhasil diupdate',
            ]);
        } catch(\Exception $e) {
            log_message('error', 'Gagal update harga: ' . $e->getMessage());
            return $this->response->setJSON([
                'code' => 500,
                'message' => 'Gagal update harga: ' . $e->getMessage()
            ]);
        }
    }

    // POST /api/admin/services/{id}/upload-icon
    public function uploadIcon($id = null): ResponseInterface
    {
        try {
            if (!$id) {
                return $this->response->setJSON([
                    'code' => 400,
                    'message' => 'ID Tidak Boleh Kosong'
                ]);
            }

            $service = $this->db->table('services')
                ->select('id')
                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$service) {
                return $this->response->setJSON([
                    'code' => 404,
                    'message' => 'Layanan Tidak Ditemukan'
                ]);
            }

            $file = $this->request->getFile('icon_path');

            if (!$file || !$file->isValid()) {
                return $this->response->setJSON([
                    'code' => 400,
                    'message' => 'File icon harus diupload'
                ]);
            }

            // Validasi file
            if ($file->getSize() > 2097152) { // 2MB
                return $this->response->setJSON([
                    'code' => 400,
                    'message' => 'Ukuran file terlalu besar (max 2MB)'
                ]);
            }

            $ext = $file->getExtension();
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                return $this->response->setJSON([
                    'code' => 400,
                    'message' => 'Format file tidak didukung'
                ]);
            }

            // Buat folder uploads/services jika belum ada
            $uploadDir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'services';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Buat nama file 
            $filename = 'service_' . $service['id'] . '_' . time() . '.' . $ext;
            $filePath = $uploadDir . DIRECTORY_SEPARATOR . $filename;

            // Pindahkan file ke folder uploads/services
            $file->move($uploadDir, $filename);

            // Update layanan dengan path ikon 
            $iconPath = 'uploads/services/' . $filename;
            $this->db->table('services')
                ->where('id', $id)
                ->update([
                    'icon_path' => $iconPath,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            return $this->response->setJSON([
                'code' => 200,
                'message' => 'Icon berhasil diupload',
                'icon_path' => $iconPath
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Gagal upload icon: ' . $e->getMessage());
            return $this->response->setJSON([
                'code' => 500,
                'message' => 'Gagal upload icon: ' . $e->getMessage()
            ]);
        }
    }

    // DELETE /api/admin/services/{id}/remove-icon
    public function removeIcon($id = null): ResponseInterface
    {
        try {
            if (!$id) {
                return $this->response->setJSON([
                    'code' => 400,
                    'message' => 'ID Tidak Boleh Kosong'
                ]);
            }

            $service = $this->db->table('services')                ->select('id, icon_path')                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$service) {
                return $this->response->setJSON([
                    'code' => 404,
                    'message' => 'Layanan Tidak Ditemukan'
                ]);
            }

            // Hapus file jika ada
            if (!empty($service['icon_path'])) {
                $filePath = FCPATH . $service['icon_path'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Update layanan untuk menghapus path ikon
            $this->db->table('services')
                ->where('id', $id)
                ->update([
                    'icon_path' => null,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            return $this->response->setJSON([
                'code' => 200,
                'message' => 'Icon berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Gagal hapus icon: ' . $e->getMessage());
            return $this->response->setJSON([
                'code' => 500,
                'message' => 'Gagal hapus icon: ' . $e->getMessage()
            ]);
        }
    }
    
}
