<?php

// 1. Buat folder memori sementara
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

// 2. Alihkan SEMUA jalur penulisan Laravel ke memori /tmp
$_ENV['VIEW_COMPILED_PATH'] = $tmpStorage . '/framework/views';
$_ENV['SESSION_DRIVER'] = 'array';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['APP_SERVICES_CACHE'] = $tmpStorage . '/bootstrap/cache/services.php';
$_ENV['APP_PACKAGES_CACHE'] = $tmpStorage . '/bootstrap/cache/packages.php';
$_ENV['APP_CONFIG_CACHE'] = $tmpStorage . '/bootstrap/cache/config.php';
$_ENV['APP_ROUTES_CACHE'] = $tmpStorage . '/bootstrap/cache/routes.php';
$_ENV['APP_EVENTS_CACHE'] = $tmpStorage . '/bootstrap/cache/events.php';

foreach ($_ENV as $key => $value) {
    putenv("$key=$value");
}

// 3. Jaring Pengaman Super: Jalankan Laravel dan tangkap error aslinya
try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    // Jika masih crash, cetak error aslinya ke layar sebagai teks biasa!
    header('Content-Type: text/plain');
    echo "=== ERROR ASLI DITEMUKAN (Bypass Laravel) ===\n\n";
    echo "Pesan  : " . $e->getMessage() . "\n";
    echo "File   : " . $e->getFile() . "\n";
    echo "Baris  : " . $e->getLine() . "\n\n";
    echo "Stack Trace:\n" . $e->getTraceAsString();
}