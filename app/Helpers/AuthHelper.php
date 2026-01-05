<?php

if (!function_exists('auth')) {
    function auth() {
        return new \App\Helpers\AuthManager();
    }
}

if (!function_exists('db_connect')) {
    function db_connect() {
        $db = \Config\Database::connect();
        return $db;
    }
}
