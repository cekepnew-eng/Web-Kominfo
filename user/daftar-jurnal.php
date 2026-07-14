<?php
declare(strict_types=1);

$pageTitle  = 'Daftar Hasil Penelitian & Jurnal';
$activePage = 'jurnal';

require_once __DIR__ . '/../includes/header.php';

// Mock data for journals (15 items to demonstrate pagination)
$allJournals = [
    ['title' => 'Pengalaman Penderita HIV Pada Lelaki Suka Lelaki (LSL): Analisis Kualitatif Tentang Persepsi Diri...', 'author' => 'Dewi Purnamawati'],
    ['title' => 'SELF-EFFICACY AMONG PEOPLE LIVING WITH HIV/AIDS AFTER COVID-19 PANDEMIC', 'author' => 'Dewi Purnamawati'],
    ['title' => 'FAMILY SUPPORT FOR PEOPLE WITH HIV AND AIDS (PLWHA)', 'author' => 'Dewi Purnamawati'],
    ['title' => 'Religiusitas Homoseksual dengan HIV', 'author' => 'Dewi Purnamawati'],
    ['title' => 'Faktor-Faktor Yang Berhubungan Dengan Kepatuhan Minum Obat Pada Pasien Diabetes Melitus Tipe 2...', 'author' => 'Erina Dewy Pramesti'],
    ['title' => 'Hubungan Pengetahuan dan Dukungan Keluarga Terhadap Manajemen Diri Pada Pasien Diabetes...', 'author' => 'Mashiroh Irchanna Hartanti'],
    ['title' => 'ANALISIS KOMUNIKASI INTERPERSONAL KADER DALAM PROGRAM AKSELERASI GERAKAN ELIMINASI...', 'author' => 'Hanna Attaya Putri'],
    ['title' => 'Gambaran Epidemiologi Kasus Campak di Wilayah Kota Bogor Tahun 2022-2024', 'author' => 'Siti Setia Hidiyah Wati'],
    ['title' => 'ANALISIS DETERMINAN STUNTING DI KABUPATEN BOGOR DAN KOTA BOGOR: PENDEKATAN SPASIAL...', 'author' => 'LUKMAN PERDANA SOFYAN'],
    ['title' => 'Efektifitas Buku Audio dalam Meningkatkan Pengetahuan Kesehatan Reproduksi bagi Perempuan...', 'author' => 'Novita Dewi Pramanik'],
    ['title' => 'Hubungan Pola Makan dan Kejadian Hipertensi pada Lansia', 'author' => 'Budi Santoso'],
    ['title' => 'Pemanfaatan Teknologi Informasi Dalam Manajemen Pelayanan Rumah Sakit', 'author' => 'Ahmad Rinaldi'],
    ['title' => 'Tingkat Kepatuhan Penggunaan Masker di Lingkungan Sekolah', 'author' => 'Rina Wijayanti'],
    ['title' => 'Analisis Kebijakan Vaksinasi COVID-19 Pada Anak', 'author' => 'Dwi Handayani'],
    ['title' => 'Dampak Karantina Wilayah Terhadap Kesehatan Mental Remaja', 'author' => 'Arie Pratama']
];

// 1. Logika Pencarian (Search)
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$filteredJournals = [];

if ($searchQuery !== '') {
    foreach ($allJournals as $j) {
        if (stripos($j['title'], $searchQuery) !== false || stripos($j['author'], $searchQuery) !== false) {
            $filteredJournals[] = $j;
        }
    }
} else {
    $filteredJournals = $allJournals;
}

// 2. Logika Pagination
$itemsPerPage = 10;
$totalItems = count($filteredJournals);
$totalPages = max(1, ceil($totalItems / $itemsPerPage));

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
if ($page > $totalPages) $page = $totalPages;

$offset = ($page - 1) * $itemsPerPage;
$currentJournals = array_slice($filteredJournals, $offset, $itemsPerPage);
?>

