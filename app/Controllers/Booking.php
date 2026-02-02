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
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();

        // Validate file upload
        $validationRule = [
            'shoe_photo' => [
                'label' => 'Foto Sepatu',
                'rules' => 'uploaded[shoe_photo]'
                    . '|is_image[shoe_photo]'
                    . '|mime_in[shoe_photo,image/jpg,image/jpeg,image/png]'
                    . '|max_size[shoe_photo,5120]', // 5MB in KB
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Foto sepatu wajib diupload (format PNG/JPG/JPEG, maksimal 5MB)');
        }

        // Handle file upload
        $file = $this->request->getFile('shoe_photo');
        $fileName = null;
        
        if ($file->isValid() && !$file->hasMoved()) {
            // Generate unique filename
            $fileName = $file->getRandomName();
            // Move to public/uploads directory
            $uploadPath = FCPATH . 'uploads';
            
            // Create directory if not exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $file->move($uploadPath, $fileName);
        }

        $service = $this->request->getPost('service');
        $shoe_type = $this->request->getPost('shoe_type');
        $shoe_condition = $this->request->getPost('shoe_condition');
        $quantity = $this->request->getPost('quantity');
        $delivery_date = $this->request->getPost('delivery_date');
        $booking_time = $this->request->getPost('booking_time');
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

        // Create notification for all admins
        $admins = $this->db->table('users')->where('is_admin', 1)->get()->getResultArray();
        
        foreach ($admins as $admin) {
            $this->db->table('notifications')->insert([
                'id_user' => $admin['id'],
                'booking_id' => $booking_id,
                'judul' => 'Booking Baru! 🔔',
                'pesan' => "Ada booking baru dari customer dengan ID #{$booking_id}. Layanan: {$service}, Jumlah: {$quantity} pasang sepatu.",
                'tipe' => 'new_booking'
            ]);
        }

        return redirect()->to('/my-bookings')->with('success', 'Pesanan berhasil dibuat!');
    }

    // Booking Detail
    public function detail($bookingId)
    {
        $user_id = session()->get('user_id');
        
        $booking = $this->db->table('bookings')
            ->where('id', $bookingId)
            ->where('id_user', $user_id)
            ->get()
            ->getRowArray();

        if (!$booking) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Detail Pesanan - SYH Cleaning',
            'booking' => $booking,
        ];

        return view('pages/booking_detail', $data);
    }

    // Cancel Booking
    public function cancelBooking($bookingId)
    {
        $user_id = session()->get('user_id');
        
        $booking = $this->db->table('bookings')
            ->where('id', $bookingId)
            ->where('id_user', $user_id)
            ->get()
            ->getRowArray();

        if (!$booking) {
            return redirect()->to('/my-bookings')->with('error', 'Pesanan tidak ditemukan');
        }

        // Only allow cancel if status is pending
        if ($booking['status'] !== 'pending') {
            return redirect()->back()->with('error', 'Pesanan tidak bisa dibatalkan pada status ini');
        }

        $this->db->table('bookings')->update(['status' => 'batal'], ['id' => $bookingId]);

        return redirect()->to('/my-bookings')->with('success', 'Pesanan berhasil dibatalkan');
    }

    // Get Service Price
    private function getServicePrice($service)
    {
        $prices = [
            'fast-cleaning' => 15000,
            'deep-cleaning' => 20000,
            'white-shoes' => 35000,
            'suede-treatment' => 30000,
            'unyellowing' => 30000,
        ];

        return $prices[$service] ?? 0;
    }
}

