<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        $session = session();
        
        if (!$session->has('user_id')) {
            return redirect()->to('/login');
        }

        // If 'admin' argument is passed, check if user is admin
        if (in_array('admin', $arguments ?? [])) {
            $db = Database::connect();
            $user = $db->table('users')->find($session->get('user_id'));
            
            if (!$user || !$user['is_admin']) {
                return redirect()->to('/dashboard')->with('error', 'Access denied');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