<style>
  :root {
    --bg-color: #f8fafc;
    --primary: #0284c7;
    --primary-dark: #0369a1;
    --surface: #ffffff;
    --text: #0f172a;
    --text-muted: #64748b;
  }
  
  body {
    background-color: var(--bg-color);
  }

  .page-container {
    max-width: 1200px;
    margin: 110px auto 60px auto;
    padding: 0 1.5rem;
  }

  /* Header Section */
  .header-section {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1.5rem;
  }
  .header-title h1 {
    color: var(--primary);
    font-size: 1.8rem;
    font-weight: 800;
    margin-bottom: 0.25rem;
  }
  .header-title p {
    color: var(--text-muted);
    font-size: 0.95rem;
    margin: 0;
  }
  
  /* Search Box */
  .search-form {
    display: flex;
    align-items: center;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 100px;
    padding: 4px;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
  }
  .search-form input {
    border: none;
    background: transparent;
    padding: 10px 16px;
    font-size: 0.95rem;
    width: 100%;
    outline: none;
    color: var(--text);
  }
  .search-form input::placeholder {
    color: #94a3b8;
  }
  .search-btn {
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    margin-right: 4px;
    flex-shrink: 0;
    transition: background 0.2s;
  }
  .search-btn:hover {
    background: #2563eb;
  }
  
  /* Table Styles */
  .table-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    overflow: hidden;
  }
  .table-custom {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
  }
  .table-custom thead {
    background: #1e293b;
    color: white;
  }
  .table-custom th {
    padding: 1.25rem 1.5rem;
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .table-custom td {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
  }
  .table-custom tr:hover td {
    background: #f8fafc;
  }
  .table-custom tr:last-child td {
    border-bottom: none;
  }
  .col-no { width: 5%; text-align: center; }
  .col-judul { width: 55%; }
  .col-penulis { width: 25%; }
  .col-aksi { width: 15%; text-align: center; }

  .row-num {
    color: var(--text-muted);
    font-weight: 600;
  }
  .row-title {
    font-weight: 700;
    color: #1e293b;
    font-size: 0.95rem;
    margin: 0;
    line-height: 1.5;
  }
  .row-author {
    color: var(--text-muted);
    font-size: 0.9rem;
  }
  .btn-lihat {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: #3b82f6;
    color: white;
    padding: 8px 20px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
  }
  .btn-lihat:hover {
    background: #2563eb;
    color: white;
  }
  
  /* Pagination */
  .pagination-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 2rem;
    gap: 8px;
  }
  .page-item {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    color: var(--text-muted);
    text-decoration: none;
    font-weight: 700;
    font-size: 0.95rem;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    transition: all 0.2s;
    border: 1px solid transparent;
  }
  .page-item:hover:not(.disabled) {
    background: #f8fafc;
    color: #0f172a;
    border-color: #e2e8f0;
  }
  .page-item.active {
    background: #3b82f6;
    color: white;
    box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
  }
  .page-item.disabled {
    opacity: 0.4;
    cursor: not-allowed;
  }

  .empty-state {
    padding: 3rem;
    text-align: center;
    color: var(--text-muted);
  }

  /* Responsiveness */
  @media (max-width: 768px) {
    .page-container {
      margin-top: 90px;
    }
    .header-section {
      flex-direction: column;
      gap: 1rem;
    }
    .search-form {
      max-width: 100%;
    }
    
    /* Transform Table to Cards on Mobile */
    .table-container {
      background: transparent;
      box-shadow: none;
      border-radius: 0;
    }
    .table-responsive-wrapper {
      overflow-x: hidden;
    }
    .table-custom, .table-custom tbody, .table-custom tr, .table-custom td {
      display: block;
      width: 100%;
    }
    .table-custom thead {
      display: none;
    }
    .table-custom tr {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
      margin-bottom: 1.5rem;
      border: 1px solid #f1f5f9;
      position: relative;
    }
    .table-custom tr:hover td {
      background: transparent;
    }
    .table-custom td {
      padding: 1.2rem;
      border-bottom: none;
      text-align: left;
    }
    .col-no {
      display: flex !important;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #f1f5f9 !important;
      color: #64748b;
      font-weight: 700;
    }
    .col-no::before {
      content: "JURNAL NO.";
      color: #94a3b8;
      font-size: 0.8rem;
      letter-spacing: 0.5px;
    }
    .col-judul {
      padding-top: 1.5rem !important;
      padding-bottom: 1rem !important;
    }
    .row-title {
      font-size: 1.1rem;
      line-height: 1.5;
    }
    .col-penulis {
      color: #64748b;
      padding-top: 0 !important;
      padding-bottom: 1.5rem !important;
    }
    .col-penulis::before {
      content: "Penulis: ";
      font-weight: 700;
      color: #475569;
    }
    .col-aksi {
      padding-top: 0 !important;
    }
    .btn-lihat {
      width: 100%;
      padding: 14px;
      font-size: 1rem;
      border-radius: 10px;
    }
  }
