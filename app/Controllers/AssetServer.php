<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class AssetServer extends BaseController
{
    /**
     * Menyajikan gambar dari folder writable/uploads sebagai fallback 
     * Digunakan untuk menangani gambarlama yang tersimpan di writable
     */
    public function serveServiceIcon($filename = null): ResponseInterface
    {
        if (!$filename) {
            return $this->response->setStatusCode(404, 'Not Found');
        }

        // Keamanan: hanya izinkan karakter tertentu pada nama file (mencegah directory traversal)
        if (!preg_match('/^[a-z0-9_\-\.]+\.(?:jpg|jpeg|png|gif|webp)$/i', $filename)) {
            log_message('warning', 'Invalid filename request: ' . $filename);
            return $this->response->setStatusCode(400, 'Bad Request');
        }

        // pertama cek di folder public (lokasi upload baru)
        $publicPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'services' . DIRECTORY_SEPARATOR . $filename;
        if (file_exists($publicPath) && is_file($publicPath)) {
            return $this->serveFile($publicPath);
        }

        // Jika tidak ada, cek di folder writable (lokasi upload lama)
        $writablePath = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'services' . DIRECTORY_SEPARATOR . $filename;
        if (file_exists($writablePath) && is_file($writablePath)) {
            log_message('info', 'Serving legacy image from writable: ' . $filename);
            return $this->serveFile($writablePath);
        }

        // File tidak ditemukan di kedua lokasi
        log_message('warning', 'Service icon not found: ' . $filename);
        return $this->response->setStatusCode(404, 'Not Found');
    }

    /**
     * Method helper untuk mengirim file dengan header yang sesuai
     */
    private function serveFile($filepath): ResponseInterface
    {
        if (!file_exists($filepath) || !is_file($filepath)) {
            return $this->response->setStatusCode(404, 'Not Found');
        }

        $filename = basename($filepath);
        $mimeType = $this->getMimeType($filename);
        
        // Set headeryang sesuai untuk caching browser
        $lastModified = filemtime($filepath);
        $eTag = md5($filepath . $lastModified);
        
        // Cek apakah file belum diubah sejak terakhir  diterima oleh client
        if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] === $eTag) {
            return $this->response->setStatusCode(304, 'Not Modified');
        }

        // Baca dan kirim file
        $fileContent = file_get_contents($filepath);
        
        return $this->response
            ->setStatusCode(200)
            ->setHeader('Content-Type', $mimeType)
            ->setHeader('Content-Length', filesize($filepath))
            ->setHeader('Cache-Control', 'public, max-age=86400') // Cache selama 1 hari
            ->setHeader('ETag', $eTag)
            ->setHeader('Last-Modified', gmdate('D, d M Y H:i:s', $lastModified) . ' GMT')
            ->setBody($fileContent);
    }

    /**
     * Mengambil MIME type berdasarkan ekstensi file
     */
    private function getMimeType($filename): string
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        $mimeTypes = [
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'webp' => 'image/webp',
        ];
        
        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }
}
