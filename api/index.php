<?php

// 1. Tentukan lokasi folder sementara khusus Vercel
$tmpStorage = '/tmp/storage';

// 2. Daftar folder wajib yang dibutuhkan Laravel untuk bernapas
$directories = [
    $tmpStorage . '/framework/views',
    $tmpStorage . '/framework/cache/data',
    $tmpStorage . '/framework/sessions',
    $tmpStorage . '/logs',
    $tmpStorage . '/bootstrap/cache'
];

// 3. Buat folder-folder tersebut secara otomatis jika belum ada
foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// 4. Paksa Laravel menggunakan folder sementara ini
putenv('VIEW_COMPILED_PATH=' . $tmpStorage . '/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = $tmpStorage . '/framework/views';

// 5. Jalankan aplikasi utama Laravel
require __DIR__ . '/../public/index.php';