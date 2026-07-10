<?php
declare(strict_types=1);

$basePath = '';
if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/kominfov2') === 0) {
    $basePath = '/kominfov2';
}

// Perbaikan untuk Railway (PHP Built-in Server)
// Jika request adalah file yang benar-benar ada (seperti /user/share-location.php), serve file tersebut!
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$filePath = __DIR__ . $requestPath;
// Hilangkan prefix /kominfov2 jika ada di file path (saat berjalan di Railway)
if (strpos($requestPath, '/kominfov2') === 0) {
    $filePath = __DIR__ . substr($requestPath, 10);
}

if (php_sapi_name() === 'cli-server') {
    if (file_exists($filePath) && !is_dir($filePath) && $requestPath !== '/' && $requestPath !== '/index.php') {
        return false; // Biarkan PHP built-in server melayani file ini
    }
}

// Jika tidak, baru arahkan ke home (user/index.php)
if ($requestPath === '/' || $requestPath === '' || $requestPath === '/index.php' || $requestPath === '/kominfov2/' || $requestPath === '/kominfov2/index.php') {
    header('Location: ' . $basePath . '/user/index.php');
    exit;
}

// Fallback 404
http_response_code(404);
echo "404 Not Found";
exit;
