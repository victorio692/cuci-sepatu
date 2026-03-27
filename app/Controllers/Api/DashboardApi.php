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
        
        // ambil data user untuk menampilkan sejak kapan menjadi member
        $user = $db->table('users')
            ->select('created_at')
            ->where('id', $userId)
            ->get()
            ->getRow();
        
        // hitung jumlah booking berdasarkan status
        $statusCounts = [
            'pending' => $db->table('bookings')->where(['id_user' => $userId, 'status' => 'pending'])->countAllResults(),
            'disetujui' => $db->table('bookings')->where(['id_user' => $userId, 'status' => 'disetujui'])->countAllResults(),
            'proses' => $db->table('bookings')->where(['id_user' => $userId, 'status' => 'proses'])->countAllResults(),
            'selesai' => $db->table('bookings')->where(['id_user' => $userId, 'status' => 'selesai'])->countAllResults(),
            'batal' => $db->table('bookings')->where(['id_user' => $userId, 'status' => 'batal'])->countAllResults(),
            'ditolak' => $db->table('bookings')->where(['id_user' => $userId, 'status' => 'ditolak'])->countAllResults(),
        ];
        
        return $this->response->setJSON([
            'code' => 200,
            'data' => [
                'total_booking' => $totalBookings,
                'booking_selesai' => $completedBookings,
                'booking_pending' => $pendingBookings,
                'total_pengeluaran' => (int)$pengeluaran,
                'member_sejak' => $user ? date('d/m/Y', strtotime($user->created_at)) : '-',
                'status_counts' => $statusCounts
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