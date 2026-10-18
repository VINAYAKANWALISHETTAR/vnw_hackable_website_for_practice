<?php

// router.php for PHP built-in development server
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '');
$publicPath = __DIR__ . '/public';

// If requested static file exists in public directory, serve it directly
if ($uri !== '/' && file_exists($publicPath . $uri)) {
    return false;
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
require_once $publicPath . '/index.php';

