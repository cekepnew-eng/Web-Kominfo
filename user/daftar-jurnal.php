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
    --surface: #ffffff;
    --border: #e2e8f0;
    --primary: #0ea5e9;
    --text-main: #0f172a;
    --text-muted: #64748b;
  }

  body {
    background-color: var(--bg-color);
    background-image: 
      radial-gradient(at 50% 0%, rgba(14, 165, 233, 0.1) 0px, transparent 50%),
      radial-gradient(at 0% 0%, rgba(224, 242, 254, 0.6) 0px, transparent 40%),
      radial-gradient(at 100% 0%, rgba(224, 242, 254, 0.6) 0px, transparent 40%);
    background-attachment: fixed;
  }

  /* Hero Search Section */
  .search-hero {
    background: transparent;
    padding: 2rem 2rem 4rem 2rem;
    position: relative;
    z-index: 10;
    margin-bottom: -4rem;
  }

  .search-hero::before {
    display: none;
  }

  .search-box-premium {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.9);
    border-radius: 100px;
    padding: 8px;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
  }
  
  .search-box-premium:focus-within {
    background: #ffffff;
    border-color: #bae6fd;
    box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.15);
  }

  .search-box-premium input {
    background: transparent;
    border: none;
    color: var(--text-main);
    padding: 12px 24px;
    font-size: 1.1rem;
    width: 100%;
  }
  .search-box-premium input::placeholder {
    color: var(--text-muted);
  }
  .search-box-premium input:focus {
    outline: none;
    box-shadow: none;
  }

  .search-box-premium button {
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 100px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .search-box-premium button:hover {
    background: #0284c7;
    transform: scale(1.05);
  }

  /* Premium Data List Layout */
  .data-list-container {
    background: var(--surface);
    border-radius: 32px;
    padding: 5rem 2rem 2rem 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    border: 1px solid var(--border);
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
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 1rem 1.5rem;
  }

  .table-custom tbody tr {
    background: #f8fafc;
    transition: all 0.3s ease;
  }

  .table-custom tbody tr:hover {
    background: var(--surface);
    box-shadow: 0 15px 35px rgba(0,0,0,0.06);
    transform: translateY(-2px);
  }

  .table-custom tbody td {
    padding: 1.5rem;
    border: none;
    vertical-align: middle;
  }

  /* Radius for table rows */
  .table-custom tbody tr td:first-child {
    border-top-left-radius: 16px;
    border-bottom-left-radius: 16px;
  }
  .table-custom tbody tr td:last-child {
    border-top-right-radius: 16px;
    border-bottom-right-radius: 16px;
  }

  /* Tag Styling */
  .tag-badge {
    background: #e0f2fe;
    color: #0284c7;
    padding: 6px 12px;
    border-radius: 100px;
    font-size: 0.75rem;
    font-weight: 600;
    border: 1px solid #bae6fd;
  }

  /* Sleek Button */
  .btn-sleek {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    background: #f1f5f9;
    color: var(--text-main);
    border-radius: 50%;
    border: 1px solid var(--border);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  }

  .btn-sleek:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: scale(1.1) rotate(-15deg);
    box-shadow: 0 10px 20px rgba(14, 165, 233, 0.2);
  }

  /* Pagination Custom */
  .pagination-custom .page-link {
    border: none;
    color: var(--text-muted);
    font-weight: 600;
    margin: 0 4px;
    border-radius: 12px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
  }
  .pagination-custom .page-link:hover {
    background: #f1f5f9;
    color: var(--text-main);
  }
  .pagination-custom .page-item.active .page-link {
    background: var(--text-main);
    color: white;
    box-shadow: 0 8px 15px rgba(15, 23, 42, 0.2);
  }

  .btn-premium {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    border: none;
    color: white;
    font-weight: 700;
    padding: 12px 28px;
    border-radius: 100px;
    box-shadow: 0 10px 20px rgba(14, 165, 233, 0.3);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
  }
  .btn-premium:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(14, 165, 233, 0.4);
    color: white;
  }

</style>

<!-- ═══════════ KONTEN UTAMA ═══════════ -->
<section class="section" style="padding-top: 8rem; padding-bottom: 5rem;">
  <div class="container px-3 px-md-4 mt-2">
    
    <div class="mb-4" data-aos="fade-right">
      <a href="<?= $basePath ?>/user/index.php" class="btn-premium">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Kembali
      </a>
    </div>

    <!-- Hero Search -->
    <div class="search-hero text-center" data-aos="fade-up">
      <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-semibold mb-3">Arsip Penelitian Publik</span>
      <h2 class="display-6 fw-bold text-dark mb-4">Daftar Hasil Penelitian & Jurnal</h2>
      
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="search-box-premium">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ms-3 text-muted"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" placeholder="Cari judul penelitian atau nama penulis...">
            <button type="button">Temukan</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Data List Container -->
    <div class="data-list-container" data-aos="fade-up" data-aos-delay="100">
      
      <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <h5 class="fw-bold mb-0" style="color: var(--text-main);">10 Jurnal Terbaru</h5>
        <select class="form-select border-0 bg-light w-auto fw-medium shadow-sm" style="border-radius: 12px; cursor: pointer;">
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
