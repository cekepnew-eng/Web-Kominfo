<?php
declare(strict_types=1);

$pageTitle  = 'Informasi Magang (PKL) — Diskominfo Kota Bogor';
$activePage = 'magang';

require_once __DIR__ . '/../includes/header.php';
?>

<style>
  .custom-nav-pills .nav-link {
    color: #475569;
    background-color: #fff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.2s ease;
  }
  .custom-nav-pills .nav-link:hover {
    border-color: #94a3b8;
    background-color: #f8fafc;
  }
  .custom-nav-pills .nav-link.active {
    color: #fff;
    background-color: #0ea5e9;
    border-color: #0ea5e9;
  }
  .info-box {
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 24px;
  }
  .info-box h5 {
    color: #dc2626; /* Red color for warning/important */
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 1rem;
  }
  .info-box ol {
    padding-left: 1rem;
    color: #475569;
    font-size: 0.9rem;
    line-height: 1.8;
  }
  .info-box ol li strong {
    color: #1e293b;
  }
  .hover-card { transition: all 0.3s ease; }
  .hover-card:hover { background-color: #fff !important; box-shadow: 0 5px 15px rgba(14, 165, 233, 0.15) !important; border-color: #0ea5e9 !important; }
</style>

<!-- ═══════════ KONTEN UTAMA ═══════════ -->
<section class="section" style="padding-top: 8rem; padding-bottom: 4rem;">
  <div class="container mt-2">
    
    <div class="mb-4">
      <a href="penelitian.php" class="btn btn-light border fw-bold text-secondary rounded-3" style="font-size: 0.9rem;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Kembali
      </a>
    </div>

    <!-- TABS -->
    <ul class="nav nav-pills gap-3 mb-5 custom-nav-pills" id="magangTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pengajuan-tab" data-bs-toggle="pill" data-bs-target="#pengajuan" type="button" role="tab">Pengajuan Magang</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="status-tab" data-bs-toggle="pill" data-bs-target="#status" type="button" role="tab">Status Pengajuan</button>
      </li>
    </ul>

    <div class="tab-content" id="magangTabsContent">
      
      <!-- TAB 1: PENGAJUAN MAGANG -->
      <div class="tab-pane fade show active" id="pengajuan" role="tabpanel">
        
        <!-- Info Singkat Magang -->
        <div class="row align-items-center mb-5 mt-3">
          <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-right">
            <img src="../includes/image/poster5.jpeg" alt="Magang Diskominfo" class="img-fluid rounded-4 shadow-lg" style="object-fit: cover; width: 100%; height: 350px; border: 4px solid #fff;">
          </div>
          <div class="col-md-6" data-aos="fade-left">
            <h3 class="mb-3 fw-bold" style="color: #0369a1;">Tentang Program Magang</h3>
            <p class="text-secondary" style="line-height: 1.8;">
              Diskominfo Kota Bogor membuka kesempatan bagi siswa SMK maupun Mahasiswa (D3/S1) untuk melaksanakan Praktik Kerja Lapangan (PKL) / Magang. Program ini dirancang untuk memberikan eksposur terhadap budaya kerja profesional, pemecahan masalah nyata, dan pengembangan kompetensi di bidang IT, komunikasi, dan administrasi.
            </p>
            <div class="d-flex align-items-center gap-3 mt-4">
              <div class="bg-light p-3 rounded text-center border" style="width: 100px;">
                <h4 class="fw-bold mb-0" style="color: #0ea5e9;">3+</h4>
                <small class="text-muted">Bulan</small>
              </div>
              <div class="bg-light p-3 rounded text-center border" style="width: 100px;">
                <h4 class="fw-bold mb-0" style="color: #0ea5e9;">5</h4>
                <small class="text-muted">Bidang</small>
              </div>
              <div class="bg-light p-3 rounded text-center border" style="width: 100px;">
                <h4 class="fw-bold mb-0" style="color: #0ea5e9;">100+</h4>
                <small class="text-muted">Alumni</small>
              </div>
            </div>
          </div>
        </div>

        <div class="card shadow-sm border-0 mb-5" style="border-radius: 1rem; overflow: hidden;" data-aos="fade-up">
          <div class="card-body p-4 p-md-5">
            <h4 class="mb-4 text-center fw-bold text-dark">Posisi Magang yang Tersedia</h4>
            
            <div class="row g-4 mb-4">
              <div class="col-md-4">
                <div class="p-4 border rounded-3 h-100 bg-light hover-card">
                  <h6 class="fw-bold mb-2" style="color: #0ea5e9;">Web / App Developer</h6>
                  <p class="small text-secondary mb-0">Membantu pengembangan dan pemeliharaan aplikasi e-Government milik Pemkot Bogor.</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="p-4 border rounded-3 h-100 bg-light hover-card">
                  <h6 class="fw-bold mb-2" style="color: #0ea5e9;">Network / SysAdmin</h6>
                  <p class="small text-secondary mb-0">Terlibat dalam pengelolaan jaringan, server, dan penanganan troubleshooting infrastruktur.</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="p-4 border rounded-3 h-100 bg-light hover-card">
                  <h6 class="fw-bold mb-2" style="color: #0ea5e9;">Multimedia & Jurnalistik</h6>
                  <p class="small text-secondary mb-0">Membuat desain grafis, video liputan, artikel rilis berita, dan pengelolaan media sosial.</p>
                </div>
              </div>
            </div>

            <hr class="my-5" style="opacity: 0.1;">

            <h4 class="mb-4 fw-bold">Formulir Pendaftaran Magang</h4>
            
            <form action="#" method="POST" enctype="multipart/form-data">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Nama Lengkap</label>
                  <input type="text" class="form-control bg-light" placeholder="Nama lengkap" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Asal Sekolah / Universitas</label>
                  <input type="text" class="form-control bg-light" placeholder="Instansi" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Jurusan / Program Studi</label>
                  <input type="text" class="form-control bg-light" placeholder="Contoh: Rekayasa Perangkat Lunak" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Posisi yang Diminati</label>
                  <select class="form-select bg-light" required>
                    <option value="" selected disabled>Pilih Posisi...</option>
                    <option value="developer">Web / App Developer</option>
                    <option value="network">Network / SysAdmin</option>
                    <option value="multimedia">Multimedia & Jurnalistik</option>
                    <option value="admin">Administrasi & Kesekretariatan</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Durasi Magang (Bulan)</label>
                  <input type="number" class="form-control bg-light" min="1" max="6" placeholder="Berapa bulan?" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Rencana Tanggal Mulai</label>
                  <input type="date" class="form-control bg-light" required>
                </div>
                
                <div class="col-12 mt-4">
                  <label class="form-label fw-semibold">Surat Pengantar Magang (Wajib - PDF)</label>
                  <input class="form-control bg-light" type="file" accept=".pdf" required>
                  <div class="form-text">Surat resmi dari Kampus atau Sekolah yang ditujukan ke Kepala Dinas.</div>
                </div>
                
                <div class="col-12 mb-3">
                  <label class="form-label fw-semibold">CV / Portofolio (Opsional - PDF)</label>
                  <input class="form-control bg-light" type="file" accept=".pdf">
                </div>
              </div>

              <div class="mt-4">
                <button type="button" class="btn btn-primary px-5 py-2 fw-bold" style="background-color: #0ea5e9; border: none; border-radius: 6px;" onclick="submitMagang()">Submit Pengajuan</button>
              </div>
            </form>

          </div>
        </div>
      </div>

      <!-- TAB 2: STATUS PENGAJUAN -->
      <div class="tab-pane fade" id="status" role="tabpanel">
        <h4 class="fw-bold mb-4">Status Pengajuan Magang</h4>
        
        <div class="row g-5">
          <!-- Kolom Form (Kiri) -->
          <div class="col-lg-7">
            <form>
              <div class="mb-4">
                <label class="form-label fw-bold text-secondary small">Masukkan Nomor Tiket</label>
                <input type="text" class="form-control form-control-lg bg-light" placeholder="Contoh: TKT-12345" required>
              </div>
              <button type="button" class="btn btn-primary px-4 py-2 fw-bold" style="background-color: #0ea5e9; border: none; border-radius: 6px;" onclick="checkStatusMock()">Verifikasi</button>
            </form>
          </div>

          <!-- Kolom Info (Kanan) -->
          <div class="col-lg-5">
            <div class="info-box">
              <h5>Informasi Penting!</h5>
              <ol>
                <li>Masukkan <strong>Nomor Tiket</strong> yang didapatkan saat melakukan permohonan magang yang dikirimkan ke alamat email anda.</li>
                <li>Jika di inbox tidak ditemukan email balasan terkait nomor tiket, silahkan cek folder spam pada email anda.</li>
              </ol>
              
              <div class="text-center mt-4">
                <!-- Illustration Image Mockup (Using a relatable existing image) -->
                <img src="../includes/image/poster4.jpeg" alt="Ilustrasi Magang" class="img-fluid rounded-4 shadow-sm" style="max-height: 200px; object-fit: cover;">
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
