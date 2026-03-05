<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class AdminBookingsApi extends BaseController
{
    use ResponseTrait;
    
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    
    private function checkAdmin()
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return null;
        }

        $user = $this->db->table('users')
            ->select('id, role')
            ->where('id', $user_id)
            ->get()
            ->getRowArray();
        if (!$user || $user['role'] !== 'admin') {
            return null;
        }

        return $user;
    }

    
    public function index()
    {
        $admin = $this->checkAdmin();
        if (!$admin) {
            return $this->failForbidden('Akses ditolak. Hanya admin yang bisa mengakses');
        }

        $status = $this->request->getGet('status');
        $search = $this->request->getGet('search');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->request->getGet('per_page') ?? 10;
       

        $builder = $this->db->table('bookings')
            ->select('bookings.*, users.nama_lengkap as full_name, users.email, users.no_hp')
            ->join('users', 'bookings.id_user = users.id');

        if ($status) {
            $builder->where('bookings.status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('users.nama_lengkap', $search)
                ->orLike('users.email', $search)
                ->orLike('bookings.layanan', $search)
                ->groupEnd();
        }

        // Get total count
        $totalBookings = $builder->countAllResults(false);
        
        // Get paginated results
        $bookings = $builder->orderBy('bookings.created_at', 'DESC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResultArray();

        return $this->respond([
            'success' => true,
            'data' => [
                'bookings' => $bookings,
                'pagination' => [
                    'current_page' => (int)$page,
                    'per_page' => (int)$perPage,
                    'total' => $totalBookings,
                    'total_pages' => ceil($totalBookings / $perPage)
                ]
            ]
        ]);
    }

    public function detail($id)
    {
        $admin = $this->checkAdmin();
        if (!$admin) {
            return $this->failForbidden('Akses ditolak. Hanya admin yang bisa mengakses');
        }

        try {
            $booking = $this->db->table('bookings')
                ->select('bookings.*, users.nama_lengkap as full_name, users.email, users.no_hp, users.alamat as address')
                ->join('users', 'bookings.id_user = users.id')
                ->where('bookings.id', $id)
                ->get()
                ->getRowArray();

            if (!$booking) {
                return $this->failNotFound('Booking tidak ditemukan');
            }

            $photos = [];
            try {
                $photos = $this->db->table('booking_photos')
                    ->where('booking_id', $id)
                    ->orderBy('id', 'ASC')
                    ->get()
                    ->getResultArray();
            } catch (\Exception $e) {
                
                $photos = [];
            }

            return $this->respond([
                'success' => true,
                'data' => [
                    'booking' => $booking,
                    'photos' => $photos
                ]
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('Gagal mengambil detail booking: ' . $e->getMessage());
        }
    }

   
    public function updateStatus($id)
    {
        $admin = $this->checkAdmin();
        if (!$admin) {
            return $this->failForbidden('Akses ditolak. Hanya admin yang bisa mengakses');
        }

        
        $booking = $this->db->table('bookings')->where('id', $id)->get()->getRowArray();
        
        if (!$booking) {
            return $this->failNotFound('Booking tidak ditemukan');
        }

        $contentType = $this->request->getHeaderLine('Content-Type');
        
        if (strpos($contentType, 'multipart/form-data') !== false) {
            $status = $this->request->getPost('status');
            $alasan = $this->request->getPost('alasan_penolakan');
        } else {
            $json = $this->request->getJSON(true);
            $status = $json['status'] ?? null;
            $alasan = $json['alasan_penolakan'] ?? null;
        }

        if (!$status) {
            return $this->fail('Status harus diisi');
        }

        $currentStatus = $booking['status'];
        
        
        $validTransitions = [
            'pending' => ['disetujui', 'ditolak'],
            'disetujui' => ['proses'],
            'proses' => ['selesai'],
            'selesai' => [],
            'ditolak' => []
        ];

       
        if (!isset($validTransitions[$currentStatus])) {
            return $this->fail('Status booking tidak valid');
        }

        
        if ($currentStatus === 'selesai' || $currentStatus === 'ditolak') {
            return $this->fail('Status sudah final, tidak dapat diubah lagi');
        }

        
        if (!in_array($status, $validTransitions[$currentStatus])) {
            $errorMessages = [
                'pending' => 'Dari status Menunggu hanya bisa disetujui atau ditolak',
                'disetujui' => 'Dari status Disetujui harus diproses terlebih dahulu, tidak bisa langsung selesai',
                'proses' => 'Dari status Proses hanya bisa ditandai selesai'
            ];
            
            $message = $errorMessages[$currentStatus] ?? 'Perubahan status tidak valid. Status harus urut: Menunggu → Disetujui → Proses → Selesai';
            
            return $this->fail($message);
        }

        if ($status === 'ditolak' && empty($alasan)) {
            return $this->fail('Alasan penolakan harus diisi');
        }

       
        $newName = null;
       
        
        if ($status === 'selesai') {
            $foto_hasil = $this->request->getFile('foto_hasil');
            
            if (!$foto_hasil) {
                return $this->fail('Foto hasil cucian wajib diupload untuk status selesai');
            }

            if (!$foto_hasil->isValid()) {
                return $this->fail('Error unggah foto: ' . $foto_hasil->getErrorString());
            }

            
            $mimeType = $foto_hasil->getClientMimeType();
            if (!in_array($mimeType, ['image/jpeg', 'image/jpg', 'image/png'])) {
                return $this->fail('Format foto harus JPG, JPEG, atau PNG');
            }

          
            $fileSize = $foto_hasil->getSizeByUnit('mb');
            if ($fileSize > 5) {
                return $this->fail('Ukuran foto maksimal 5MB');
            }

           
            try {
                $newName = $foto_hasil->getRandomName();
                $uploadPath = FCPATH . 'uploads/';
                
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                $foto_hasil->move($uploadPath, $newName);
            } catch (\Exception $e) {
                return $this->failServerError('Gagal unggah foto: ' . $e->getMessage());
            }
        }

        
        $updateData = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if ($status === 'ditolak') {
            $updateData['alasan_penolakan'] = $alasan;
        }

        if ($status === 'selesai' && $newName !== null) {
            $updateData['foto_hasil'] = $newName;
        }

        try {
            $this->db->table('bookings')->where('id', $id)->update($updateData);

            
            $notificationData = [
                'id_user' => $booking['id_user'],
                'booking_id' => $id,
                'dibaca' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ];

            switch ($status) {
                case 'disetujui':
                    $notificationData['judul'] = 'Booking Disetujui!';
                    $notificationData['pesan'] = "Booking ID #{$id} telah disetujui. Sepatu Anda akan segera diproses.";
                    $notificationData['tipe'] = 'success';
                    break;
                case 'proses':
                    $notificationData['judul'] = 'Sepatu Sedang Diproses';
                    $notificationData['pesan'] = "Booking ID #{$id} sedang dalam proses pencucian. Mohon ditunggu!";
                    $notificationData['tipe'] = 'info';
                    break;
                case 'selesai':
                    $notificationData['judul'] = 'Sepatu Sudah Selesai!';
                    $notificationData['pesan'] = "Booking ID #{$id} sudah selesai dicuci. Silakan ambil sepatu Anda!";
                    $notificationData['tipe'] = 'success';
                    break;
                case 'ditolak':
                    $notificationData['judul'] = 'Booking Ditolak';
                    $notificationData['pesan'] = "Booking ID #{$id} ditolak. Alasan: {$alasan}";
                    $notificationData['tipe'] = 'danger';
                    break;
            }

            $this->db->table('notifications')->insert($notificationData);

            return $this->respond([
                'success' => true,
                'message' => 'Status berhasil diubah',
                'data' => [
                    'new_status' => $status,
                    'foto_hasil' => $newName ? base_url('uploads/' . $newName) : null,
                    'show_whatsapp' => ($status === 'selesai')
                ]
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('Gagal mengubah status: ' . $e->getMessage());
        }
    }

   
    public function delete($id)
    {
        $admin = $this->checkAdmin();
        if (!$admin) {
            return $this->failForbidden('Akses ditolak. Hanya admin yang bisa mengakses');
        }

        $booking = $this->db->table('bookings')->where('id', $id)->get()->getRowArray();
        
        if (!$booking) {
            return $this->failNotFound('Booking tidak ditemukan');
        }

        try {
            
            if (!empty($booking['foto_sepatu'])) {
                $photoPath = FCPATH . 'uploads/' . $booking['foto_sepatu'];
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }

           
            if (!empty($booking['foto_hasil'])) {
                $photoPath = FCPATH . 'uploads/' . $booking['foto_hasil'];
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }

            $this->db->table('bookings')->where('id', $id)->delete();

            return $this->respond([
                'success' => true,
                'message' => 'Booking berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('Gagal menghapus booking: ' . $e->getMessage());
        }
    }

    
    public function statistics()
    {
        $admin = $this->checkAdmin();
        if (!$admin) {
            return $this->failForbidden('Akses ditolak. Hanya admin yang bisa mengakses');
        }

        $stats = [
            'total' => $this->db->table('bookings')->countAllResults(),
            'pending' => $this->db->table('bookings')->where('status', 'pending')->countAllResults(),
            'disetujui' => $this->db->table('bookings')->where('status', 'disetujui')->countAllResults(),
            'proses' => $this->db->table('bookings')->where('status', 'proses')->countAllResults(),
            'selesai' => $this->db->table('bookings')->where('status', 'selesai')->countAllResults(),
            'ditolak' => $this->db->table('bookings')->where('status', 'ditolak')->countAllResults(),
            'batal' => $this->db->table('bookings')->where('status', 'batal')->countAllResults(),
        ];

      
        $revenue = $this->db->table('bookings')
            ->where('status', 'selesai')
            ->selectSum('total')
            ->get()
            ->getRow();

        $stats['total_revenue'] = $revenue->total ?? 0;

        return $this->respond([
            'success' => true,
            'data' => $stats
        ]);
    }
}