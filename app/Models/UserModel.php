<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    
    protected $allowedFields = [
        'nama_lengkap',
        'email',
        'no_hp',
        'password_hash',
        'foto_profil',
        'alamat',
        'role',
        'dibuat_pada',
        'diupdate_pada'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'dibuat_pada';
    protected $updatedField = 'diupdate_pada';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get user by email
     */
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Get active users
     */
    public function getActiveUsers()
    {
        return $this->where('aktif', 1)->findAll();
    }

    /**
     * Get admin users
     */
    public function getAdminUsers()
    {
        return $this->where('admin', 1)->findAll();
    }

    /**
     * Check if email exists
     */
    public function emailExists($email, $excludeId = null)
    {
        $builder = $this->where('email', $email);
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->countAllResults() > 0;
    }

    /**
     * Toggle user active status
     */
    public function toggleActive($userId)
    {
        $user = $this->find($userId);
        
        if (!$user) {
            return false;
        }

        $newStatus = !$user['aktif'];
        
        return $this->update($userId, [
            'aktif' => $newStatus,
            'diupdate_pada' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Search users
     */
    public function searchUsers($keyword)
    {
        return $this->like('nama_lengkap', $keyword)
                    ->orLike('email', $keyword)
                    ->orLike('no_hp', $keyword)
                    ->findAll();
    }

    /**
     * Get users with booking count
     */
    public function getUsersWithBookingCount()
    {
        return $this->select('users.*, COUNT(bookings.id) as total_booking')
                    ->join('bookings', 'bookings.id_user = users.id', 'left')
                    ->groupBy('users.id')
                    ->orderBy('users.dibuat_pada', 'DESC')
                    ->findAll();
    }
}
