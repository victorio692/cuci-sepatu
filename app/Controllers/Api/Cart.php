<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Cart extends ResourceController
{
    protected $format = 'json';
    public function index()
    {
        if (!session()->get('user_id')) {
            return $this->failUnauthorized('Unauthorized');
        }

        $cart = session()->get('cart') ?? [];

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $this->respond([
            'status' => 'success',
            'data'   => $cart,
            'total'  => $total
        ]);
    }

    public function add()
    {
        if (!session()->get('user_id')) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = $this->request->getJSON(true);

        if (!isset($data['name'], $data['price'], $data['quantity'])) {
            return $this->failValidationError('Data tidak lengkap');
        }

        $cart = session()->get('cart') ?? [];

        $cart[] = [
            'id'       => uniqid(),
            'name'     => $data['name'],
            'price'    => (int)$data['price'],
            'quantity' => (int)$data['quantity'],
            'added_at' => date('Y-m-d H:i:s')
        ];

        session()->set('cart', $cart);

        return $this->respondCreated([
            'status'  => 'success',
            'message' => 'Item ditambahkan ke cart'
        ]);
    }

    public function update($id = null)
    {
        if (!session()->get('user_id')) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = $this->request->getJSON(true);
        $cart = session()->get('cart') ?? [];

        foreach ($cart as &$item) {
            if ($item['id'] === $id) {
                $item['quantity'] = (int)$data['quantity'];
            }
        }

        session()->set('cart', $cart);

        return $this->respond([
            'status'  => 'success',
            'message' => 'Quantity updated'
        ]);
    }

    public function remove($id = null)
    {
        if (!session()->get('user_id')) {
            return $this->failUnauthorized('Unauthorized');
        }

        $cart = session()->get('cart') ?? [];

        $cart = array_filter($cart, function($item) use ($id) {
            return $item['id'] !== $id;
        });

        session()->set('cart', array_values($cart));

        return $this->respond([
            'status'  => 'success',
            'message' => 'Item dihapus'
        ]);
    }

    public function clear()
    {
        if (!session()->get('user_id')) {
            return $this->failUnauthorized('Unauthorized');
        }

        session()->remove('cart');

        return $this->respond([
            'status'  => 'success',
            'message' => 'Cart dikosongkan'
        ]);
    }
}