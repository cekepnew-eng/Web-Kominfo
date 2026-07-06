<?php
declare(strict_types=1);

$pageTitle  = 'Daftar Jurnal & Penelitian — Diskominfo Kota Bogor';
$activePage = 'jurnal';

require_once __DIR__ . '/../includes/header.php';

// Mock data for journals (Added more to simulate the image)
$journals = [
    [
        'title' => 'Pengalaman Penderita HIV Pada Lelaki Suka Lelaki (LSL): Analisis Kualitatif Tentang Persepsi Diri...',
        'author' => 'Dewi Purnamawati',
    ],
    [
        'title' => 'SELF-EFFICACY AMONG PEOPLE LIVING WITH HIV/AIDS AFTER COVID-19 PANDEMIC',
        'author' => 'Dewi Purnamawati',
    ],
    [
        'title' => 'FAMILY SUPPORT FOR PEOPLE WITH HIV AND AIDS (PLWHA)',
        'author' => 'Dewi Purnamawati',
    ],
    [
        'title' => 'Religiusitas Homoseksual dengan HIV',
        'author' => 'Dewi Purnamawati',
    ],
    [
        'title' => 'Faktor-Faktor Yang Berhubungan Dengan Kepatuhan Minum Obat Pada Pasien Diabetes Melitus Tipe 2...',
        'author' => 'Erina Dewy Pramesti',
    ],
    [
        'title' => 'Hubungan Pengetahuan dan Dukungan Keluarga Terhadap Manajemen Diri Pada Pasien Diabetes...',
        'author' => 'Mashiroh Irchanna Hartanti',
    ],
    [
        'title' => 'ANALISIS KOMUNIKASI INTERPERSONAL KADER DALAM PROGRAM AKSELERASI GERAKAN ELIMINASI...',
        'author' => 'Hanna Attaya Putri',
    ],
    [
        'title' => 'Gambaran Epidemiologi Kasus Campak di Wilayah Kota Bogor Tahun 2022-2024',
        'author' => 'Siti Setia Hidiyah Wati',
    ],
    [
        'title' => 'ANALISIS DETERMINAN STUNTING DI KABUPATEN BOGOR DAN KOTA BOGOR: PENDEKATAN SPASIAL...',
        'author' => 'LUKMAN PERDANA SOFYAN',
    ],
    [
        'title' => 'Efektifitas Buku Audio dalam Meningkatkan Pengetahuan Kesehatan Reproduksi bagi Perempuan...',
        'author' => 'Novita Dewi Pramanik',
    ],
];
?>

<!-- ═══════════ KONTEN UTAMA ═══════════ -->
<section class="section bg-light" style="min-height: 80vh; padding-top: 8rem; padding-bottom: 4rem;">
  <div class="container-fluid px-4 px-md-5 mt-2">
    <div class="row mb-4 align-items-center" data-aos="fade-up">
      <div class="col-md-8">
        <h4 class="fw-bold mb-2" style="color: #0369a1;">Daftar Hasil Penelitian & Jurnal</h4>
        <p class="text-secondary mb-0">Berikut adalah daftar penelitian, tugas akhir, dan jurnal yang telah diselesaikan dan dilaporkan.</p>
      </div>
      <div class="col-md-4 mt-3 mt-md-0 text-md-end">
        <div class="input-group">
          <input type="text" class="form-control bg-white" placeholder="Cari judul / penulis...">
          <button class="btn btn-primary" type="button" style="background-color: #0ea5e9; border:none;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          </button>
        </div>
      </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3" data-aos="fade-up" data-aos-delay="100">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover table-striped align-middle mb-0" style="font-size: 0.9rem;">
            <thead>
              <tr style="background-color: #0284c7; color: white;">
                <th scope="col" class="py-3 px-4 text-center" style="width: 5%; border-top-left-radius: 8px;">NO</th>
                <th scope="col" class="py-3 px-4" style="width: 60%;">JUDUL</th>
                <th scope="col" class="py-3 px-4" style="width: 25%;">PENULIS</th>
                <th scope="col" class="py-3 px-4 text-center" style="width: 10%; border-top-right-radius: 8px;">AKSI</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($journals as $index => $j): ?>
              <tr>
                <td class="text-center px-4 fw-bold text-secondary"><?= $index + 1 ?></td>
                <td class="px-4 fw-semibold text-dark" style="line-height: 1.5;"><?= htmlspecialchars($j['title']) ?></td>
                <td class="px-4 text-secondary"><?= htmlspecialchars($j['author']) ?></td>
                <td class="px-4 text-center">
                  <button class="btn btn-warning text-white btn-sm px-3 fw-bold shadow-sm d-inline-flex align-items-center" onclick="alert('Abstrak dan dokumen lengkap belum tersedia secara publik. Silakan hubungi PPID Diskominfo.')" style="border-radius: 6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Lihat
                  </button>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Paginasi -->
    <nav aria-label="Page navigation" class="mt-4 pb-5" data-aos="fade-up">
      <ul class="pagination justify-content-center">
        <li class="page-item disabled"><a class="page-link border-0 shadow-sm" href="#">Sebelumnya</a></li>
        <li class="page-item active"><a class="page-link border-0 shadow-sm" href="#" style="background-color: #0284c7;">1</a></li>
        <li class="page-item"><a class="page-link border-0 shadow-sm" href="#">2</a></li>
        <li class="page-item"><a class="page-link border-0 shadow-sm" href="#">3</a></li>
        <li class="page-item"><a class="page-link border-0 shadow-sm" href="#">Selanjutnya</a></li>
      </ul>
    </nav>
    
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
