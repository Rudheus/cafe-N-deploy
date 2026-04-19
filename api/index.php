<?php

// 1. Arahkan semua folder cache dan session ke folder /tmp yang bisa ditulis oleh Vercel
$storagePath = '/tmp/storage';
$directories = [
    $storagePath . '/framework/views',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/bootstrap/cache',
    $storagePath . '/logs',
];

foreach ($directories as $directory) {
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
}

// 2. Paksa Laravel menggunakan path baru ini
putenv("VIEW_COMPILED_PATH=$storagePath/framework/views");
putenv("SESSION_DRIVER=file");
putenv("SESSION_PATH=$storagePath/framework/sessions");
putenv("APP_CONFIG_CACHE=$storagePath/bootstrap/cache/config.php");
putenv("APP_ROUTES_CACHE=$storagePath/bootstrap/cache/routes.php");

// 3. Panggil file asli Laravel
require __DIR__ . '/../public/index.php';