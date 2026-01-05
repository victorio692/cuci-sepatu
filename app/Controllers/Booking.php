<?php

namespace App\Controllers;

use Config\Database;

class Booking extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Show Booking Form
    public function makeBooking()
    {
        $data = [
            'title' => 'Pesan Layanan - SYH Cleaning',
        ];

        return view('pages/booking', $data);
    }

    // Submit Booking
    public function submitBooking()
    {
        $user_id = session()->get('user_id');
        $user = $this->db->table('users')->find($user_id);

        $service = $this->request->getPost('service');
        $shoe_type = $this->request->getPost('shoe_type');
        $shoe_condition = $this->request->getPost('shoe_condition');
        $quantity = $this->request->getPost('quantity');
        $delivery_date = $this->request->getPost('delivery_date');
        $delivery_option = $this->request->getPost('delivery_option');
        $delivery_address = $this->request->getPost('delivery_address') ?? $user['address'];
        $notes = $this->request->getPost('notes');

        // Get service price
        $servicePrice = $this->getServicePrice($service);
        $delivery_fee = $delivery_option === 'home' ? 5000 : 0;
        $subtotal = $servicePrice * $quantity;
        $total = $subtotal + $delivery_fee;

        // Insert booking
        $booking_data = [
            'user_id' => $user_id,
            'service' => $service,
            'shoe_type' => $shoe_type,
            'shoe_condition' => $shoe_condition,
            'quantity' => $quantity,
            'delivery_date' => $delivery_date,
            'delivery_option' => $delivery_option,
            'delivery_address' => $delivery_address,
            'notes' => $notes,
            'subtotal' => $subtotal,
            'delivery_fee' => $delivery_fee,
            'total' => $total,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('bookings')->insert($booking_data);
        $booking_id = $this->db->insertID();

        return redirect()->to('/my-bookings')->with('success', 'Pesanan berhasil dibuat!');
    }

    // Booking Detail
    public function detail($bookingId)
    {
        $user_id = session()->get('user_id');
        
        $booking = $this->db->table('bookings')
            ->where('id', $bookingId)
            ->where('user_id', $user_id)
            ->get()
            ->getRow();

        if (!$booking) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Detail Pesanan - SYH Cleaning',
            'booking' => (array)$booking,
        ];

        return view('pages/booking_detail', $data);
    }

    // Cancel Booking
    public function cancelBooking($bookingId)
    {
        $user_id = session()->get('user_id');
        
        $booking = $this->db->table('bookings')
            ->where('id', $bookingId)
            ->where('user_id', $user_id)
            ->get()
            ->getRow();

        if (!$booking) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan');
        }

        // Only allow cancel if status is pending or approved
        if (!in_array($booking->status, ['pending', 'approved'])) {
            return redirect()->back()->with('error', 'Pesanan tidak bisa dibatalkan pada status ini');
        }

        $this->db->table('bookings')->update(['status' => 'cancelled'], ['id' => $bookingId]);

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan');
    }

    // Get Service Price
    private function getServicePrice($service)
    {
        $prices = [
            'fast-cleaning' => 15000,
            'deep-cleaning' => 20000,
            'white-shoes' => 35000,
            'coating' => 25000,
            'dyeing' => 40000,
            'repair' => 50000,
        ];

        return $prices[$service] ?? 0;
    }
}

