<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Fix untuk Vercel: redirect storage ke /tmp yang writable
$storagePath = '/tmp/storage';
$folders = [
    $storagePath . '/app/public',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
];
foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }
}

$_ENV['APP_STORAGE'] = $storagePath;
putenv("APP_STORAGE=$storagePath");

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->useStoragePath($storagePath);

$app->handleRequest(Request::capture());