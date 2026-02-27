<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class NotificationsApi extends ResourceController
{
    use ResponseTrait;
    protected $format = 'json';
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /**
     * GET /api/notifications
     * List semua notifikasi user yang login
     */
    public function index()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Unauthorized. Silakan login terlebih dahulu'
            ], 401);
        }

        $notifications = $this->db->table('notifications')
            ->where('id_user', $userId)
            ->orderBy('dibuat_pada', 'DESC')
            ->get()
            ->getResultArray();

        return $this->respond([
            'status' => 'success',
            'message' => 'Notifikasi berhasil diambil',
            'data' => $notifications,
            'total' => count($notifications)
        ]);
    }

    /**
     * GET /api/notifications/unread
     * List notifikasi yang belum dibaca
     */
    public function unread()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return $this->response->setJSON(['count' => 0, 'notifications' => []]);
        }

        $count = $this->db->table('notifications')
            ->where('id_user', $userId)
            ->where('dibaca', 0)
            ->countAllResults();

        $notifications = $this->db->table('notifications')
            ->where('id_user', $userId)
            ->where('dibaca', 0)
            ->orderBy('dibuat_pada', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'count' => $count,
            'notifications' => $notifications
        ]);
    }

    /**
     * GET /api/notifications/count
     * Hitung jumlah notifikasi belum dibaca
     */
    public function count()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Unauthorized. Silakan login terlebih dahulu'
            ], 401);
        }

        $unreadCount = $this->db->table('notifications')
            ->where('id_user', $userId)
            ->where('dibaca', 0)
            ->countAllResults();

        $totalCount = $this->db->table('notifications')
            ->where('id_user', $userId)
            ->countAllResults();

        return $this->respond([
            'status' => 'success',
            'message' => 'Jumlah notifikasi belum dibaca',
            'data' => [
                'unread_count' => $unreadCount,
                'total_count' => $totalCount
            ]
        ]);
    }

    /**
     * GET /api/notifications/{id}
     * Detail notifikasi tertentu
     */
    public function show($id = null)
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Unauthorized. Silakan login terlebih dahulu'
            ], 401);
        }

        $notification = $this->db->table('notifications')
            ->where('id', $id)
            ->where('id_user', $userId)
            ->get()
            ->getRowArray();

        if (!$notification) {
            return $this->failNotFound('Notifikasi tidak ditemukan');
        }

        // Get booking detail if exists
        if (!empty($notification['booking_id'])) {
            $booking = $this->db->table('bookings')
                ->select('id, layanan, status, total')
                ->where('id', $notification['booking_id'])
                ->get()
                ->getRowArray();
            
            $notification['booking'] = $booking;
        }

        return $this->respond([
            'status' => 'success',
            'message' => 'Detail notifikasi berhasil diambil',
            'data' => $notification
        ]);
    }

    /**
     * PUT /api/notifications/{id}/read
     * Tandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead($id = null)
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $notification = $this->db->table('notifications')
            ->where('id', $id)
            ->where('id_user', $userId)
            ->get()
            ->getRowArray();

        if (!$notification) {
            return $this->response->setJSON(['success' => false, 'message' => 'Notification not found']);
        }

        $this->db->table('notifications')
            ->where('id', $id)
            ->update(['dibaca' => 1]);

        return $this->response->setJSON(['success' => true]);
    }

    /**
     * PUT /api/notifications/read-all
     * Tandai semua notifikasi sebagai sudah dibaca
     */
    public function markAllAsRead()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $this->db->table('notifications')
            ->where('id_user', $userId)
            ->where('dibaca', 0)
            ->update(['dibaca' => 1]);

        return $this->response->setJSON(['success' => true]);
    }

    /**
     * DELETE /api/notifications/{id}
     * Hapus notifikasi tertentu
     */
    public function delete($id = null)
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Unauthorized. Silakan login terlebih dahulu'
            ], 401);
        }

        $notification = $this->db->table('notifications')
            ->where('id', $id)
            ->where('id_user', $userId)
            ->get()
            ->getRowArray();

        if (!$notification) {
            return $this->failNotFound('Notifikasi tidak ditemukan');
        }

        $this->db->table('notifications')
            ->where('id', $id)
            ->delete();

        return $this->respond([
            'status' => 'success',
            'message' => 'Notifikasi berhasil dihapus'
        ]);
    }

    /**
     * DELETE /api/notifications/clear
     * Hapus semua notifikasi user
     */
    public function clear()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Unauthorized. Silakan login terlebih dahulu'
            ], 401);
        }

        $deletedCount = $this->db->table('notifications')
            ->where('id_user', $userId)
            ->countAllResults(false);

        $this->db->table('notifications')
            ->where('id_user', $userId)
            ->delete();

        return $this->respond([
            'status' => 'success',
            'message' => 'Semua notifikasi berhasil dihapus',
            'data' => [
                'deleted_count' => $deletedCount
            ]
        ]);
    }
}