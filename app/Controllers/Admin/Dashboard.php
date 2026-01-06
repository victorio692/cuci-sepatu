<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\LayananModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $bookingModel;
    protected $layananModel;
    protected $userModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->layananModel = new LayananModel();
        $this->userModel = new UserModel();
    }

    /**
     * Dashboard Admin dengan statistik
     */
    public function index()
    {
        $data = [
            'title' => 'Dashboard Admin',
            'stats' => [
                'total_booking' => $this->bookingModel->countAll(),
                'booking_menunggu' => $this->bookingModel->where('status', 'menunggu')->countAllResults(),
                'booking_diproses' => $this->bookingModel->where('status', 'diproses')->countAllResults(),
                'booking_selesai' => $this->bookingModel->where('status', 'selesai')->countAllResults(),
                'total_pelanggan' => $this->userModel->where('role', 'pelanggan')->countAllResults(),
                'total_layanan' => $this->layananModel->countAll(),
            ],
            'latest_bookings' => $this->bookingModel->getWithDetails(),
        ];

        return view('admin/dashboard', $data);
    }
}
