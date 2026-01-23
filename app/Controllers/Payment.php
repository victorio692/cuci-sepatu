<?php

namespace App\Controllers;

use Config\Database;

class Payment extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Select payment method page
     */
    public function selectMethod($booking_id)
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login');
        }

        // Get booking
        $booking = $this->db->table('bookings')
            ->where('id', $booking_id)
            ->where('user_id', $user_id)
            ->get()
            ->getRow();

        if (!$booking) {
            return redirect()->to('/customer/dashboard')
                ->with('error', 'Pesanan tidak ditemukan');
        }

        $data = [
            'title' => 'Pilih Metode Pembayaran - SYH Cleaning',
            'booking' => $booking,
            'payment_methods' => [
                [
                    'code' => 'bank_transfer',
                    'name' => 'Transfer Bank',
                    'icon' => 'fas fa-university',
                    'description' => 'Transfer ke rekening bank kami',
                    'fee' => 0
                ],
                [
                    'code' => 'e_wallet',
                    'name' => 'E-Wallet (OVO, DANA, GCash)',
                    'icon' => 'fas fa-mobile-alt',
                    'description' => 'Pembayaran via aplikasi e-wallet',
                    'fee' => 0
                ],
                [
                    'code' => 'cash',
                    'name' => 'Bayar di Tempat',
                    'icon' => 'fas fa-money-bill',
                    'description' => 'Bayar saat mengambil barang',
                    'fee' => 0
                ],
            ]
        ];

        return view('pages/select_payment_method', $data);
    }

    /**
     * Process payment
     */
    public function processPayment($booking_id)
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login');
        }

        $method = $this->request->getPost('payment_method');

        // Validate payment method
        $valid_methods = ['bank_transfer', 'e_wallet', 'cash'];
        if (!in_array($method, $valid_methods)) {
            return redirect()->back()
                ->with('error', 'Metode pembayaran tidak valid');
        }

        // Get booking
        $booking = $this->db->table('bookings')
            ->where('id', $booking_id)
            ->where('user_id', $user_id)
            ->get()
            ->getRow();

        if (!$booking) {
            return redirect()->to('/customer/dashboard')
                ->with('error', 'Pesanan tidak ditemukan');
        }

        // Update booking with payment method
        $this->db->table('bookings')->update([
            'payment_method' => $method,
            'status' => 'pending'
        ], ['id' => $booking_id]);

        // Create payment record
        $payment_data = [
            'booking_id' => $booking_id,
            'user_id' => $user_id,
            'amount' => $booking->total,
            'method' => $method,
            'status' => $method === 'cash' ? 'pending' : 'pending',
            'payment_code' => $this->generatePaymentCode(),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('payments')->insert($payment_data);

        // Redirect to payment confirmation
        return redirect()->to("/payment/confirmation/$booking_id")
            ->with('success', 'Metode pembayaran dipilih');
    }

    /**
     * Payment confirmation page
     */
    public function confirmation($booking_id)
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login');
        }

        // Get booking with payment info
        $booking = $this->db->table('bookings')
            ->where('id', $booking_id)
            ->where('user_id', $user_id)
            ->get()
            ->getRow();

        if (!$booking) {
            return redirect()->to('/customer/dashboard')
                ->with('error', 'Pesanan tidak ditemukan');
        }

        $payment = $this->db->table('payments')
            ->where('booking_id', $booking_id)
            ->get()
            ->getRow();

        // Get bank account info
        $bank_info = $this->getBankInfo();

        $data = [
            'title' => 'Konfirmasi Pembayaran - SYH Cleaning',
            'booking' => $booking,
            'payment' => $payment,
            'bank_info' => $bank_info
        ];

        return view('pages/payment_confirmation', $data);
    }

    /**
     * Verify payment (for bank transfer)
     */
    public function verify($booking_id)
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login');
        }

        // Check if payment is verified
        $payment = $this->db->table('payments')
            ->where('booking_id', $booking_id)
            ->where('user_id', $user_id)
            ->get()
            ->getRow();

        if (!$payment) {
            return redirect()->to('/customer/dashboard')
                ->with('error', 'Data pembayaran tidak ditemukan');
        }

        // In real scenario, this would check with bank API
        // For demo, we'll just update status
        $this->db->table('payments')->update([
            'status' => 'confirmed'
        ], ['id' => $payment->id]);

        // Update booking status
        $this->db->table('bookings')->update([
            'status' => 'approved'
        ], ['id' => $booking_id]);

        return redirect()->to("/customer/booking/$booking_id")
            ->with('success', 'Pembayaran berhasil dikonfirmasi! Pesanan Anda telah disetujui.');
    }

    /**
     * Generate unique payment code
     */
    private function generatePaymentCode()
    {
        return 'PAYMENT-' . strtoupper(uniqid()) . '-' . date('YmdHis');
    }

    /**
     * Get bank information
     */
    private function getBankInfo()
    {
        return [
            'bank_name' => 'BCA',
            'account_name' => 'SYH Cleaning',
            'account_number' => '1234567890',
            'branch' => 'Jakarta Pusat'
        ];
    }
}
