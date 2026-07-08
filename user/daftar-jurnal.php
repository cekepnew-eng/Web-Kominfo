<?php
declare(strict_types=1);

$pageTitle  = 'Daftar Jurnal & Penelitian — Diskominfo Kota Bogor';
$activePage = 'jurnal';

require_once __DIR__ . '/../includes/header.php';

// Mock data for journals
$journals = [
    [
        'title' => 'Pengalaman Penderita HIV Pada Lelaki Suka Lelaki (LSL): Analisis Kualitatif Tentang Persepsi Diri...',
        'author' => 'Dewi Purnamawati',
        'tag' => 'Kesehatan'
    ],
    [
        'title' => 'SELF-EFFICACY AMONG PEOPLE LIVING WITH HIV/AIDS AFTER COVID-19 PANDEMIC',
        'author' => 'Dewi Purnamawati',
        'tag' => 'Kesehatan'
    ],
    [
        'title' => 'FAMILY SUPPORT FOR PEOPLE WITH HIV AND AIDS (PLWHA)',
        'author' => 'Dewi Purnamawati',
        'tag' => 'Sosial'
    ],
    [
        'title' => 'Religiusitas Homoseksual dengan HIV',
        'author' => 'Dewi Purnamawati',
        'tag' => 'Kesehatan'
    ],
    [
        'title' => 'Faktor-Faktor Yang Berhubungan Dengan Kepatuhan Minum Obat Pada Pasien Diabetes Melitus Tipe 2...',
        'author' => 'Erina Dewy Pramesti',
        'tag' => 'Medis'
    ],
    [
        'title' => 'Hubungan Pengetahuan dan Dukungan Keluarga Terhadap Manajemen Diri Pada Pasien Diabetes...',
        'author' => 'Mashiroh Irchanna Hartanti',
        'tag' => 'Medis'
    ],
    [
        'title' => 'ANALISIS KOMUNIKASI INTERPERSONAL KADER DALAM PROGRAM AKSELERASI GERAKAN ELIMINASI...',
        'author' => 'Hanna Attaya Putri',
        'tag' => 'Komunikasi'
    ],
    [
        'title' => 'Gambaran Epidemiologi Kasus Campak di Wilayah Kota Bogor Tahun 2022-2024',
        'author' => 'Siti Setia Hidiyah Wati',
        'tag' => 'Kesehatan'
    ],
    [
        'title' => 'ANALISIS DETERMINAN STUNTING DI KABUPATEN BOGOR DAN KOTA BOGOR: PENDEKATAN SPASIAL...',
        'author' => 'LUKMAN PERDANA SOFYAN',
        'tag' => 'Spasial'
    ],
    [
        'title' => 'Efektifitas Buku Audio dalam Meningkatkan Pengetahuan Kesehatan Reproduksi bagi Perempuan...',
        'author' => 'Novita Dewi Pramanik',
        'tag' => 'Kesehatan'
    ],
];
?>

