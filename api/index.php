<?php

// 1. Definisikan folder storage di folder /tmp yang writable
$storagePath = '/tmp/storage';

// 2. Buat struktur folder yang dibutuhkan Laravel
$folders = [
    $storagePath . '/framework/views',
    $storagePath . '/framework/cache',
    $storagePath . '/framework/sessions',
    $storagePath . '/bootstrap/cache',
];

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }
}

// 3. Set Environment Variables secara runtime agar Laravel tahu kemana harus menulis
putenv("APP_STORAGE=$storagePath");
putenv("VIEW_COMPILED_PATH=$storagePath/framework/views");
putenv("SESSION_DRIVER=file");

// 4. Load aplikasi
require __DIR__ . '/../public/index.php';