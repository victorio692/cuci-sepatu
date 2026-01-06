<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LayananModel;

class Services extends BaseController
{
    protected $layananModel;

    public function __construct()
    {
        $this->layananModel = new LayananModel();
    }

    /**
     * Halaman kelola layanan
     */
    public function index()
    {
        $data = [
            'title' => 'Kelola Layanan',
            'layanan' => $this->layananModel->findAll(),
        ];

        return view('admin/services', $data);
    }

    /**
     * Form tambah layanan
     */
    public function create()
    {
        $data = ['title' => 'Tambah Layanan'];
        return view('admin/service_form', $data);
    }

    /**
     * Simpan layanan baru
     */
    public function store()
    {
        $rules = [
            'nama_layanan' => 'required|min_length[3]',
            'harga'        => 'required|numeric',
            'status'       => 'required|in_list[aktif,nonaktif]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_layanan' => $this->request->getPost('nama_layanan'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'harga'        => $this->request->getPost('harga'),
            'durasi'       => $this->request->getPost('durasi'),
            'status'       => $this->request->getPost('status'),
        ];

        if ($this->layananModel->save($data)) {
            return redirect()->to('/admin/services')->with('success', 'Layanan berhasil ditambahkan');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan layanan');
    }

    /**
     * Form edit layanan
     */
    public function edit($id)
    {
        $layanan = $this->layananModel->find($id);
        
        if (!$layanan) {
            return redirect()->to('/admin/services')->with('error', 'Layanan tidak ditemukan');
        }

        $data = [
            'title'   => 'Edit Layanan',
            'layanan' => $layanan,
        ];

        return view('admin/service_form', $data);
    }

    /**
     * Update layanan
     */
    public function update($id)
    {
        $rules = [
            'nama_layanan' => 'required|min_length[3]',
            'harga'        => 'required|numeric',
            'status'       => 'required|in_list[aktif,nonaktif]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_layanan' => $this->request->getPost('nama_layanan'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'harga'        => $this->request->getPost('harga'),
            'durasi'       => $this->request->getPost('durasi'),
            'status'       => $this->request->getPost('status'),
        ];

        if ($this->layananModel->update($id, $data)) {
            return redirect()->to('/admin/services')->with('success', 'Layanan berhasil diupdate');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal mengupdate layanan');
    }

    /**
     * Hapus layanan
     */
    public function delete($id)
    {
        if ($this->layananModel->delete($id)) {
            return redirect()->to('/admin/services')->with('success', 'Layanan berhasil dihapus');
        }

        return redirect()->to('/admin/services')->with('error', 'Gagal menghapus layanan');
    }
}
