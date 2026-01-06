<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;

class Bookings extends BaseController
{
    protected $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
    }

    /**
     * Halaman kelola booking
     */
    public function index()
    {
        $data = [
            'title'    => 'Kelola Booking',
            'bookings' => $this->bookingModel->getWithDetails(),
            'stats'    => $this->bookingModel->getStatistik(),
        ];

        return view('admin/bookings', $data);
    }

    /**
     * Detail booking
     */
    public function detail($id)
    {
        $booking = $this->bookingModel->getWithDetails($id);
        
        if (!$booking) {
            return redirect()->to('/admin/bookings')->with('error', 'Booking tidak ditemukan');
        }

        $data = [
            'title'   => 'Detail Booking',
            'booking' => $booking,
        ];

        return view('admin/booking_detail', $data);
    }

    /**
     * Update status booking
     */
    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');
        
        // Validasi status
        $validStatus = ['menunggu', 'diterima', 'diproses', 'selesai', 'dibatalkan'];
        if (!in_array($status, $validStatus)) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }

        if ($this->bookingModel->updateStatus($id, $status)) {
            return redirect()->back()->with('success', 'Status booking berhasil diupdate');
        }

        return redirect()->back()->with('error', 'Gagal mengupdate status booking');
    }

    /**
     * Hapus booking
     */
    public function delete($id)
    {
        if ($this->bookingModel->delete($id)) {
            return redirect()->to('/admin/bookings')->with('success', 'Booking berhasil dihapus');
        }

        return redirect()->to('/admin/bookings')->with('error', 'Gagal menghapus booking');
    }

    /**
     * Filter booking berdasarkan status
     */
    public function filterByStatus($status)
    {
        $bookings = $this->bookingModel->where('status', $status)->getWithDetails();
        
        $data = [
            'title'    => 'Booking - ' . ucfirst($status),
            'bookings' => $bookings,
            'filter'   => $status,
        ];

        return view('admin/bookings', $data);
    }
}
