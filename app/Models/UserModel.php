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
        'full_name',
        'email',
        'phone',
        'password_hash',
        'address',
        'city',
        'province',
        'zip_code',
        'is_active',
        'is_admin',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

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
        return $this->where('is_active', 1)->findAll();
    }

    /**
     * Get admin users
     */
    public function getAdminUsers()
    {
        return $this->where('is_admin', 1)->findAll();
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

        $newStatus = !$user['is_active'];
        
        return $this->update($userId, [
            'is_active' => $newStatus,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Search users
     */
    public function searchUsers($keyword)
    {
        return $this->like('full_name', $keyword)
                    ->orLike('email', $keyword)
                    ->orLike('phone', $keyword)
                    ->findAll();
    }

    /**
     * Get users with booking count
     */
    public function getUsersWithBookingCount()
    {
        return $this->select('users.*, COUNT(bookings.id) as total_booking')
                    ->join('bookings', 'bookings.user_id = users.id', 'left')
                    ->groupBy('users.id')
                    ->orderBy('users.created_at', 'DESC')
                    ->findAll();
    }
}
