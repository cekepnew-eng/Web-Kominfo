<?php
declare(strict_types=1);

// Tampilkan error agar tidak muncul blank screen jika ada fatal error
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once __DIR__ . '/services.php';

$pageTitle    = $pageTitle    ?? 'Diskominfo Kota Bogor';
$activePage   = $activePage   ?? 'home';

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
  <link rel="stylesheet" href="<?= $basePath ?>/assets/css/app.css">
  
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
    <a class="navbar-brand d-flex align-items-center gap-2" href="<?= $basePath ?>/user/index.php">
      <img src="<?= $basePath ?>/includes/image/kominfo.jpg" alt="Logo" style="width: 36px; height: 36px; border-radius: 8px; object-fit: cover;">
      <span class="brand-text fw-bold fs-6 text-dark" style="line-height: 1.2; transition: color 0.3s ease;">Diskominfo <br><small class="brand-subtext text-muted fw-normal" style="font-size:0.7rem; display:block; transition: color 0.3s ease;">Kota Bogor</small></span>
    </a>

    <!-- Hamburger Toggle & Mobile AI Button -->
    <div class="d-flex align-items-center d-lg-none gap-3">
      <a href="<?= $basePath ?>/user/wowoembege.php" class="d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border-radius: 8px;">
        <img src="<?= $basePath ?>/includes/image/chatbot2.jpeg" alt="AI Chat" style="width: 100%; height: 100%; border-radius: 8px; object-fit: cover; border: 2px solid #2563eb;">
      </a>
      <button class="navbar-toggler border-0 shadow-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
      </button>
    </div>

    <!-- Menu Items -->
    <div class="collapse navbar-collapse justify-content-center" id="navMenu">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-lg-center">
        
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

        <li class="nav-item">
          <a class="nav-link py-2 px-3 rounded-3 <?= $activePage === 'berita' ? 'active' : 'text-secondary fw-medium' ?>" href="<?= $basePath ?>/user/berita.php" style="font-size: 0.875rem;">Berita</a>
        </li>
        <li class="nav-item">
          <a class="nav-link py-2 px-3 rounded-3 <?= $activePage === 'cctv' ? 'active' : 'text-secondary fw-medium' ?>" href="<?= $basePath ?>/user/cctv.php" style="font-size: 0.875rem;">CCTV</a>
        </li>
      </ul>
    </div>
    
    <!-- AI Icon Desktop -->
    <div class="d-none d-lg-flex align-items-center">
      <a href="<?= $basePath ?>/user/wowoembege.php" class="d-flex align-items-center justify-content-center" title="Tanya Wowoembege AI" style="width: 44px; height: 44px; border-radius: 50%; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
        <img src="<?= $basePath ?>/includes/image/chatbot2.jpeg" alt="AI Chat" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2px solid #fff;">
      </a>
    </div>
  </div>
</nav>
