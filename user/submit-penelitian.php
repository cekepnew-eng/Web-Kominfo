<?php
declare(strict_types=1);

$pageTitle  = 'Pengajuan Penelitian — Diskominfo Kota Bogor';
$activePage = 'penelitian';

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
    position: relative;
    overflow-x: hidden;
  }
  
  body::after {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 750px;
    background: linear-gradient(180deg, #e0f2fe 0%, #f8fafc 100%);
    z-index: -1;
    pointer-events: none;
  }


  /* ─── Modern Hero ─── */
  .modern-hero {
    position: relative;
    padding: 130px 0 60px 0;
    z-index: 2;
  }
  .stat-box {
    background: rgba(255, 255, 255, 0.7);
    border: 1px solid rgba(226, 232, 240, 0.8);
    border-radius: 12px;
    padding: 1rem 0;
    text-align: center;
    min-width: 90px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.02);
  }
  .stat-box h3 {
    color: #0ea5e9;
    font-weight: 800;
    margin-bottom: 0.2rem;
    font-size: 1.35rem;
  }
  .stat-box p {
    color: #64748b;
    margin: 0;
    font-size: 0.8rem;
    font-weight: 600;
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

  /* ─── TABS & FORMS ─── */
  .custom-nav-pills {
    display: inline-flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 2rem;
  }
  .custom-nav-pills .nav-link {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    color: #64748b;
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.2s ease;
  }
  .custom-nav-pills .nav-link:hover {
    background-color: #f8fafc;
    border-color: #cbd5e1;
  }
  .custom-nav-pills .nav-link.active {
    color: #ffffff;
    background-color: #0ea5e9;
    border-color: #0ea5e9;
    box-shadow: 0 4px 10px rgba(14, 165, 233, 0.2);
  }

  .form-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 3rem;
    box-shadow: 0 10px 40px rgba(0,0,0,0.05);
    position: relative;
    z-index: 2;
  }

  .info-box {
    background: #fffdf5; 
    border: 1px solid #fde68a; 
    border-radius: 12px;
    padding: 2rem;
  }
  .info-box h5 {
    color: #ea580c; 
    font-weight: 800;
    margin-bottom: 1.5rem;
    font-size: 1.1rem;
  }
  .info-box ol {
    padding-left: 1rem;
    color: #64748b;
    font-size: 0.9rem;
    line-height: 1.8;
  }
  .info-box ol li { margin-bottom: 0.75rem; }
  .info-box ol li strong {
    color: #334155;
  }
  .form-label {
    font-weight: 700;
    color: #334155;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
  }
  .form-control, .form-select {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 0.85rem 1rem;
    color: #334155;
    transition: all 0.2s ease;
  }
  .form-control:focus, .form-select:focus {
    background: #ffffff;
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
  }
  
  .btn-submit {
    background: #0ea5e9;
    border: none;
    color: white;
    font-weight: 600;
    padding: 12px 24px;
    border-radius: 8px;
    transition: all 0.2s ease;
  }
  .btn-submit:hover {
    background: #0284c7;
  }
</style>

<!-- ─── CENTERED HERO ─── -->
<a href="penelitian.php" class="btn-back-sticky" title="Kembali ke Profil">
  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
</a>

<section class="modern-hero">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-5 text-center" data-aos="fade-right">
        <img src="../includes/image/research_illustration.png" alt="Portal Penelitian" class="img-fluid" style="max-height: 400px; object-fit: contain;">
      </div>
      <div class="col-lg-7" data-aos="fade-left">
        <h1 class="fw-bold mb-3" style="color: #0ea5e9; font-size: 2.2rem;">Portal Pengajuan Penelitian</h1>
        <p class="mb-4" style="color: #64748b; font-size: 1.05rem; line-height: 1.8;">
          Diskominfo Kota Bogor membuka kesempatan bagi akademisi, peneliti, dan mahasiswa untuk melakukan penelitian di lingkungan Diskominfo. Ajukan permohonan Anda secara online, pantau status, dan unggah hasil penelitian melalui portal ini.
        </p>
        <div class="d-flex gap-3">
          <div class="stat-box">
            <h3>4</h3>
            <p>Bidang</p>
          </div>
          <div class="stat-box">
            <h3>50+</h3>
            <p>Penelitian</p>
          </div>
          <div class="stat-box">
            <h3>100%</h3>
            <p>Digital</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ─── KONTEN UTAMA ─── -->