</style>

<div class="page-container" data-aos="fade-up">

  <div class="header-section">
    <div class="header-title">
      <h1>Daftar Hasil Penelitian & Jurnal</h1>
      <p>Berikut adalah daftar penelitian, tugas akhir, dan jurnal yang telah diselesaikan dan dilaporkan.</p>
    </div>
    
    <form class="search-form" method="GET" action="daftar-jurnal.php">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ms-3"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
      <input type="text" name="search" placeholder="Cari judul / penulis..." value="<?= htmlspecialchars($searchQuery) ?>">
      <button type="submit" class="search-btn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </button>
    </form>
  </div>

  <div class="table-container">
    <div class="table-responsive-wrapper">
      <table class="table-custom">
        <thead>
        <tr>
          <th class="col-no">NO</th>
          <th class="col-judul">JUDUL</th>
          <th class="col-penulis">PENULIS</th>
          <th class="col-aksi">AKSI</th>
        </tr>
      </thead>
      <tbody>
        <?php if(count($currentJournals) > 0): ?>
            <?php foreach($currentJournals as $index => $j): ?>
            <tr>
              <td class="col-no row-num"><?= $offset + $index + 1 ?></td>
              <td class="col-judul">
                <h6 class="row-title"><?= htmlspecialchars($j['title']) ?></h6>
              </td>
              <td class="col-penulis row-author"><?= htmlspecialchars($j['author']) ?></td>
              <td class="col-aksi">
                <button type="button" class="btn-lihat" onclick="alert('Abstrak belum tersedia secara publik.')">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                  Lihat
                </button>
              </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="empty-state">
                    Pencarian "<b><?= htmlspecialchars($searchQuery) ?></b>" tidak ditemukan.
                </td>
            </tr>
        <?php endif; ?>
      </tbody>
    </table>
    </div>
  </div>

  <!-- Pagination -->
  <?php if ($totalPages > 1): ?>
  <div class="pagination-container">
    <!-- Prev Button -->
    <?php if ($page > 1): ?>
      <a href="?page=<?= $page - 1 ?><?= $searchQuery !== '' ? '&search='.urlencode($searchQuery) : '' ?>" class="page-item">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
      </a>
    <?php else: ?>
      <span class="page-item disabled">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
      </span>
    <?php endif; ?>

    <!-- Number Buttons -->
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <a href="?page=<?= $i ?><?= $searchQuery !== '' ? '&search='.urlencode($searchQuery) : '' ?>" class="page-item <?= $i === $page ? 'active' : '' ?>">
        <?= $i ?>
      </a>
    <?php endfor; ?>

    <!-- Next Button -->
    <?php if ($page < $totalPages): ?>
      <a href="?page=<?= $page + 1 ?><?= $searchQuery !== '' ? '&search='.urlencode($searchQuery) : '' ?>" class="page-item">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    <?php else: ?>
      <span class="page-item disabled">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </span>
    <?php endif; ?>
  </div>
  <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
