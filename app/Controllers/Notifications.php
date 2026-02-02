<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Notifications extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return redirect()->to('/login');
        }

        // Note: notifications table doesn't exist in current DB
        $notifications = [];

        return view('pages/notifications', [
            'notifications' => $notifications
        ]);
    }

    public function getUnread()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return $this->response->setJSON(['count' => 0, 'notifications' => []]);
        }

        // Note: notifications table doesn't exist in current DB
        return $this->response->setJSON([
            'count' => 0,
            'notifications' => []
        ]);
    }

    public function markAsRead($id)
    {
        $userId = session()->get('user_id');
        
        // Note: notifications table doesn't exist in current DB
        return $this->response->setJSON(['success' => true]);
    }

    public function markAllAsRead()
    {
        $userId = session()->get('user_id');
        
        // Note: notifications table doesn't exist in current DB
        return $this->response->setJSON(['success' => true]);
    }

    public function sendWhatsApp($bookingId)
    {
        $userId = session()->get('user_id');
        $userRole = session()->get('role');

        if ($userRole !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        // Get booking and customer info
        $booking = $this->db->table('bookings')
            ->select('bookings.*, users.full_name, users.phone')
            ->join('users', 'bookings.user_id = users.id')
            ->where('bookings.id', $bookingId)
            ->get()
            ->getRowArray();

        if (!$booking) {
            return $this->response->setJSON(['success' => false, 'message' => 'Booking not found']);
        }

        // Format phone number (remove leading 0, add 62)
        $phone = $booking['phone'];
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // Create WhatsApp message
        $message = "Halo {$booking['full_name']},\n\n";
        $message .= "Sepatu Anda dengan booking ID #{$bookingId} sudah selesai dicuci! ✨\n\n";
        $message .= "Layanan: {$booking['service']}\n";
        $message .= "Jumlah: {$booking['quantity']} pasang\n";
        $message .= "Total: Rp " . number_format($booking['total'], 0, ',', '.') . "\n\n";
        $message .= "Silakan ambil sepatu Anda di SYH.CLEANING.\n\n";
        $message .= "Terima kasih! 🙏";

        $waLink = "https://wa.me/" . $phone . "?text=" . urlencode($message);

        return $this->response->setJSON([
            'success' => true,
            'whatsapp_link' => $waLink
        ]);
    }
}
