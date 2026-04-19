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

// Override env sebelum Laravel boot
$_ENV['APP_STORAGE'] = $storagePath;
putenv("APP_STORAGE=$storagePath");

require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel dengan storage path override
$app = require_once __DIR__.'/../bootstrap/app.php';

// Override storage path SETELAH app dibuat tapi SEBELUM request dihandle
$app->useStoragePath($storagePath);

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);