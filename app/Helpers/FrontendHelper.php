<?php

// Frontend Helper Functions

if (!function_exists('getStatusBadgeClass')) {
    function getStatusBadgeClass($status)
    {
        $classes = [
            'pending' => 'warning',
            'approved' => 'info',
            'in_progress' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
        ];
        return $classes[$status] ?? 'primary';
    }
}

if (!function_exists('getStatusLabel')) {
    function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'in_progress' => 'Sedang Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
        return $labels[$status] ?? ucfirst($status);
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}

if (!function_exists('getServiceName')) {
    function getServiceName($service)
    {
        $services = [
            'fast-cleaning' => 'Fast Cleaning',
            'deep-cleaning' => 'Deep Cleaning',
            'white-shoes' => 'White Shoes',
            'coating' => 'Coating',
            'dyeing' => 'Dyeing',
            'repair' => 'Repair',
        ];
        return $services[$service] ?? ucfirst(str_replace('-', ' ', $service));
    }
}

if (!function_exists('getServicePrice')) {
    function getServicePrice($service)
    {
        $prices = [
            'fast-cleaning' => 15000,
            'deep-cleaning' => 20000,
            'white-shoes' => 35000,
            'coating' => 25000,
            'dyeing' => 40000,
            'repair' => 50000,
        ];
        return $prices[$service] ?? 0;
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        if (is_string($date)) {
            $date = strtotime($date);
        }
        return strftime('%d %B %Y', $date);
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime($date)
    {
        if (is_string($date)) {
            $date = strtotime($date);
        }
        return strftime('%d %B %Y %H:%M', $date);
    }
}

if (!function_exists('timeAgo')) {
    function timeAgo($date)
    {
        if (is_string($date)) {
            $date = strtotime($date);
        }
        
        $time = time() - $date;
        
        if ($time < 60) {
            return 'Baru saja';
        } elseif ($time < 3600) {
            $minutes = floor($time / 60);
            return $minutes . ' menit lalu';
        } elseif ($time < 86400) {
            $hours = floor($time / 3600);
            return $hours . ' jam lalu';
        } elseif ($time < 604800) {
            $days = floor($time / 86400);
            return $days . ' hari lalu';
        } else {
            return formatDate($date);
        }
    }
}