<section class="section position-relative" style="padding-bottom: 20vh; z-index: 2; margin-top: -2rem;">
  <div class="container position-relative z-1">

    <div class="form-card" data-aos="fade-up">
      <!-- TABS -->
      <div class="mb-4">
        <ul class="nav nav-pills custom-nav-pills" id="penelitianTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pengajuan-tab" data-bs-toggle="pill" data-bs-target="#pengajuan" type="button" role="tab">Pengajuan Permohonan</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="status-tab" data-bs-toggle="pill" data-bs-target="#status" type="button" role="tab">Cek Status</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="unggah-tab" data-bs-toggle="pill" data-bs-target="#unggah" type="button" role="tab">Unggah Jurnal</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="status-jurnal-tab" data-bs-toggle="pill" data-bs-target="#status-jurnal" type="button" role="tab">Status Jurnal</button>
          </li>
        </ul>
      </div>

      <div class="tab-content" id="penelitianTabsContent">
        
        <!-- TAB 1: PENGAJUAN PERMOHONAN -->
        <div class="tab-pane fade show active" id="pengajuan" role="tabpanel">
          
          <div class="row g-5 align-items-start">
            <!-- Kolom Form (Kiri) -->
            <div class="col-lg-8">
              <h4 class="fw-bold mb-4" style="font-size: 1.5rem; color: #1e293b;">Formulir Pengajuan Permohonan Penelitian</h4>
              <form action="#" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="mb-4">
                  <label class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" required>
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <label class="form-label">No Telepon / WhatsApp</label>
                    <input type="tel" class="form-control" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Alamat Email</label>
                    <input type="email" class="form-control" required>
                  </div>
                </div>

                <div class="mb-4">
                  <label class="form-label">Nama Instansi / Universitas</label>
                  <input type="text" class="form-control" required>
                </div>

                <div class="mb-4">
                  <label class="form-label">Judul Penelitian</label>
                  <input type="text" class="form-control" required>
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <label class="form-label">Lokasi Penelitian</label>
                    <select class="form-select" required>
                      <option value="" selected disabled>-- Pilih Lokasi --</option>
                      <option value="Diskominfo">Diskominfo Kota Bogor</option>
                      <option value="Kecamatan">Kecamatan/Kelurahan</option>
                      <option value="Publik">Ruang Publik / Masyarakat</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Bidang Tujuan</label>
                    <select class="form-select" required>
                      <option value="" selected disabled>-- Pilih Bidang --</option>
                      <option value="Aplikasi">Aplikasi / e-Government</option>
                      <option value="IKP">Informasi & Komunikasi Publik</option>
                      <option value="Infrastruktur">Infrastruktur & Jaringan</option>
                      <option value="Statistik">Statistik Sektoral</option>
                    </select>
                  </div>
                </div>

                <div class="row g-3 mb-5">
                  <div class="col-md-6">
                    <label class="form-label">Surat Penelitian (PDF)</label>
                    <input type="file" class="form-control" accept=".pdf" required>
                    <div class="form-text mt-1" style="font-size: 0.75rem;">Maks 2MB, format .pdf</div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Surat Kesbangpol (PDF)</label>
                    <input type="file" class="form-control" accept=".pdf">
                    <div class="form-text mt-1" style="font-size: 0.75rem;">Maks 2MB, format .pdf</div>
                  </div>
                </div>

                <div class="mt-4">
                  <button type="button" class="btn-submit" onclick="submitMock('pengajuan')">
                    Submit Pengajuan
                  </button>
                </div>
              </form>
            </div>

            <!-- Kolom Info (Kanan) -->
            <div class="col-lg-4">
            <div class="info-box sticky-top" style="top: 100px;">
              <h5>Informasi Penting!</h5>
              <ol>
                <li>Pastikan data yang Anda kirimkan <strong>Valid</strong>.</li>
                <li><strong>Nomor Tiket</strong> pengajuan akan dikirimkan melalui <strong>email Anda</strong>.</li>
                <li>Nomor Tiket dapat digunakan untuk <strong>memantau status permohonan</strong>.</li>
                <li>Jika disetujui, <strong>surat jawaban</strong> akan dikirim via email.</li>
              </ol>
              
              <div class="text-center mt-4">
                <img src="../includes/image/research_illustration.png" alt="Ilustrasi Penelitian" class="img-fluid rounded-3" style="max-height: 220px; width: 100%; object-fit: contain;">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- TAB 2: STATUS PENGAJUAN -->
      <div class="tab-pane fade" id="status" role="tabpanel">
        <div class="row">
          <div class="col-md-8">
            <div>
              <div class="mb-4 d-inline-flex justify-content-center align-items-center" style="width: 72px; height: 72px; background: #e0f2fe; border-radius: 50%; color: var(--primary);">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
              </div>
              <h4 class="fw-bold mb-3">Lacak Pengajuan Penelitian</h4>
              <p class="text-secondary mb-4">Masukkan Nomor Tiket yang telah dikirimkan ke email Anda untuk mengetahui apakah izin penelitian Anda sudah diterbitkan.</p>
              
              <form style="max-width: 400px;">
                <div class="mb-4">
                  <input type="text" class="form-control form-control-lg fw-bold" placeholder="TKT-XXXXX" required style="letter-spacing: 2px;">
                </div>
                <button type="button" class="btn-submit" onclick="checkStatusMock()">Cek Status</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- TAB 3: UNGGAH JURNAL -->
      <div class="tab-pane fade" id="unggah" role="tabpanel">
        <div class="row">
          <div class="col-md-8">
            <div>
              <h4 class="fw-bold mb-4">Unggah Laporan Akhir / Jurnal</h4>
              <p class="text-muted mb-5">Sesuai peraturan, Anda wajib menyerahkan laporan hasil akhir penelitian setelah riset selesai dilakukan.</p>
              <form>
                <div class="row g-4">
                  <div class="col-md-12">
                    <label class="form-label">Nomor Tiket Pengajuan</label>
                    <input type="text" class="form-control" placeholder="Masukkan nomor tiket Anda" required>
                  </div>
                  <div class="col-md-12">
                    <label class="form-label">Link Publikasi Jurnal (Opsional)</label>
                    <input type="url" class="form-control" placeholder="https://jurnal.universitas.ac.id/...">
                  </div>
                  <div class="col-md-12">
                    <label class="form-label">File Dokumen Final / Jurnal (PDF)</label>
                    <input type="file" class="form-control" style="padding: 1.5rem 1rem; border-style: dashed;" accept=".pdf" required>
                    <div class="form-text mt-2">Format dokumen PDF (Maks 10MB).</div>
                  </div>
                </div>
                
                <div class="mt-4">
                  <button type="button" class="btn-submit" onclick="submitMock('jurnal')">Unggah Dokumen</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- TAB 4: STATUS JURNAL -->
      <div class="tab-pane fade" id="status-jurnal" role="tabpanel">
        <div class="row">
          <div class="col-md-8">
            <div>
              <div class="mb-4 d-inline-flex justify-content-center align-items-center" style="width: 72px; height: 72px; background: #e0f2fe; border-radius: 50%; color: var(--primary);">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
              </div>
              <h4 class="fw-bold mb-3">Status Verifikasi Laporan</h4>
              <p class="text-secondary mb-4">Pastikan dokumen akhir Anda telah diverifikasi dan diterima dengan baik oleh tim Diskominfo Kota Bogor.</p>
              
              <form style="max-width: 400px;">
                <div class="mb-4">
                  <input type="text" class="form-control form-control-lg fw-bold" placeholder="Nomor Tiket" required style="letter-spacing: 2px;">
                </div>
                <button type="button" class="btn-submit" onclick="checkStatusJurnalMock()">Lihat Status</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div> <!-- END FORM CARD -->
  </div>
</section>

<script>
function submitMock(type) {
  alert(type === 'pengajuan' 
    ? "Pengajuan berhasil dikirim! Silakan periksa email Anda untuk Nomor Tiket."
    : "Jurnal berhasil diunggah! Terima kasih telah melaporkan hasil penelitian Anda.");
  window.location.reload();
}
function checkStatusMock() {
  alert("Status Pengajuan: Sedang dalam proses verifikasi (Pending).");
}
function checkStatusJurnalMock() {
  alert("Status Jurnal: Menunggu peninjauan admin.");
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
