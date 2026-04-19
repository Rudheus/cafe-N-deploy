<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Illuminate\Http\Request;
define('LARAVEL_START', microtime(true));
// ... sisanya tetap sama
require __DIR__ . '/../public/index.php';