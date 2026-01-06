<?php

namespace App\Models;

use CodeIgniter\Model;

class LayananModel extends Model
{
    protected $table            = 'layanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_layanan',
        'deskripsi',
        'harga',
        'durasi',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama_layanan' => 'required|min_length[3]|max_length[100]',
        'harga'        => 'required|numeric',
        'status'       => 'required|in_list[aktif,nonaktif]',
    ];

    protected $validationMessages = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Get layanan yang aktif saja
     */
    public function getAktif()
    {
        return $this->where('status', 'aktif')->findAll();
    }

    /**
     * Get layanan dengan format rupiah
     */
    public function getWithFormattedPrice()
    {
        $layanan = $this->findAll();
        
        foreach ($layanan as &$item) {
            $item['harga_format'] = 'Rp ' . number_format($item['harga'], 0, ',', '.');
        }
        
        return $layanan;
    }
}
