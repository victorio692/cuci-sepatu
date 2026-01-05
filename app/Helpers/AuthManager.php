<?php

namespace App\Helpers;

use CodeIgniter\Session\Session;

class AuthManager
{
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->session = session();
        $this->db = db_connect();
    }

    /**
     * Check if user is logged in
     */
    public function loggedIn()
    {
        return $this->session->has('user_id');
    }

    /**
     * Get current logged in user
     */
    public function user()
    {
        if (!$this->loggedIn()) {
            return null;
        }

        $user_id = $this->session->get('user_id');
        $user = $this->db->table('users')->find($user_id);
        
        return $user ? (object)$user : null;
    }

    /**
     * Login user
     */
    public function login($user_id)
    {
        $this->session->set('user_id', $user_id);
        return true;
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $this->session->destroy();
        return true;
    }
}
