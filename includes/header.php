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
    /* CSS Tambahan untuk memastikan navbar hover dan tanpa dot di mobile */
    .nav-item { list-style: none !important; }
    .nav-menu .dropdown-menu { border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border-radius: 12px; }
    .nav-menu .dropdown-item { padding: 0.6rem 1.2rem; border-radius: 6px; margin: 2px 8px; width: auto; font-weight: 500; }
    .nav-menu .dropdown-item:hover { background-color: #f1f5f9; color: #0ea5e9; }
    
    @media (max-width: 991px) {
      .nav-menu .dropdown-menu { display: block !important; box-shadow: none !important; padding: 0; margin-left: 1rem; border-left: 2px solid #e2e8f0; border-radius: 0; background: transparent; }
      .nav-menu .dropdown-item { padding: 0.5rem 1rem; }
    }
  </style>
</head>
<body>

<!-- ═══════════ NAVBAR ═══════════ -->
<header class="site-nav" id="siteNav">
  <div class="nav-wrap">

    <!-- Brand (Logo + Nama) -->
    <a href="<?= $basePath ?>/user/index.php" class="nav-brand">
      <img src="<?= $basePath ?>/includes/image/kominfo.jpg" alt="Logo Diskominfo">
      <span>Diskominfo <span class="subtitle">Kota Bogor</span></span>
    </a>

    <!-- Desktop Menu -->
    <nav class="nav-menu" id="navMenu">
      <div class="nav-item">
        <a href="<?= $basePath ?>/user/index.php"
           class="nav-link <?= $activePage === 'home' ? 'active' : '' ?>">Beranda</a>
      </div>

      <!-- Menggunakan <div> alih-alih <li> untuk menghindari munculnya titik (bullets) -->
      <div class="nav-item dropdown">
        <a class="nav-link dropdown-toggle <?= in_array($activePage, ['sejarah','visi-misi']) ? 'active' : '' ?>" href="#" id="profilDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Profil
        </a>
        <ul class="dropdown-menu" aria-labelledby="profilDropdown">
          <li><a class="dropdown-item <?= $activePage === 'sejarah' ? 'active text-primary fw-bold bg-light' : '' ?>" href="sejarah.php">Sejarah</a></li>
          <li><a class="dropdown-item <?= $activePage === 'visi-misi' ? 'active text-primary fw-bold bg-light' : '' ?>" href="visi-misi.php">Visi &amp; Misi</a></li>
        </ul>
      </div>

      <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?= in_array($activePage, ['laporan', 'daftar-pengaduan']) ? 'active' : '' ?>" href="#" id="pengaduanDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Pengaduan
            </a>
            <ul class="dropdown-menu" aria-labelledby="pengaduanDropdown">
              <li><a class="dropdown-item <?= $activePage === 'laporan' ? 'active text-primary fw-bold bg-light' : '' ?>" href="laporan.php">Buat Pengaduan</a></li>
              <li><a class="dropdown-item <?= $activePage === 'daftar-pengaduan' ? 'active text-primary fw-bold bg-light' : '' ?>" href="daftar-pengaduan.php">Daftar Laporan (Peta)</a></li>
            </ul>
      </div>

      <div class="nav-item dropdown">
        <a class="nav-link dropdown-toggle <?= in_array($activePage, ['penelitian', 'jurnal', 'magang', 'wifi']) ? 'active' : '' ?>" href="#" id="layananDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Layanan Publik
        </a>
        <ul class="dropdown-menu" aria-labelledby="layananDropdown">
          <li><a class="dropdown-item <?= $activePage === 'penelitian' ? 'active text-primary fw-bold bg-light' : '' ?>" href="penelitian.php">Penelitian</a></li>
          <li><a class="dropdown-item <?= $activePage === 'jurnal' ? 'active text-primary fw-bold bg-light' : '' ?>" href="daftar-jurnal.php">Daftar Jurnal</a></li>
          <li><a class="dropdown-item <?= $activePage === 'magang' ? 'active text-primary fw-bold bg-light' : '' ?>" href="magang.php">Magang &amp; PKL</a></li>
          <li><a class="dropdown-item <?= $activePage === 'wifi' ? 'active text-primary fw-bold bg-light' : '' ?>" href="titik-wifi.php">Titik WiFi Gratis</a></li>
        </ul>
      </div>
      
      <div class="nav-item">
        <a href="<?= $basePath ?>/user/berita.php"
           class="nav-link <?= $activePage === 'berita' ? 'active' : '' ?>">Berita</a>
      </div>
      <div class="nav-item">
        <a href="<?= $basePath ?>/user/cctv.php"
           class="nav-link <?= $activePage === 'cctv' ? 'active' : '' ?>">CCTV</a>
      </div>
    </nav>

    <!-- AI Icon Button -->
    <a href="<?= $basePath ?>/user/wowoembege.php" class="nav-ai-btn" title="Tanya Wowoembege AI" style="padding: 0; border: none; background: transparent; display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; border-radius: 50%; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
      <img src="<?= $basePath ?>/includes/image/chatbot2.jpeg" alt="AI Chat" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #fff;">
    </a>

    <!-- Mobile Hamburger -->
    <button class="nav-hamburger" id="hamburger" aria-label="Buka menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>
