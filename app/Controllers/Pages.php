<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function about()
    {
        return view('pages/about', ['title' => 'Tentang Kami - SYH Cleaning']);
    }

    public function contact()
    {
        return view('pages/contact', ['title' => 'Hubungi Kami - SYH Cleaning']);
    }

    public function submitContact()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'subject' => 'required|min_length[5]',
            'message' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid');
        }

        // Kirim email atau simpan ke database
        // TODO: Implementasi pengiriman email

        return redirect()->back()->with('contact_success', 'Pesan Anda telah dikirim. Kami akan segera menghubungi Anda!');
    }

    public function privacy()
    {
        return view('pages/privacy', ['title' => 'Kebijakan Privasi - SYH Cleaning']);
    }

    public function terms()
    {
        return view('pages/terms', ['title' => 'Syarat & Ketentuan - SYH Cleaning']);
    }

    public function faq()
    {
        return view('pages/faq', ['title' => 'FAQ - SYH Cleaning']);
    }
}
