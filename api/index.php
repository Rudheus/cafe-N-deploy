<?php
// 1. TRIK RAHASIA: Paksa Laravel memuntahkan error dalam bentuk teks JSON
// Ini akan mencegah Laravel memanggil sistem View yang bermasalah di Vercel
$_SERVER['HTTP_ACCEPT'] = 'application/json';

// 2. Siapkan folder memori sementara
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

// 3. Timpa pengaturan krusial secara paksa langsung dari dalam kode
putenv('VIEW_COMPILED_PATH=' . $tmpStorage . '/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = $tmpStorage . '/framework/views';

putenv('LOG_CHANNEL=stderr');
$_ENV['LOG_CHANNEL'] = 'stderr';

// Matikan sementara session database agar tidak membebani koneksi awal
putenv('SESSION_DRIVER=array'); 
$_ENV['SESSION_DRIVER'] = 'array';

// 4. Nyalakan mesin Laravel
require __DIR__ . '/../public/index.php';