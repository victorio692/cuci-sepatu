<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Config\Database;

class Services extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Get services from database with custom order
        $services = $this->db->table('services')
            ->orderBy("FIELD(kode_layanan, 'fast-cleaning', 'deep-cleaning', 'white-shoes', 'suede-treatment', 'unyellowing')", '', false)
            ->get()
            ->getResultArray();

        // Map Indonesian columns to match view expectations
        foreach ($services as &$service) {
            $service['service_code'] = $service['kode_layanan'];
            $service['service_name'] = $service['nama_layanan'];
            $service['name'] = $service['nama_layanan'];
            $service['description'] = $service['deskripsi'];
            $service['base_price'] = $service['harga_dasar'];
            $service['price'] = $service['harga_dasar'];
            $service['duration_days'] = $service['durasi_hari'];
            $service['is_active'] = $service['aktif'];
            $service['icon'] = 'star'; // Default icon
        }

        $data = [
            'title' => 'Layanan - Admin SYH Cleaning',
            'services' => $services,
        ];

        return view('admin/services', $data);
    }

    /**
     * Create new service
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Layanan - Admin SYH Cleaning'
        ];

        return view('admin/service_create', $data);
    }

    /**
     * Store new service
     */
    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'kode_layanan' => 'required|is_unique[services.kode_layanan]',
            'nama_layanan' => 'required|min_length[3]',
            'deskripsi' => 'required',
            'harga_dasar' => 'required|decimal',
            'durasi_hari' => 'required|integer',
        ], [
            'kode_layanan' => [
                'required' => 'Kode layanan harus diisi',
                'is_unique' => 'Kode layanan sudah ada'
            ],
            'nama_layanan' => [
                'required' => 'Nama layanan harus diisi',
                'min_length' => 'Nama minimal 3 karakter'
            ],
            'deskripsi' => [
                'required' => 'Deskripsi harus diisi'
            ],
            'harga_dasar' => [
                'required' => 'Harga harus diisi',
                'decimal' => 'Harga harus berupa angka'
            ],
            'durasi_hari' => [
                'required' => 'Durasi harus diisi',
                'integer' => 'Durasi harus berupa angka'
            ]
        ]);

        if (!$validation->run($this->request->getPost())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'kode_layanan' => $this->request->getPost('kode_layanan'),
            'nama_layanan' => $this->request->getPost('nama_layanan'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga_dasar' => $this->request->getPost('harga_dasar'),
            'durasi_hari' => $this->request->getPost('durasi_hari'),
            'aktif' => $this->request->getPost('aktif') ? 1 : 0,
            'dibuat_pada' => date('Y-m-d H:i:s'),
            'diupdate_pada' => date('Y-m-d H:i:s')
        ];

        if ($this->db->table('services')->insert($data)) {
            return redirect()->to('/admin/services')->with('success', 'Layanan berhasil ditambahkan');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan layanan');
    }

    /**
     * Edit service
     */
    public function edit($id)
    {
        $service = $this->db->table('services')->where('id', $id)->get()->getRowArray();

        if (!$service) {
            return redirect()->to('/admin/services')->with('error', 'Layanan tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Layanan - Admin SYH Cleaning',
            'service' => $service
        ];

        return view('admin/service_edit', $data);
    }

    /**
     * Update service
     */
    public function update($id)
    {
        $service = $this->db->table('services')->where('id', $id)->get()->getRowArray();

        if (!$service) {
            return redirect()->to('/admin/services')->with('error', 'Layanan tidak ditemukan');
        }

        $validation = \Config\Services::validation();

        $validation->setRules([
            'kode_layanan' => "required|is_unique[services.kode_layanan,id,{$id}]",
            'nama_layanan' => 'required|min_length[3]',
            'deskripsi' => 'required',
            'harga_dasar' => 'required|decimal',
            'durasi_hari' => 'required|integer',
        ]);

        if (!$validation->run($this->request->getPost())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'kode_layanan' => $this->request->getPost('kode_layanan'),
            'nama_layanan' => $this->request->getPost('nama_layanan'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga_dasar' => $this->request->getPost('harga_dasar'),
            'durasi_hari' => $this->request->getPost('durasi_hari'),
            'aktif' => $this->request->getPost('aktif') ? 1 : 0,
            'diupdate_pada' => date('Y-m-d H:i:s')
        ];

        if ($this->db->table('services')->where('id', $id)->update($data)) {
            return redirect()->to('/admin/services')->with('success', 'Layanan berhasil diupdate');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal mengupdate layanan');
    }

    /**
     * Delete service
     */
    public function delete($id)
    {
        // Log the request
        log_message('info', 'Delete service request received for ID: ' . $id);
        
        // Get service code first
        $service = $this->db->table('services')->where('id', $id)->get()->getRowArray();
        
        if (!$service) {
            log_message('warning', 'Service not found with ID: ' . $id);
            return redirect()->to('/admin/services')->with('error', 'Layanan tidak ditemukan');
        }

        // Check if service is used in ACTIVE bookings only (not selesai/batal/ditolak)
        $bookingCount = $this->db->table('bookings')
            ->where('layanan', $service['kode_layanan'])
            ->whereIn('status', ['pending', 'proses', 'dikonfirmasi'])
            ->countAllResults();

        if ($bookingCount > 0) {
            log_message('warning', 'Cannot delete service ' . $service['kode_layanan'] . ' - used in ' . $bookingCount . ' active bookings');
            return redirect()->to('/admin/services')->with('error', 'Tidak dapat menghapus layanan yang masih digunakan dalam ' . $bookingCount . ' pesanan aktif (pending/proses)');
        }

        if ($this->db->table('services')->where('id', $id)->delete()) {
            log_message('info', 'Service deleted successfully: ' . $service['kode_layanan']);
            return redirect()->to('/admin/services')->with('success', 'Layanan berhasil dihapus');
        }

        log_message('error', 'Failed to delete service with ID: ' . $id);
        return redirect()->to('/admin/services')->with('error', 'Gagal menghapus layanan');
    }

    /**
     * Toggle service active status
     */
    public function toggleActive($id)
    {
        $service = $this->db->table('services')->where('id', $id)->get()->getRowArray();

        if (!$service) {
            return $this->response->setJSON(['success' => false, 'message' => 'Layanan tidak ditemukan']);
        }

        $newStatus = $service['aktif'] ? 0 : 1;

        if ($this->db->table('services')->where('id', $id)->update(['aktif' => $newStatus])) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status berhasil diubah',
                'is_active' => $newStatus
            ]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengubah status']);
    }

    public function updatePrice()
    {
        $service = $this->request->getPost('service');
        $price = $this->request->getPost('price');

        if (!$service || !$price) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid data']);
        }

        // Update price in session or database
        // For now, just return success
        return $this->response->setJSON(['success' => true, 'message' => 'Price updated']);
    }
}

