<?php
declare(strict_types=1);

$basePath = '';
if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/kominfov2') === 0) {
    $basePath = '/kominfov2';
}

// Jika ini adalah 404 fallback (misalnya user mengakses URL yang tidak ada)
// kita harus memastikan kita tidak melakukan loop.
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($requestPath !== '/' && $requestPath !== '' && $requestPath !== '/index.php' && $requestPath !== '/kominfov2/' && $requestPath !== '/kominfov2/index.php') {
    // Ini kemungkinan adalah request 404 yang di-fallback ke index.php
    // Jangan redirect, lebih baik tampilkan 404 atau redirect ke home dengan URL mutlak.
    header('Location: ' . $basePath . '/user/index.php');
    exit;
}

header('Location: ' . $basePath . '/user/index.php');
exit;