<style>
  :root {
    --bg-color: #f8fafc;
    --primary: #0ea5e9;
    --primary-dark: #0284c7;
    --surface: #ffffff;
    --border: #e2e8f0;
    --text: #0f172a;
    --text-muted: #64748b;
  }

  body {
    background-color: var(--bg-color);
    position: relative;
    overflow-x: hidden;
  }

  /* ─── Abstract Shapes Background ─── */
  .shape-blob {
    position: absolute;
    filter: blur(90px);
    z-index: 0;
    border-radius: 50%;
    opacity: 0.6;
    animation: blobFloat 12s infinite alternate cubic-bezier(0.4, 0, 0.2, 1);
  }
  .blob-1 { top: -10%; left: -10%; width: 500px; height: 500px; background: #bae6fd; }
  .blob-2 { top: 20%; right: -5%; width: 400px; height: 400px; background: #a7f3d0; animation-delay: -3s; }
  .blob-3 { bottom: 10%; left: 15%; width: 600px; height: 600px; background: #e0e7ff; animation-delay: -6s; }
  @keyframes blobFloat {
    0% { transform: translate(0, 0) scale(1); }
    100% { transform: translate(40px, -60px) scale(1.1); }
  }
  
  .pattern-dots {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(#cbd5e1 1.5px, transparent 1.5px);
    background-size: 32px 32px;
    opacity: 0.4;
    z-index: 0;
    pointer-events: none;
  }

  /* ─── Centered Modern Hero ─── */
  .modern-hero {
    position: relative;
    padding: 90px 0 60px 0;
    z-index: 2;
    text-align: center;
  }
  .hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.4);
    padding: 8px 16px;
    border-radius: 100px;
    color: var(--primary-dark);
    font-weight: 700;
    font-size: 0.85rem;
    box-shadow: 0 4px 15px rgba(14, 165, 233, 0.1);
    margin-bottom: 24px;
  }
  .modern-hero h1 {
    font-size: clamp(2.2rem, 4vw, 3.5rem);
    font-weight: 800;
    color: var(--text);
    letter-spacing: -1.5px;
    margin-bottom: 24px;
    line-height: 1.2;
  }
  .modern-hero h1 span {
    background: linear-gradient(135deg, #0ea5e9, #6366f1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  
  /* ─── Premium Search Box ─── */
  .search-box-premium {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.9);
    border-radius: 100px;
    padding: 6px;
    display: flex;
    align-items: center;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 20px 40px rgba(14, 165, 233, 0.1);
    max-width: 550px;
    margin: 0 auto;
  }
  .search-box-premium:focus-within {
    background: #ffffff;
    border-color: #bae6fd;
    box-shadow: 0 0 0 5px rgba(14, 165, 233, 0.15), 0 30px 60px rgba(14, 165, 233, 0.15);
    transform: translateY(-2px);
  }
  .search-box-premium input {
    background: transparent;
    border: none;
    color: var(--text);
    padding: 10px 16px;
    font-size: 0.95rem;
    width: 100%;
  }
  .search-box-premium input::placeholder { color: var(--text-muted); }
  .search-box-premium input:focus { outline: none; box-shadow: none; }
  .search-box-premium button {
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    color: white;
    border: none;
    border-radius: 100px;
    padding: 10px 24px;
    font-weight: 700;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    box-shadow: 0 10px 20px rgba(14, 165, 233, 0.3);
  }
  .search-box-premium button:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 15px 30px rgba(14, 165, 233, 0.4);
  }

  /* ─── Premium Data Container ─── */
  .data-list-container {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(20px);
    border-radius: 32px;
    padding: 3rem 2rem 2rem 2rem;
    box-shadow: 0 30px 60px rgba(0,0,0,0.05);
    border: 1px solid rgba(255,255,255,0.8);
    position: relative;
    z-index: 2;
    margin-top: 2rem;
  }

  .table-custom {
    border-collapse: separate;
    border-spacing: 0 12px;
    width: 100%;
  }
  .table-custom thead th {
    border: none;
    color: var(--text-muted);
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 1rem 1.5rem;
  }
  .table-custom tbody tr {
    background: rgba(255,255,255,0.6);
    transition: all 0.3s ease;
  }
  .table-custom tbody tr:hover {
    background: rgba(255,255,255,0.95);
    box-shadow: 0 15px 35px rgba(14, 165, 233, 0.08);
    transform: translateY(-2px) scale(1.01);
  }
  .table-custom tbody td {
    padding: 1.5rem;
    border: none;
    vertical-align: middle;
  }
  .table-custom tbody tr td:first-child { border-top-left-radius: 16px; border-bottom-left-radius: 16px; }
  .table-custom tbody tr td:last-child { border-top-right-radius: 16px; border-bottom-right-radius: 16px; }

  .tag-badge {
    background: #e0f2fe;
    color: #0284c7;
    padding: 6px 12px;
    border-radius: 100px;
    font-size: 0.75rem;
    font-weight: 700;
    border: 1px solid #bae6fd;
  }

  .btn-sleek {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    background: #f8fafc;
    color: var(--text);
    border-radius: 50%;
    border: 1px solid var(--border);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  }
  .btn-sleek:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: scale(1.1) rotate(-15deg);
    box-shadow: 0 10px 20px rgba(14, 165, 233, 0.25);
  }

  /* Pagination Custom */
  .pagination-custom .page-link {
    border: none;
    color: var(--text-muted);
    font-weight: 600;
    margin: 0 4px;
    border-radius: 12px;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    background: transparent;
  }
  .pagination-custom .page-link:hover {
    background: rgba(255,255,255,0.9);
    color: var(--text);
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  }
  .pagination-custom .page-item.active .page-link {
    background: var(--text);
    color: white;
    box-shadow: 0 8px 15px rgba(15, 23, 42, 0.2);
  }

  .btn-outline-premium {
    background: rgba(255,255,255,0.8);
    backdrop-filter: blur(10px);
    border: 2px solid #e2e8f0;
    color: var(--text);
    font-weight: 700;
    padding: 10px 24px;
    border-radius: 100px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    font-size: 0.9rem;
  }
  .btn-outline-premium:hover {
    background: #ffffff;
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(14, 165, 233, 0.1);
  }

  .btn-back-sticky {
    position: fixed;
    top: 100px;
    left: 24px;
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(10px);
    border: 2px solid #e2e8f0;
    color: var(--primary-dark);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1050;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
  }
  .btn-back-sticky:hover {
    background: #ffffff;
    border-color: var(--primary);
    color: var(--primary);
    transform: scale(1.1);
    box-shadow: 0 8px 25px rgba(14, 165, 233, 0.2);
  }
  @media (max-width: 768px) {
    .btn-back-sticky {
      top: 85px;
      left: 15px;
      width: 44px;
      height: 44px;
    }
  }
</style>

<!-- ─── Abstract Shapes ─── -->
<div class="shape-blob blob-1"></div>
<div class="shape-blob blob-2"></div>
<div class="shape-blob blob-3"></div>
<div class="pattern-dots"></div>

<!-- ─── CENTERED HERO ─── -->
<a href="<?= $basePath ?>/user/index.php" class="btn-back-sticky" title="Kembali ke Beranda">
  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
</a>

<div class="modern-hero">
  <div class="container" data-aos="fade-up">

    <div class="hero-badge">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
      Arsip Penelitian Publik
    </div>
    
    <h1>Daftar Hasil Penelitian & <span>Jurnal</span></h1>
    
    <div class="search-box-premium mt-4" data-aos="zoom-in" data-aos-delay="100">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ms-3 text-muted"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
      <input type="text" placeholder="Cari judul penelitian atau nama penulis...">
      <button type="button">Temukan Jurnal</button>
    </div>
    
  </div>
</div>

<!-- ─── KONTEN UTAMA ─── -->
<section class="section position-relative" style="padding-top: 1rem; padding-bottom: 6rem; z-index: 2;">
  <div class="container px-3 px-md-4">

    <!-- Data List Container -->
    <div class="data-list-container" data-aos="fade-up" data-aos-delay="200">
      
      <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <h5 class="fw-bold mb-0" style="color: var(--text);">Terbaru Diunggah</h5>
        <select class="form-select border-0 bg-white w-auto fw-medium shadow-sm" style="border-radius: 12px; cursor: pointer;">
          <option>Terbaru</option>
          <option>Terpopuler</option>
          <option>A - Z</option>
        </select>
      </div>

      <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="table-custom mb-0">
          <thead>
            <tr>
              <th style="width: 5%; text-align: center;">NO</th>
              <th style="width: 50%;">Judul Karya Ilmiah</th>
              <th style="width: 20%;">Penulis</th>
              <th style="width: 15%; text-align: center;">Kategori</th>
              <th style="width: 10%; text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($journals as $index => $j): ?>
            <tr>
              <td class="text-center fw-bold text-muted"><?= sprintf("%02d", $index + 1) ?></td>
              <td>
                <h6 class="fw-bold mb-1 text-dark" style="line-height: 1.5; font-size: 0.95rem;"><?= htmlspecialchars($j['title']) ?></h6>
                <small class="text-muted d-block d-md-none mt-2">Oleh: <?= htmlspecialchars($j['author']) ?></small>
              </td>
              <td class="d-none d-md-table-cell text-secondary fw-medium" style="font-size: 0.9rem;"><?= htmlspecialchars($j['author']) ?></td>
              <td class="text-center">
                <span class="tag-badge"><?= htmlspecialchars($j['tag']) ?></span>
              </td>
              <td class="text-center">
                <button class="btn-sleek" onclick="alert('Abstrak dan dokumen lengkap belum tersedia secara publik. Silakan hubungi PPID Diskominfo.')" title="Lihat Detail">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Paginasi -->
      <nav aria-label="Page navigation" class="mt-5" data-aos="fade-up">
        <ul class="pagination pagination-custom justify-content-center">
          <li class="page-item disabled">
            <a class="page-link" href="#" style="width: auto; padding: 0 16px;">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
          </li>
          <li class="page-item active"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item">
            <a class="page-link" href="#" style="width: auto; padding: 0 16px;">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
          </li>
        </ul>
      </nav>
      
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
