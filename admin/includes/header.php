<?php
declare(strict_types=1);
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/services.php';
// Deteksi HTTPS yang aman untuk Railway/Reverse Proxy
$is_https = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
if (!$is_https && !in_array($host, ['localhost', '127.0.0.1']) && strpos($host, '.test') === false) {
    header('Location: https://' . $host . $_SERVER['REQUEST_URI']);
    exit();
}

$basePath = '/admin';
$publicPath = '';
if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/kominfov2') === 0) {
    $basePath = '/kominfov2/admin';
    $publicPath = '/kominfov2';
}

$activePage = $activePage ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle ?? 'Admin Dashboard') ?></title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        :root {
            --primary: #800000; /* Maroon */
            --primary-light: #990000;
            --sidebar-width: 260px;
        }
        body, h1, h2, h3, h4, h5, h6, p, span, div, table, th, td, button, input, select, textarea {
            font-family: 'Inter', sans-serif !important;
        }
        body {
            background-color: #f4f6f9;
        }
        .bg-primary-maroon {
            background-color: var(--primary) !important;
            color: #ffffff !important;
        }
        /* Sidebar Modern UI */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #1e1e2f 0%, #151521 100%);
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            color: #ffffff;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-brand img {
            width: 45px;
            height: 45px;
            object-fit: contain;
            background: #fff;
            border-radius: 8px;
            padding: 4px;
        }
        .sidebar-brand span {
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            line-height: 1.2;
            text-align: left;
        }
        .sidebar-menu {
            padding: 1.5rem 1rem;
            flex-grow: 1;
            overflow-y: auto;
        }
        .sidebar-item {
            padding: 0.85rem 1.25rem;
            color: #a1a5b7;
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            font-weight: 500;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            transition: all 0.25s ease;
        }
        .sidebar-item:hover {
            color: #ffffff;
            background-color: rgba(255,255,255,0.05);
            transform: translateX(3px);
        }
        .sidebar-item.active {
            color: #ffffff;
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 100%);
            box-shadow: 0 4px 10px rgba(128, 0, 0, 0.3);
        }
        .sidebar-item i {
            font-size: 1.25rem;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
            transition: all 0.3s;
        }
        .topbar {
            background: #fff;
            padding: 1rem 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-stat {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: transform 0.2s;
        }
        .card-stat:hover {
            transform: translateY(-5px);
        }
        .text-maroon {
            color: var(--primary);
        }
        .bg-maroon {
            background-color: var(--primary);
            color: white;
        }
        
        /* Mobile Responsiveness */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            backdrop-filter: blur(2px);
        }
        .btn-hamburger {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #333;
            cursor: pointer;
        }
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            .btn-hamburger {
                display: block;
            }
            .sidebar-backdrop.show {
                display: block;
            }
            .topbar {
                padding: 0.75rem 1rem;
                border-radius: 8px;
            }
        }
    </style>
</head>
<body>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <img src="<?= $publicPath ?>/includes/image/kominfo.jpg" alt="Logo">
        <span>Admin<br><small class="fw-normal" style="font-size:0.8rem; color:#a1a5b7;">Diskominfo Bogor</small></span>
    </div>
    <div class="sidebar-menu">
        <a href="<?= $basePath ?>/index.php" class="sidebar-item <?= $activePage === 'dashboard' ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>
        <a href="<?= $basePath ?>/pengaduan.php" class="sidebar-item <?= $activePage === 'pengaduan' ? 'active' : '' ?>">
            <i class="bi bi-megaphone-fill"></i> Pengaduan Warga
        </a>
        <a href="<?= $basePath ?>/komentar.php" class="sidebar-item <?= $activePage === 'komentar' ? 'active' : '' ?>">
            <i class="bi bi-chat-dots-fill"></i> Komentar Warga
        </a>
        <a href="<?= $basePath ?>/cctv.php" class="sidebar-item <?= $activePage === 'cctv' ? 'active' : '' ?>">
            <i class="bi bi-camera-video-fill"></i> Kelola CCTV
        </a>
        <a href="<?= $basePath ?>/berita.php" class="sidebar-item <?= $activePage === 'berita' ? 'active' : '' ?>">
            <i class="bi bi-newspaper"></i> Kelola Berita
        </a>
        <a href="<?= $basePath ?>/profil.php" class="sidebar-item <?= $activePage === 'profil' ? 'active' : '' ?>">
            <i class="bi bi-person-vcard"></i> Profil Dinas
        </a>
        <a href="<?= $publicPath ?>/user/index.php" class="sidebar-item" target="_blank" style="margin-top:2rem;">
            <i class="bi bi-box-arrow-up-right"></i> Lihat Website
        </a>
    </div>
</div>

<div class="main-content">
    <div class="topbar">
        <div class="d-flex align-items-center gap-2">
            <button class="btn-hamburger" id="btnHamburger">
                <i class="bi bi-list"></i>
            </button>
            <h4 class="m-0 fw-bold text-dark d-none d-sm-block"><?= esc($pageTitle ?? 'Dashboard') ?></h4>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted"><i class="bi bi-person-circle fs-4"></i></span>
            <span class="fw-semibold d-none d-sm-inline">Admin Diskominfo</span>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btnHamburger = document.getElementById('btnHamburger');
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');

            if(btnHamburger) {
                btnHamburger.addEventListener('click', () => {
                    sidebar.classList.toggle('show');
                    backdrop.classList.toggle('show');
                });
            }
            if(backdrop) {
                backdrop.addEventListener('click', () => {
                    sidebar.classList.remove('show');
                    backdrop.classList.remove('show');
                });
            }
        });
    </script>
