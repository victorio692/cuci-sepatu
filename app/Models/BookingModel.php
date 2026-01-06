<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table            = 'booking';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kode_booking',
        'user_id',
        'layanan_id',
        'jumlah_sepatu',
        'tanggal_booking',
        'status',
        'catatan',
        'total_harga',
        'tanggal_selesai'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id'         => 'required|integer',
        'layanan_id'      => 'required|integer',
        'jumlah_sepatu'   => 'required|integer|greater_than[0]',
        'tanggal_booking' => 'required|valid_date',
        'status'          => 'required|in_list[menunggu,diterima,diproses,selesai,dibatalkan]',
    ];

    protected $validationMessages = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $beforeInsert = ['generateKodeBooking'];

    /**
     * Generate kode booking otomatis
     */
    protected function generateKodeBooking(array $data)
    {
        if (!isset($data['data']['kode_booking'])) {
            $data['data']['kode_booking'] = 'BK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        }
        return $data;
    }

    /**
     * Get booking dengan join user dan layanan
     */
    public function getWithDetails($id = null)
    {
        $builder = $this->db->table($this->table)
            ->select('booking.*, users.nama as nama_pelanggan, users.email, users.telepon, layanan.nama_layanan, layanan.harga')
            ->join('users', 'users.id = booking.user_id')
            ->join('layanan', 'layanan.id = booking.layanan_id')
            ->orderBy('booking.created_at', 'DESC');

        if ($id) {
            return $builder->where('booking.id', $id)->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Get booking by user
     */
    public function getByUser($userId)
    {
        return $this->db->table($this->table)
            ->select('booking.*, layanan.nama_layanan, layanan.harga')
            ->join('layanan', 'layanan.id = booking.layanan_id')
            ->where('booking.user_id', $userId)
            ->orderBy('booking.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get booking by status
     */
    public function getByStatus($status)
    {
        return $this->getWithDetails()
            ->where('booking.status', $status)
            ->get()
            ->getResultArray();
    }

    /**
     * Update status booking
     */
    public function updateStatus($id, $status)
    {
        $data = ['status' => $status];
        
        // Jika status selesai, set tanggal selesai
        if ($status === 'selesai') {
            $data['tanggal_selesai'] = date('Y-m-d');
        }
        
        return $this->update($id, $data);
    }

    /**
     * Get statistik booking
     */
    public function getStatistik()
    {
        return [
            'total'      => $this->countAll(),
            'menunggu'   => $this->where('status', 'menunggu')->countAllResults(),
            'diterima'   => $this->where('status', 'diterima')->countAllResults(),
            'diproses'   => $this->where('status', 'diproses')->countAllResults(),
            'selesai'    => $this->where('status', 'selesai')->countAllResults(),
            'dibatalkan' => $this->where('status', 'dibatalkan')->countAllResults(),
        ];
    }
}
