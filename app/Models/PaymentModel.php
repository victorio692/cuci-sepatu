<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'booking_id',
        'user_id',
        'amount',
        'payment_method',
        'payment_code',
        'status',
        'notes',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';

    protected $validationRules = [
        'booking_id' => 'required|integer',
        'user_id' => 'required|integer',
        'amount' => 'required|decimal',
        'payment_method' => 'required|in_list[bank_transfer,e_wallet,cash]',
        'payment_code' => 'required|is_unique[payments.payment_code]',
        'status' => 'in_list[pending,approved,failed,cancelled]',
    ];

    protected $validationMessages = [
        'booking_id' => [
            'required' => 'ID Booking harus diisi',
            'integer' => 'ID Booking harus berupa angka',
        ],
        'user_id' => [
            'required' => 'ID User harus diisi',
            'integer' => 'ID User harus berupa angka',
        ],
        'amount' => [
            'required' => 'Jumlah pembayaran harus diisi',
            'decimal' => 'Jumlah pembayaran harus berupa angka desimal',
        ],
        'payment_method' => [
            'required' => 'Metode pembayaran harus dipilih',
            'in_list' => 'Metode pembayaran tidak valid',
        ],
        'payment_code' => [
            'required' => 'Kode pembayaran harus diisi',
            'is_unique' => 'Kode pembayaran sudah digunakan',
        ],
    ];

    /**
     * Get payment by payment code
     */
    public function getByPaymentCode($code)
    {
        return $this->where('payment_code', $code)->first();
    }

    /**
     * Get payment by booking ID
     */
    public function getByBookingId($bookingId)
    {
        return $this->where('booking_id', $bookingId)->first();
    }

    /**
     * Get all payments for a user
     */
    public function getUserPayments($userId)
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get pending payments
     */
    public function getPendingPayments()
    {
        return $this->where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get approved payments
     */
    public function getApprovedPayments()
    {
        return $this->where('status', 'approved')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Update payment status
     */
    public function updateStatus($paymentId, $status, $notes = null)
    {
        return $this->update($paymentId, [
            'status' => $status,
            'notes' => $notes,
        ]);
    }

    /**
     * Get payment statistics
     */
    public function getPaymentStats()
    {
        return $this->select('status, COUNT(*) as total, SUM(amount) as total_amount')
            ->groupBy('status')
            ->findAll();
    }
}
