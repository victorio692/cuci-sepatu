<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardApi extends BaseController
{
    public function stats(): ResponseInterface
    {
        $userId = session()->get('user_id');
        
        // Validasi session
        if (!$userId) {
            return $this->response->setJSON([
                'code' => 401,
                'message' => 'Unauthorized. Silakan login terlebih dahulu'
            ]);
        }
        
        $db = db_connect();

        //total booking
        $totalBookings = $db->table('bookings')
            ->where('id_user', $userId)
            ->countAllResults();

        //booking selesai
        $completedBookings = $db->table('bookings')
            ->where('id_user', $userId)
            ->where('status', 'selesai')
            ->countAllResults();

        //booking pending
        $pendingBookings = $db->table('bookings')
            ->where('id_user', $userId)
            ->where('status', 'pending')
            ->countAllResults();

        //total pengeluaran (dari bookings yang selesai)
        $pengeluaran = $db->table('bookings')
            ->where('id_user', $userId)
            ->where('status', 'selesai')
            ->selectSum('total')
            ->get()
            ->getRow()
            ->total ?? 0;
        
        // Get user data untuk member_sejak
        $user = $db->table('users')
            ->select('dibuat_pada')
            ->where('id', $userId)
            ->get()
            ->getRow();
        
        return $this->response->setJSON([
            'code' => 200,
            'data' => [
                'total_booking' => $totalBookings,
                'booking_selesai' => $completedBookings,
                'booking_pending' => $pendingBookings,
                'total_pengeluaran' => (int)$pengeluaran,
                'member_sejak' => $user ? date('d/m/Y', strtotime($user->dibuat_pada)) : '-'
            ]
        ]);
    }

    public function recentBookings(): ResponseInterface
    {
        $userId = session()->get('user_id');
        
        // Validasi session
        if (!$userId) {
            return $this->response->setJSON([
                'code' => 401,
                'message' => 'Unauthorized. Silakan login terlebih dahulu'
            ]);
        }
        
        $limit = 10; // Default limit 10 booking terbaru
        $db = db_connect();

        $data = $db->table('bookings')
            ->where('id_user', $userId)
            ->orderBy('id', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'code' => 200,
            'data' => $data
        ]);
    }
}