<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PaymentModel;
use App\Models\BookingModel;

class Payments extends BaseController
{
    protected $paymentModel;
    protected $bookingModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
        $this->bookingModel = new BookingModel();
    }

    /**
     * List all payments
     */
    public function index()
    {
        // Check if user is admin
        if (!session()->get('user_id') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses');
        }

        // Get all payments with pagination
        $perPage = 20;
        $page = $this->request->getVar('page') ?? 1;
        $offset = ($page - 1) * $perPage;

        // Get payments with sorting
        $sort = $this->request->getVar('sort') ?? 'created_at';
        $order = $this->request->getVar('order') ?? 'DESC';
        $status = $this->request->getVar('status') ?? '';

        $query = $this->paymentModel;

        if (!empty($status)) {
            $query = $query->where('status', $status);
        }

        $payments = $query->orderBy($sort, $order)
            ->limit($perPage, $offset)
            ->findAll();

        $totalPayments = $this->paymentModel->countAllResults();

        // Get payment statistics
        $stats = $this->paymentModel->getPaymentStats();

        $data = [
            'title' => 'Manajemen Pembayaran - SYH Cleaning',
            'payments' => $payments,
            'total_payments' => $totalPayments,
            'stats' => $stats,
            'current_status' => $status,
            'current_sort' => $sort,
            'current_order' => $order,
        ];

        return view('admin/payments/index', $data);
    }

    /**
     * Payment detail page
     */
    public function detail($id)
    {
        // Check if user is admin
        if (!session()->get('user_id') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses');
        }

        $payment = $this->paymentModel->find($id);

        if (!$payment) {
            return redirect()->back()->with('error', 'Pembayaran tidak ditemukan');
        }

        $booking = $this->bookingModel->find($payment['booking_id']);

        $data = [
            'title' => 'Detail Pembayaran #' . $id . ' - SYH Cleaning',
            'payment' => $payment,
            'booking' => $booking,
        ];

        return view('admin/payments/detail', $data);
    }

    /**
     * Update payment status
     */
    public function updateStatus($id)
    {
        // Check if user is admin
        if (!session()->get('user_id') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses');
        }

        if ($this->request->getMethod() !== 'post') {
            return redirect()->back()->with('error', 'Method tidak diizinkan');
        }

        $payment = $this->paymentModel->find($id);

        if (!$payment) {
            return redirect()->back()->with('error', 'Pembayaran tidak ditemukan');
        }

        $newStatus = $this->request->getPost('status');
        $notes = $this->request->getPost('notes') ?? '';

        // Validate status
        $validStatuses = ['pending', 'approved', 'failed', 'cancelled'];
        if (!in_array($newStatus, $validStatuses)) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }

        // Update payment
        $this->paymentModel->updateStatus($id, $newStatus, $notes);

        // If status is approved, update booking status
        if ($newStatus === 'approved') {
            $this->bookingModel->update($payment['booking_id'], [
                'status' => 'approved',
            ]);
        }

        return redirect()->back()
            ->with('success', 'Status pembayaran berhasil diperbarui');
    }

    /**
     * Get payment statistics
     */
    public function statistics()
    {
        // Check if user is admin
        if (!session()->get('user_id') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses');
        }

        $stats = $this->paymentModel->getPaymentStats();

        $data = [
            'title' => 'Statistik Pembayaran - SYH Cleaning',
            'stats' => $stats,
        ];

        return view('admin/payments/statistics', $data);
    }
}
