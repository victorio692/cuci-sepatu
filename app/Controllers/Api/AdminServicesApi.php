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

            // Add icon information to each service
            $iconMap = [
                'fast-cleaning' => 'bolt',
                'deep-cleaning' => 'water',
                'white-shoes' => 'shoe-prints',
                'suede-treatment' => 'spray-can',
                'unyellowing' => 'sun',
            ];

            foreach ($data as &$service) {
                // Convert numeric fields to integers for proper handling
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
            ->select('id, kode_layanan, nama_layanan, deskripsi, harga_dasar, durasi_hari, icon_path, aktif, dibuat_pada, diupdate_pada')
            ->where('id', $id)
            ->get()
            ->getRowArray();

            if (!$data) {
                return $this->response->setJSON([
                    'code' => 404,
                    'message' => 'Layanan Tidak Ditemukan'
                ]);
            }

            // Convert harga_dasar to integer to prevent parsing issues
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
            
            // Get content type
            $contentType = $this->request->getHeaderLine('Content-Type');
            
            // Support both JSON and form-data
            if (strpos($contentType, 'application/json') !== false) {
                $input = $this->request->getJSON(true);
            } else {
                // For multipart/form-data (file upload) or application/x-www-form-urlencoded
                $input = [
                    'kode_layanan' => $this->request->getPost('kode_layanan'),
                    'nama_layanan' => $this->request->getPost('nama_layanan'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'harga_dasar' => $this->request->getPost('harga_dasar'),
                    'durasi_hari' => $this->request->getPost('durasi_hari'),
                    'aktif' => $this->request->getPost('aktif'),
                    'icon_image' => $this->request->getFile('icon_image')
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
                'dibuat_pada' => date('Y-m-d H:i:s'),
                'diupdate_pada' => date('Y-m-d H:i:s')
            ];            // Handle file upload if present
            $iconFile = $input['icon_image'] ?? null;
            log_message('info', 'Icon file check: ' . ($iconFile ? 'EXISTS' : 'NULL'));
            
            if ($iconFile && is_object($iconFile) && $iconFile->isValid()) {
                try {
                    log_message('info', 'Processing icon upload: ' . $iconFile->getClientName() . ' Size: ' . $iconFile->getSize());
                    
                    // Save to PUBLIC uploads directory (not writable) so it's web-accessible
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
                    
                    // Validate file size (max 2MB)
                    if ($iconFile->getSize() > 2 * 1024 * 1024) {
                        log_message('warning', 'File too large: ' . $iconFile->getSize());
                        // Continue without icon
                    } else {
                        // Generate unique filename
                        $newName = 'service_' . time() . '_' . $iconFile->getRandomName();
                        
                        // Move file to uploads directory
                        if ($iconFile->move($servicesDir, $newName)) {
                            $data['icon_path'] = 'uploads/services/' . $newName;
                            log_message('info', 'Icon uploaded successfully: ' . $newName . ' at path: ' . $servicesDir . DIRECTORY_SEPARATOR . $newName);
                        } else {
                            log_message('error', 'Failed to move file: ' . $iconFile->getClientName());
                        }
                    }
                } catch (\Exception $e) {
                    log_message('error', 'File upload exception: ' . $e->getMessage());
                    // Continue without file if upload fails
                }
            }

            log_message('info', 'Inserting service with data: ' . json_encode($data));
            
            $this->db->table('services')->insert($data);
            $id = $this->db->insertID();

            // Ensure all numeric fields are integers in response
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

            // Support both JSON and form-data
            $input = $this->request->getJSON(true) ?? $this->request->getPost();
            log_message('info', 'Update data received: ' . json_encode($input));
            
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

            // Handle aktif status
            if (isset($input['aktif'])) {
                $data['aktif'] = $input['aktif'] ? 1 : 0;
            } else {
                // If not set, means checkbox is unchecked
                $data['aktif'] = 0;
            }

            $data['diupdate_pada'] = date('Y-m-d H:i:s');

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
                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$service) {
                return $this->response->setJSON([
                    'code' => 404,
                    'message' => 'Layanan Tidak Ditemukan'
                ]);
            }

            // Check if service is used in ACTIVE bookings only (not selesai/batal/ditolak)
            $bookingCount = $this->db->table('bookings')
                ->where('layanan', $service['kode_layanan'])
                ->whereIn('status', ['pending', 'proses', 'dikonfirmasi'])
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
                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$service) {
                return $this->response->setJSON([
                    'code' => 404,
                    'message' => 'Layanan Tidak Ditemukan'
                ]);
            }

            $file = $this->request->getFile('icon_image');

            if (!$file || !$file->isValid()) {
                return $this->response->setJSON([
                    'code' => 400,
                    'message' => 'File icon harus diupload'
                ]);
            }

            // Validate file
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

            // Create services upload directory if not exists
            $uploadDir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'services';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate filename
            $filename = 'service_' . $service['id'] . '_' . time() . '.' . $ext;
            $filePath = $uploadDir . DIRECTORY_SEPARATOR . $filename;

            // Move file
            $file->move($uploadDir, $filename);

            // Update service with icon path
            $iconPath = 'uploads/services/' . $filename;
            $this->db->table('services')
                ->where('id', $id)
                ->update([
                    'icon_path' => $iconPath,
                    'diupdate_pada' => date('Y-m-d H:i:s')
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

            $service = $this->db->table('services')
                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$service) {
                return $this->response->setJSON([
                    'code' => 404,
                    'message' => 'Layanan Tidak Ditemukan'
                ]);
            }

            // Delete the file if exists
            if (!empty($service['icon_path'])) {
                $filePath = FCPATH . $service['icon_path'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Update service to remove icon path
            $this->db->table('services')
                ->where('id', $id)
                ->update([
                    'icon_path' => null,
                    'diupdate_pada' => date('Y-m-d H:i:s')
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
