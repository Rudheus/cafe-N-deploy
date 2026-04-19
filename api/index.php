<?php

// 1. Buat folder temporary yang writable oleh Vercel
$storagePath = '/tmp/storage';
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

// 2. Paksa Laravel menggunakan folder /tmp untuk compiled views
putenv("VIEW_COMPILED_PATH=$storagePath/framework/views");
// Paksa agar bootstrap cache juga lari ke /tmp
putenv("APP_STORAGE=$storagePath");

require __DIR__ . '/../public/index.php';