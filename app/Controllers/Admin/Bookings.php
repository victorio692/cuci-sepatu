<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Config\Database;

class Bookings extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        $status = $this->request->getVar('status');
        $search = $this->request->getVar('search');

        $query = $this->db->table('bookings')
            ->select('bookings.*, users.full_name, users.email, users.phone')
            ->join('users', 'bookings.user_id = users.id');

        if ($status) {
            $query->where('bookings.status', $status);
        }

        if ($search) {
            $query->groupStart()
                ->like('users.full_name', $search)
                ->orLike('users.email', $search)
                ->orLike('bookings.service', $search)
                ->groupEnd();
        }

        $bookings = $query->orderBy('bookings.created_at', 'DESC')
            ->paginate(20);

        $data = [
            'title' => 'Pesanan - Admin SYH Cleaning',
            'bookings' => $bookings,
            'pager' => $this->db->pager,
            'status' => $status,
            'search' => $search,
        ];

        return view('admin/bookings', $data);
    }

    public function detail($id)
    {
        $booking = $this->db->table('bookings')
            ->select('bookings.*, users.full_name, users.email, users.phone, users.address, users.city, users.province, users.zip_code')
            ->join('users', 'bookings.user_id = users.id')
            ->where('bookings.id', $id)
            ->get()
            ->getRow();

        if (!$booking) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Detail Pesanan - Admin SYH Cleaning',
            'booking' => (array)$booking,
        ];

        return view('admin/booking_detail', $data);
    }

    public function updateStatus($id)
    {
        $status = $this->request->getJSON()->status ?? $this->request->getPost('status');

        if (!in_array($status, ['pending', 'approved', 'in_progress', 'completed', 'cancelled'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid status']);
        }

        $booking = $this->db->table('bookings')->find($id);
        if (!$booking) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Booking not found']);
        }

        $this->db->table('bookings')->update(['status' => $status], ['id' => $id]);

        return $this->response->setJSON(['success' => true, 'message' => 'Status updated']);
    }
}
