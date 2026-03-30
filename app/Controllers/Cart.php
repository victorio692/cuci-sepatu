<?php

namespace App\Controllers;

use Config\Database;

class Cart extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Tambah item ke keranjang (session)
    public function addToCart()
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek jika admin, redirect ke admin dashboard
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin')->with('error', 'Admin tidak bisa menggunakan keranjang belanja');
        }

        // Cek file yang diupload valid atau tidak
        $validationRule = [
            'shoe_photo' => [
                'label' => 'Foto Sepatu',
                'rules' => 'uploaded[shoe_photo]'
                    . '|is_image[shoe_photo]'
                    . '|mime_in[shoe_photo,image/jpg,image/jpeg,image/png]'
                    . '|max_size[shoe_photo,5120]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Foto sepatu wajib diupload (format PNG/JPG/JPEG, maksimal 5MB)');
        }

        // Proses upload file
        $file = $this->request->getFile('shoe_photo');
        $fileName = null;
        
        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $file->move($uploadPath, $fileName);
        }

        // Ambil data dari form
        $serviceCode = $this->request->getPost('service');
        $quantity = $this->request->getPost('quantity');
        $shoeCondition = $this->request->getPost('shoe_condition');
        $deliveryOption = $this->request->getPost('delivery_option');
        $deliveryAddress = $this->request->getPost('delivery_address');
        $notes = $this->request->getPost('notes');

        // Ambil detail layanan berdasarkan kode layanan
        $service = $this->db->table('services')->where('kode_layanan', $serviceCode)->get()->getRowArray();
        
        if (!$service) {
            return redirect()->back()->with('error', 'Layanan tidak ditemukan');
        }

        // Ambil keranjang dari session atau buat baru jika belum ada
        $cart = session()->get('cart') ?? [];

        // Masukkan item ke keranjang
        $cartItem = [
            'service_id' => $service['id'],
            'service_code' => $service['kode_layanan'],
            'service_name' => $service['nama_layanan'],
            'service_price' => $service['harga_dasar'],
            'quantity' => $quantity,
            'shoe_condition' => $shoeCondition,
            'delivery_option' => $deliveryOption,
            'delivery_address' => $deliveryAddress,
            'notes' => $notes,
            'shoe_photo' => $fileName,
            'added_at' => date('Y-m-d H:i:s')
        ];

        $cart[] = $cartItem;

        // Simpan ke session
        session()->set('cart', $cart);

        return redirect()->to('/cart')->with('success', 'Layanan berhasil ditambahkan ke keranjang!');
    }

    // Tampilkan isi keranjang
    public function viewCart()
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek jika admin, redirect ke admin dashboard
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin')->with('error', 'Admin tidak bisa menggunakan keranjang belanja');
        }

        $cart = session()->get('cart') ?? [];
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['service_price'] * $item['quantity'];
        }

        $data = [
            'title' => 'Keranjang - SYH Cleaning',
            'cart' => $cart,
            'total' => $total
        ];

        return view('pages/cart', $data);
    }

    // Hapus item dari keranjang
    public function removeFromCart($index)
    {
        $cart = session()->get('cart') ?? [];

        if (isset($cart[$index])) {
            // Hapus file foto kalau ada
            if (!empty($cart[$index]['shoe_photo'])) {
                $photoPath = FCPATH . 'uploads/' . $cart[$index]['shoe_photo'];
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }

            unset($cart[$index]);
            $cart = array_values($cart); // Rapikan ulang indeks array
            session()->set('cart', $cart);

            return redirect()->to('/cart')->with('success', 'Item berhasil dihapus dari keranjang');
        }

        return redirect()->to('/cart')->with('error', 'Item tidak ditemukan');
    }

    // Update jumlah item
    public function updateQuantity()
    {
        $index = $this->request->getPost('index');
        $quantity = $this->request->getPost('quantity');

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$index]) && $quantity > 0) {
            $cart[$index]['quantity'] = $quantity;
            session()->set('cart', $cart);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Jumlah berhasil diupdate'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Item tidak ditemukan'
        ]);
    }

    // Proses checkout (simpan ke booking lalu kosongkan keranjang) 
    public function checkout()
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek jika admin, redirect ke admin dashboard
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin')->with('error', 'Admin tidak bisa checkout');
        }

        $cart = session()->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to('/cart')->with('error', 'Keranjang kosong');
        }

        // Ambil index item yang dipilih untuk checkout
        $selectedItems = $this->request->getPost('selected_items');
        
        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Pilih minimal 1 item untuk checkout');
        }

        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();

        // Ambil tanggal dan waktu booking dari request
        $deliveryDate = $this->request->getPost('delivery_date');
        $bookingTime = $this->request->getPost('booking_time');

        if (!$deliveryDate || !$bookingTime) {
            return redirect()->back()->with('error', 'Tanggal dan waktu pengiriman harus diisi');
        }

        // Mulai transaksi
        $this->db->transStart();

        try {
            // Simpan setiap item yang dipilih ke tabel bookings    
            $checkedOutItems = [];
            foreach ($selectedItems as $index) {
                if (!isset($cart[$index])) {
                    continue;
                }
                
                $item = $cart[$index];
                $totalPrice = $item['service_price'] * $item['quantity'];
                $deliveryFee = ($item['delivery_option'] === 'delivery') ? 5000 : 0;

                $bookingData = [
                    'id_user' => $user_id,
                    'layanan' => $item['service_name'],
                    'kondisi_sepatu' => $item['shoe_condition'],
                    'jumlah' => $item['quantity'],
                    'tanggal_kirim' => $deliveryDate,
                    'jam_booking' => $bookingTime,
                    'foto_sepatu' => $item['shoe_photo'],
                    'opsi_kirim' => $item['delivery_option'],
                    'alamat_kirim' => $item['delivery_address'] ?? $user['alamat'],
                    'catatan' => $item['notes'],
                    'subtotal' => $totalPrice,
                    'biaya_kirim' => $deliveryFee,
                    'total' => $totalPrice + $deliveryFee,
                    'status' => 'pending',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $insertResult = $this->db->table('bookings')->insert($bookingData);
                
                if (!$insertResult) {
                    $error = $this->db->error();
                    log_message('error', 'Failed to insert booking: ' . json_encode($error));
                    throw new \Exception('Gagal insert booking: ' . ($error['message'] ?? 'Unknown error'));
                }

                // Tandai item yang sudah dicheckout untuk dihapus dari cart nanti
                $checkedOutItems[] = $index;
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                $error = $this->db->error();
                log_message('error', 'Transaction failed: ' . json_encode($error));
                throw new \Exception('Gagal menyimpan booking: ' . ($error['message'] ?? 'Transaction failed'));
            }

            // Hapus item yang sudah dicheckout dari cart
            foreach ($checkedOutItems as $index) {
                unset($cart[$index]);
            }
            
            // Rapikan ulang indeks array setelah penghapusan
            $cart = array_values($cart);
            
            // Update keranjang di session
            if (empty($cart)) {
                session()->remove('cart');
            } else {
                session()->set('cart', $cart);
            }

            // Kirim notifikasi ke user bahwa booking berhasil dibuat
            $this->sendBookingNotification($user_id);

            $message = count($checkedOutItems) . ' item berhasil dicheckout! Booking Anda sedang diproses.';
            return redirect()->to('/my-bookings')->with('success', $message);

        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Checkout error: ' . $e->getMessage());
            return redirect()->to('/cart')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Fungsi untuk mengirim notifikasi ke user setelah booking berhasil dibuat
    private function sendBookingNotification($userId)
    {
        $notificationData = [
            'id_user' => $userId,
            'tipe' => 'booking',
            'judul' => 'Booking Berhasil',
            'pesan' => 'Booking Anda telah berhasil dibuat dan sedang menunggu konfirmasi admin.',
            'dibaca' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('notifications')->insert($notificationData);
    }
}
