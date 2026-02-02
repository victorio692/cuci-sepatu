<?php

if (!function_exists('getStatusLabel')) {
    function getStatusLabel($status) {
        $labels = [
            'pending' => 'Pending',
            'selesai' => 'Selesai',
            'batal' => 'Dibatalkan',
            'approved' => 'Disetujui',
            'in_progress' => 'Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
        
        return $labels[$status] ?? ucfirst($status);
    }
}

if (!function_exists('getStatusBadgeClass')) {
    function getStatusBadgeClass($status) {
        $classes = [
            'pending' => 'warning',
            'selesai' => 'success',
            'batal' => 'danger',
            'approved' => 'info',
            'in_progress' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
        ];
        
        return $classes[$status] ?? 'secondary';
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($amount) {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'd M Y') {
        return date($format, strtotime($date));
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime($date) {
        return date('d M Y H:i', strtotime($date));
    }
}
