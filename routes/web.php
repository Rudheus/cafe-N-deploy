<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Hello from Laravel on Vercel!';
});

Route::get('/debug', function () {
    return response()->json([
        'php_version' => PHP_VERSION,
        'laravel_version' => app()->version(),
        'storage_path' => storage_path(),
        'storage_writable' => is_writable(storage_path()),
        'env' => app()->environment(),
        'db_connection' => config('database.default'),
    ]);
});
