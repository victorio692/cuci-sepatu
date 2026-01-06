<?php

namespace App\Controllers\Pelanggan;

use App\Controllers\BaseController;
use App\Models\BookingModel;

class Dashboard extends BaseController
{
    protected $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
    }

    /**
     * Dashboard Pelanggan
     */
    public function index()
    {
        $userId = session()->get('user_id');
        
        $data = [
            'title'    => 'Dashboard Pelanggan',
            'bookings' => $this->bookingModel->getByUser($userId),
            'stats'    => [
                'total'     => $this->bookingModel->where('user_id', $userId)->countAllResults(),
                'menunggu'  => $this->bookingModel->where('user_id', $userId)->where('status', 'menunggu')->countAllResults(),
                'diproses'  => $this->bookingModel->where('user_id', $userId)->where('status', 'diproses')->countAllResults(),
                'selesai'   => $this->bookingModel->where('user_id', $userId)->where('status', 'selesai')->countAllResults(),
            ],
        ];

        return view('pelanggan/dashboard', $data);
    }
}
