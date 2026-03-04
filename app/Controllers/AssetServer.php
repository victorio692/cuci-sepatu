<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class AssetServer extends BaseController
{
    /**
     * Serve images from writable/uploads directory as fallback
     * This handles legacy images that were uploaded to writable/ instead of public/
     */
    public function serveServiceIcon($filename = null): ResponseInterface
    {
        if (!$filename) {
            return $this->response->setStatusCode(404, 'Not Found');
        }

        // Security: Only allow specific characters in filename (prevent directory traversal)
        if (!preg_match('/^[a-z0-9_\-\.]+\.(?:jpg|jpeg|png|gif|webp)$/i', $filename)) {
            log_message('warning', 'Invalid filename request: ' . $filename);
            return $this->response->setStatusCode(400, 'Bad Request');
        }

        // First try public folder (new uploads location)
        $publicPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'services' . DIRECTORY_SEPARATOR . $filename;
        if (file_exists($publicPath) && is_file($publicPath)) {
            return $this->serveFile($publicPath);
        }

        // Then try writable folder (legacy uploads location)
        $writablePath = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'services' . DIRECTORY_SEPARATOR . $filename;
        if (file_exists($writablePath) && is_file($writablePath)) {
            log_message('info', 'Serving legacy image from writable: ' . $filename);
            return $this->serveFile($writablePath);
        }

        // Not found in either location
        log_message('warning', 'Service icon not found: ' . $filename);
        return $this->response->setStatusCode(404, 'Not Found');
    }

    /**
     * Helper method to serve a file with proper headers
     */
    private function serveFile($filepath): ResponseInterface
    {
        if (!file_exists($filepath) || !is_file($filepath)) {
            return $this->response->setStatusCode(404, 'Not Found');
        }

        $filename = basename($filepath);
        $mimeType = $this->getMimeType($filename);
        
        // Set appropriate headers for browser caching
        $lastModified = filemtime($filepath);
        $eTag = md5($filepath . $lastModified);
        
        // Check if file hasn't been modified since client last received it
        if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] === $eTag) {
            return $this->response->setStatusCode(304, 'Not Modified');
        }

        // Read and send file
        $fileContent = file_get_contents($filepath);
        
        return $this->response
            ->setStatusCode(200)
            ->setHeader('Content-Type', $mimeType)
            ->setHeader('Content-Length', filesize($filepath))
            ->setHeader('Cache-Control', 'public, max-age=86400') // Cache for 1 day
            ->setHeader('ETag', $eTag)
            ->setHeader('Last-Modified', gmdate('D, d M Y H:i:s', $lastModified) . ' GMT')
            ->setBody($fileContent);
    }

    /**
     * Get MIME type based on file extension
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
