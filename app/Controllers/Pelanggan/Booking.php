<?php

namespace App\Controllers\Pelanggan;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\LayananModel;

class Booking extends BaseController
{
    protected $bookingModel;
    protected $layananModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->layananModel = new LayananModel();
    }

    /**
     * Halaman daftar booking pelanggan
     */
    public function index()
    {
        $userId = session()->get('user_id');
        
        $data = [
            'title'    => 'Riwayat Booking',
            'bookings' => $this->bookingModel->getByUser($userId),
        ];

        return view('pelanggan/bookings', $data);
    }

    /**
     * Form booking baru
     */
    public function create()
    {
        $data = [
            'title'   => 'Booking Cuci Sepatu',
            'layanan' => $this->layananModel->getAktif(),
        ];

        return view('pelanggan/booking_form', $data);
    }

    /**
     * Simpan booking baru
     */
    public function store()
    {
        $rules = [
            'layanan_id'      => 'required|integer',
            'jumlah_sepatu'   => 'required|integer|greater_than[0]',
            'tanggal_booking' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $layananId = $this->request->getPost('layanan_id');
        $layanan = $this->layananModel->find($layananId);
        
        if (!$layanan) {
            return redirect()->back()->withInput()->with('error', 'Layanan tidak ditemukan');
        }

        // Hitung total harga
        $jumlahSepatu = $this->request->getPost('jumlah_sepatu');
        $totalHarga = $layanan['harga'] * $jumlahSepatu;

        $data = [
            'user_id'         => session()->get('user_id'),
            'layanan_id'      => $layananId,
            'jumlah_sepatu'   => $jumlahSepatu,
            'tanggal_booking' => $this->request->getPost('tanggal_booking'),
            'catatan'         => $this->request->getPost('catatan'),
            'total_harga'     => $totalHarga,
            'status'          => 'menunggu',
        ];

        if ($this->bookingModel->save($data)) {
            return redirect()->to('/pelanggan/booking')->with('success', 'Booking berhasil dibuat! Silakan tunggu konfirmasi admin');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal membuat booking');
    }

    /**
     * Detail booking
     */
    public function detail($id)
    {
        $userId = session()->get('user_id');
        $booking = $this->bookingModel->getWithDetails($id);
        
        // Pastikan booking milik user yang login
        if (!$booking || $booking['user_id'] != $userId) {
            return redirect()->to('/pelanggan/booking')->with('error', 'Booking tidak ditemukan');
        }

        $data = [
            'title'   => 'Detail Booking',
            'booking' => $booking,
        ];

        return view('pelanggan/booking_detail', $data);
    }

    /**
     * Batalkan booking (hanya jika status = menunggu)
     */
    public function cancel($id)
    {
        $userId = session()->get('user_id');
        $booking = $this->bookingModel->find($id);
        
        // Validasi
        if (!$booking || $booking['user_id'] != $userId) {
            return redirect()->to('/pelanggan/booking')->with('error', 'Booking tidak ditemukan');
        }

        if ($booking['status'] !== 'menunggu') {
            return redirect()->back()->with('error', 'Hanya booking dengan status "menunggu" yang dapat dibatalkan');
        }

        if ($this->bookingModel->updateStatus($id, 'dibatalkan')) {
            return redirect()->to('/pelanggan/booking')->with('success', 'Booking berhasil dibatalkan');
        }

        return redirect()->back()->with('error', 'Gagal membatalkan booking');
    }
}
