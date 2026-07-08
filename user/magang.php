<?php
declare(strict_types=1);

$pageTitle  = 'Pendaftaran Magang (PKL) — Diskominfo Kota Bogor';
$activePage = 'magang';

require_once __DIR__ . '/../includes/header.php';
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
  }

  /* Segmented Controls (Premium Tabs) */
  .segmented-control {
    display: inline-flex;
    background: #f1f5f9;
    padding: 6px;
    border-radius: 100px;
    position: relative;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.03);
  }

  .segmented-control .nav-link {
    color: var(--text-muted);
    font-weight: 600;
    font-size: 0.95rem;
    padding: 10px 24px;
    border-radius: 100px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1;
    border: none;
    background: transparent;
  }

  .segmented-control .nav-link.active {
    color: var(--primary-dark);
    background: var(--surface);
    box-shadow: 0 4px 15px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.02);
  }

  /* Floating Info Card */
  .floating-card {
    background: var(--surface);
    border-radius: 24px;
    padding: 3rem;
    box-shadow: 0 20px 40px rgba(0,0,0,0.03);
    border: 1px solid rgba(255,255,255,0.8);
    position: relative;
    overflow: hidden;
  }

  .floating-card::before {
    content: '';
    position: absolute;
    top: -50%; left: -50%;
    width: 200%; height: 200%;
    background: radial-gradient(circle at 50% 0%, rgba(14, 165, 233, 0.05), transparent 50%);
    pointer-events: none;
  }

  .stat-box {
    background: #f8fafc;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 1.5rem 1rem;
    text-align: center;
    transition: all 0.3s ease;
  }
  .stat-box:hover {
    border-color: #bae6fd;
    background: #f0f9ff;
    transform: translateY(-3px);
  }

  .posisi-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 2rem;
    height: 100%;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    overflow: hidden;
  }

  .posisi-card:hover {
    transform: translateY(-8px);
    border-color: var(--primary);
    box-shadow: 0 20px 30px rgba(14, 165, 233, 0.1);
  }

  .posisi-icon {
    width: 48px;
    height: 48px;
    background: #f0f9ff;
    color: var(--primary);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.2rem;
  }

  /* Premium Form Styles */
  .form-floating > .form-control,
  .form-floating > .form-select {
    background-color: #f8fafc;
    border: 2px solid transparent;
    border-radius: 12px;
    transition: all 0.3s ease;
    box-shadow: none;
  }

  .form-floating > .form-control:focus,
  .form-floating > .form-select:focus {
    background-color: var(--surface);
    border-color: #bae6fd;
    box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.15);
  }
  
  .form-floating > label {
    color: var(--text-muted);
    font-weight: 500;
  }

  .form-control[type="file"] {
    background-color: #f8fafc;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 1rem;
    transition: all 0.3s ease;
  }
  .form-control[type="file"]:focus, .form-control[type="file"]:hover {
    border-color: var(--primary);
    background-color: #f0f9ff;
  }

  .btn-premium {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    border: none;
    color: white;
    font-weight: 700;
    padding: 14px 32px;
    border-radius: 100px;
    box-shadow: 0 10px 20px rgba(14, 165, 233, 0.3);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }
  .btn-premium:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(14, 165, 233, 0.4);
    color: white;
  }

  .info-alert {
    background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
    border: 1px solid #fecdd3;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 10px 25px rgba(225, 29, 72, 0.05);
  }
  .info-alert h5 {
    color: #e11d48;
    font-weight: 800;
  }
</style>

