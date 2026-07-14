<?php
declare(strict_types=1);

// Tampilkan error agar tidak muncul blank screen jika ada fatal error
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once __DIR__ . '/services.php';

$pageTitle    = $pageTitle    ?? 'Diskominfo Kota Bogor';
$activePage   = $activePage   ?? 'home';
$isTransparentNav = $isTransparentNav ?? false;

// Deteksi HTTPS yang aman untuk Railway/Reverse Proxy
$is_https = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
if (!$is_https && !in_array($host, ['localhost', '127.0.0.1']) && strpos($host, '.test') === false) {
    header('Location: https://' . $host . $_SERVER['REQUEST_URI']);
    exit();
}

// Deteksi otomatis base path (Laragon vs Railway/Production)
$basePath = '';
if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/kominfov2') === 0) {
    $basePath = '/kominfov2';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($pageTitle) ?> — Diskominfo Kota Bogor</title>
  <meta name="description" content="Dinas Komunikasi dan Informatika Kota Bogor — Portal layanan digital, informasi publik, dan pengaduan masyarakat.">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <link rel="stylesheet" href="<?= $basePath ?>/assets/css/app.css?v=<?= time() ?>">
  
  <style>
    /* Global Responsive Fix untuk mencegah geser kanan-kiri di mobile */
    html, body {
      overflow-x: hidden !important;
      max-width: 100vw !important;
      position: relative;
    }

    /* Bootstrap Navbar Customization */
    .navbar-nav .nav-link { transition: all 0.3s ease; margin: 0 0.1rem; }
    .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active { background-color: #eff6ff !important; color: #2563eb !important; }
    
    .dropdown-menu { border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border-radius: 12px; }
    
    .dropdown-item { transition: all 0.2s ease; margin: 2px 8px; width: auto; font-weight: 500; border-radius: 6px; }
    .dropdown-item:hover, .dropdown-item.active { background-color: #eff6ff !important; color: #2563eb !important; }
    
    /* Dropdown Animation (works with Bootstrap native JS click) */
    .dropdown-menu.show { animation: fadeIn 0.2s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }

    /* Override mobile navbar background from app.css */
    @media (max-width: 991px) {
      .navbar-collapse {
        background: #ffffff;
        overflow-y: auto;
      }
      .nav-menu.is-open .nav-item { width: 100%; }
      .nav-menu.is-open .nav-link { font-size: 1.1rem; padding: 0.8rem 1rem; width: 100%; border-radius: 8px; display: flex; justify-content: space-between; }
      
      /* Dropdown di dalam menu mobile */
      .nav-menu .dropdown-menu { 
        position: static !important; 
        box-shadow: none !important; 
        padding: 0; 
        margin-top: 0.5rem;
        margin-left: 1rem; 
        border: none;
        border-left: 2px solid #e2e8f0; 
        border-radius: 0; 
        background: transparent; 
      }
      .nav-menu .dropdown-item { padding: 0.5rem 1rem; }
      
      .nav-hamburger { display: flex !important; }
      .nav-ai-btn { display: none !important; }
    }
  </style>
  <?php if($isTransparentNav): ?>
  <script>
    window.addEventListener('scroll', function() {
      const nav = document.getElementById('siteNav');
      const brandText = document.querySelector('.brand-text');
      const brandSub = document.querySelector('.brand-subtext');
      if (window.scrollY > 50) {
        nav.style.background = 'rgba(255,255,255,0.95)';
        nav.style.backdropFilter = 'blur(14px)';
        nav.style.boxShadow = '0 .125rem .25rem rgba(0,0,0,.075)';
      } else {
        nav.style.background = 'transparent';
        nav.style.backdropFilter = 'none';
        nav.style.boxShadow = 'none';
      }
    });
  </script>
  <?php endif; ?>
</head>
<body>

<!-- ═══════════ NAVBAR ═══════════ -->
<nav class="navbar navbar-expand-lg fixed-top site-nav shadow-sm" id="siteNav" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px); min-height: 72px;">
  <div class="container-fluid" style="max-width: 1280px; padding: 0 1.5rem;">
    
    <!-- Brand -->
    <a class="navbar-brand d-flex align-items-center gap-2" href="<?= $basePath ?>/user/index.php" style="margin-right: auto; padding-left: 1rem;">
      <img src="<?= $basePath ?>/includes/image/kominfo.jpg" alt="Logo Kominfo" style="height: 55px; object-fit: contain;">
      <div style="width: 1.5px; height: 45px; background-color: #cbd5e1; margin: 0 10px;"></div>
      <img src="<?= $basePath ?>/includes/image/logo2.png" alt="Logo 2" style="height: 55px; object-fit: contain;">
    </a>

    <!-- Hamburger Toggle -->
    <div class="d-flex align-items-center d-lg-none gap-3">
      <button class="navbar-toggler border-0 shadow-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
      </button>
    </div>

    <!-- Menu Items -->
    <div class="collapse navbar-collapse justify-content-end" id="navMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center" style="padding-right: 1rem;">
        
        <li class="nav-item">
          <a class="nav-link py-2 px-3 rounded-3 <?= $activePage === 'home' ? 'active' : 'text-secondary fw-medium' ?>" href="<?= $basePath ?>/user/index.php" style="font-size: 0.875rem;">Beranda</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle py-2 px-3 rounded-3 <?= in_array($activePage, ['sejarah','visi-misi']) ? 'active' : 'text-secondary fw-medium' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.875rem;">
            Profil
          </a>
          <ul class="dropdown-menu mt-2">
            <li><a class="dropdown-item py-2 px-3 <?= $activePage === 'sejarah' ? 'active' : 'text-secondary' ?>" href="sejarah.php">Sejarah</a></li>
            <li><a class="dropdown-item py-2 px-3 <?= $activePage === 'visi-misi' ? 'active' : 'text-secondary' ?>" href="visi-misi.php">Visi &amp; Misi</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle py-2 px-3 rounded-3 <?= in_array($activePage, ['laporan', 'daftar-pengaduan']) ? 'active' : 'text-secondary fw-medium' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.875rem;">
            Pengaduan
          </a>
          <ul class="dropdown-menu mt-2">
            <li><a class="dropdown-item py-2 px-3 <?= $activePage === 'laporan' ? 'active' : 'text-secondary' ?>" href="laporan.php">Buat Pengaduan</a></li>
            <li><a class="dropdown-item py-2 px-3 <?= $activePage === 'daftar-pengaduan' ? 'active' : 'text-secondary' ?>" href="daftar-pengaduan.php">Daftar Laporan (Peta)</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle py-2 px-3 rounded-3 <?= in_array($activePage, ['penelitian', 'jurnal', 'magang', 'wifi']) ? 'active' : 'text-secondary fw-medium' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.875rem;">
            Layanan Publik
          </a>
          <ul class="dropdown-menu mt-2">
            <li><a class="dropdown-item py-2 px-3 <?= $activePage === 'penelitian' ? 'active' : 'text-secondary' ?>" href="penelitian.php">Penelitian</a></li>
            <li><a class="dropdown-item py-2 px-3 <?= $activePage === 'jurnal' ? 'active' : 'text-secondary' ?>" href="daftar-jurnal.php">Daftar Jurnal</a></li>
            <li><a class="dropdown-item py-2 px-3 <?= $activePage === 'magang' ? 'active' : 'text-secondary' ?>" href="magang.php">Magang &amp; PKL</a></li>
            <li><a class="dropdown-item py-2 px-3 <?= $activePage === 'wifi' ? 'active' : 'text-secondary' ?>" href="titik-wifi.php">Titik WiFi Gratis</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle py-2 px-3 rounded-3 <?= in_array($activePage, ['berita', 'cctv']) ? 'active' : 'text-secondary fw-medium' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.875rem;">
            Publikasi
          </a>
          <ul class="dropdown-menu mt-2">
            <li><a class="dropdown-item py-2 px-3 <?= $activePage === 'berita' ? 'active' : 'text-secondary' ?>" href="<?= $basePath ?>/user/berita.php">Berita</a></li>
            <li><a class="dropdown-item py-2 px-3 <?= $activePage === 'cctv' ? 'active' : 'text-secondary' ?>" href="<?= $basePath ?>/user/cctv.php">CCTV</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link py-2 px-3 rounded-3 <?= $activePage === 'komitmen' ? 'active' : 'text-secondary fw-medium' ?>" href="<?= $basePath ?>/user/komitmen.php" style="font-size: 0.875rem;">Daftar Komitmen</a>
        </li>
      </ul>
    </div>
    
  </div>
</nav>

<!-- Floating AI Button -->
<a href="<?= $basePath ?>/user/kinara.php" class="floating-ai-btn d-flex align-items-center justify-content-center" title="Tanya Asisten AI" style="position: fixed; bottom: 30px; right: 50px; z-index: 1050; width: 60px; height: 60px; border-radius: 50%; box-shadow: 0 6px 16px rgba(0,0,0,0.2); transition: transform 0.3s;">
  <img src="<?= $basePath ?>/includes/image/chatbot2.jpeg" alt="Asisten AI" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid #fff;">
</a>
<style>
.floating-ai-btn:hover {
  transform: translateY(-5px) scale(1.05);
  box-shadow: 0 8px 20px rgba(0,0,0,0.3);
}
</style>

