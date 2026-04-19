<?php

// Bersihkan cache environment lama agar tidak bentrok
putenv('DB_CONNECTION=pgsql');

$tmpStorage = '/tmp/storage';
$directories = [
    $tmpStorage . '/framework/views',
    $tmpStorage . '/framework/cache/data',
    $tmpStorage . '/framework/sessions',
    $tmpStorage . '/logs',
    $tmpStorage . '/bootstrap/cache'
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Pastikan Laravel tahu kita pakai SSL untuk Neon
$_ENV['DB_SSLMODE'] = 'require';
putenv('DB_SSLMODE=require');

require __DIR__ . '/../public/index.php';