<!-- ═══════════ KONTEN UTAMA ═══════════ -->
<section class="section" style="padding-top: 8rem; padding-bottom: 5rem;">
  <div class="container mt-2">
    
    <!-- Header Navigasi & Judul -->
    <div class="mb-5" data-aos="fade-right">
      <h2 class="fw-bold mb-1" style="letter-spacing: -0.5px; color: var(--text);">Program Magang Profesional</h2>
      <p class="text-muted mb-0">Raih pengalaman nyata di lingkungan e-Government</p>
    </div>

    <!-- Info Singkat Magang (Floating Card) -->
    <div class="floating-card mb-5" data-aos="fade-up">
          <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0 pe-lg-5">
              <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-semibold mb-3">Tentang Program</span>
              <h3 class="fw-bold mb-3">Membangun Ekosistem Digital Kota Bogor</h3>
              <p class="text-secondary mb-4" style="line-height: 1.8; font-size: 1.05rem;">
                Kesempatan emas bagi siswa SMK dan Mahasiswa (D3/S1) untuk bergabung dalam Praktik Kerja Lapangan (PKL). Anda akan terjun langsung menangani proyek riil, memecahkan masalah IT kota, dan didampingi mentor profesional.
              </p>
              <div class="d-flex gap-3">
                <div class="stat-box flex-grow-1">
                  <h3 class="fw-bold text-primary mb-0">3+</h3>
                  <small class="text-muted fw-medium">Bulan</small>
                </div>
                <div class="stat-box flex-grow-1">
                  <h3 class="fw-bold text-primary mb-0">5</h3>
                  <small class="text-muted fw-medium">Bidang</small>
                </div>
                <div class="stat-box flex-grow-1">
                  <h3 class="fw-bold text-primary mb-0">100+</h3>
                  <small class="text-muted fw-medium">Alumni</small>
                </div>
              </div>
            </div>
            <div class="col-lg-6 text-center">
              <div class="position-relative">
                <img src="../includes/image/poster5.jpeg" alt="Magang" class="img-fluid rounded-4 shadow-lg" style="object-fit: cover; height: 380px; width: 100%; transform: rotate(2deg);">
                <div class="position-absolute top-0 start-0 w-100 h-100 rounded-4" style="background: linear-gradient(45deg, rgba(14,165,233,0.2), transparent); pointer-events: none;"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Posisi Magang -->
        <h4 class="fw-bold mb-4" data-aos="fade-up">Posisi Tersedia</h4>
        <div class="row g-4 mb-5" data-aos="fade-up" data-aos-delay="100">
          <div class="col-md-4">
            <div class="posisi-card">
              <div class="posisi-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
              </div>
              <h5 class="fw-bold mb-2">Web / App Developer</h5>
              <p class="text-muted small mb-0">Fokus pada pengembangan aplikasi e-Gov (PHP, Laravel, React) dan manajemen database skala kota.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="posisi-card">
              <div class="posisi-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
              </div>
              <h5 class="fw-bold mb-2">Network & SysAdmin</h5>
              <p class="text-muted small mb-0">Troubleshooting jaringan, administrasi server Linux, dan memastikan uptime layanan publik.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="posisi-card">
              <div class="posisi-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
              </div>
              <h5 class="fw-bold mb-2">Multimedia & Sosmed</h5>
              <p class="text-muted small mb-0">Desain grafis, produksi video, dan manajemen konten publikasi kanal resmi Pemkot.</p>
            </div>
          </div>
        </div>

        <!-- Bagian Form & Status -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 mt-5" data-aos="fade-up">
          <h4 class="fw-bold mb-3 mb-md-0" style="color: var(--text-dark);">Pendaftaran & Status</h4>
          
          <ul class="nav nav-pills segmented-control" id="magangTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="pengajuan-tab" data-bs-toggle="pill" data-bs-target="#pengajuan" type="button" role="tab">Pengajuan</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="status-tab" data-bs-toggle="pill" data-bs-target="#status" type="button" role="tab">Cek Status</button>
            </li>
          </ul>
        </div>

        <div class="tab-content" id="magangTabsContent">
          
          <!-- TAB 1: PENGAJUAN MAGANG -->
          <div class="tab-pane fade show active" id="pengajuan" role="tabpanel">
            <div class="floating-card" data-aos="fade-up" data-aos-delay="200">
              <form action="#" method="POST" enctype="multipart/form-data">
            <div class="row g-4">
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control" id="nama" placeholder="Nama Lengkap" required>
                  <label for="nama">Nama Lengkap</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control" id="instansi" placeholder="Instansi" required>
                  <label for="instansi">Asal Sekolah / Universitas</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control" id="jurusan" placeholder="Jurusan" required>
                  <label for="jurusan">Jurusan / Program Studi</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <select class="form-select" id="posisi" required>
                    <option value="" selected disabled>Pilih Posisi...</option>
                    <option value="developer">Web / App Developer</option>
                    <option value="network">Network / SysAdmin</option>
                    <option value="multimedia">Multimedia & Jurnalistik</option>
                    <option value="admin">Administrasi & Kesekretariatan</option>
                  </select>
                  <label for="posisi">Posisi yang Diminati</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="number" class="form-control" id="durasi" min="1" max="6" placeholder="Durasi" required>
                  <label for="durasi">Durasi Magang (Bulan)</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="date" class="form-control" id="tanggal" required>
                  <label for="tanggal">Rencana Tanggal Mulai</label>
                </div>
              </div>
              
              <div class="col-12 mt-4">
                <label class="form-label fw-bold small text-muted">Surat Pengantar Magang (Wajib - PDF)</label>
                <input class="form-control" type="file" accept=".pdf" required>
              </div>
              
              <div class="col-12 mt-3">
                <label class="form-label fw-bold small text-muted">CV / Portofolio (Opsional - PDF)</label>
                <input class="form-control" type="file" accept=".pdf">
              </div>
            </div>

            <div class="mt-5 text-end">
              <button type="button" class="btn btn-premium" onclick="submitMagang()">
                Kirim Pengajuan
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- TAB 2: STATUS PENGAJUAN -->
      <div class="tab-pane fade" id="status" role="tabpanel">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="floating-card text-center" style="padding: 4rem 2rem;">
              <div class="mb-4 d-inline-flex justify-content-center align-items-center" style="width: 80px; height: 80px; background: #f0f9ff; border-radius: 50%; color: var(--primary);">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
              </div>
              <h3 class="fw-bold mb-3">Lacak Pengajuan Anda</h3>
              <p class="text-muted mb-5">Masukkan Nomor Tiket yang dikirimkan ke email Anda saat mendaftar.</p>
              
              <form class="mx-auto" style="max-width: 500px;">
                <div class="form-floating mb-4">
                  <input type="text" class="form-control form-control-lg" id="tiket" placeholder="Nomor Tiket" required style="border-radius: 16px;">
                  <label for="tiket">Nomor Tiket (Contoh: TKT-12345)</label>
                </div>
                <button type="button" class="btn btn-premium w-100 justify-content-center" onclick="checkStatusMock()" style="padding: 16px;">Cek Status Sekarang</button>
              </form>
            </div>
            
            <div class="info-alert mt-4 mx-auto" style="max-width: 500px;">
              <h5 class="mb-2 d-flex align-items-center gap-2">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                Perhatian
              </h5>
              <p class="mb-0 text-danger" style="opacity: 0.8; font-size: 0.9rem;">
                Pastikan Anda juga mengecek folder <strong>Spam/Junk</strong> jika email balasan dengan nomor tiket tidak muncul di kotak masuk utama Anda.
              </p>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
function submitMagang() {
  const form = document.querySelector('#pengajuan form');
  if (form.checkValidity()) {
    alert("Permohonan magang Anda telah terkirim! Silakan periksa email Anda untuk Nomor Tiket.");
    window.location.reload();
  } else {
    form.reportValidity();
  }
}
function checkStatusMock() {
  alert("Status Pengajuan Magang: Sedang dalam proses peninjauan oleh tim SDM.");
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
