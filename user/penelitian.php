<?php
declare(strict_types=1);

$pageTitle  = 'Pusat Riset & Magang — Diskominfo Kota Bogor';
$activePage = 'penelitian';

require_once __DIR__ . '/../includes/header.php';
?>

<style>
  /* Base Variables */
  :root {
    --bg-color: #f8fafc;
    --card-bg: rgba(255, 255, 255, 0.7);
    --card-border: rgba(255, 255, 255, 0.4);
    --text-main: #0f172a;
    --text-muted: #64748b;
    --accent: #0284c7;
    --hover-glow: rgba(2, 132, 199, 0.15);
  }

  body {
    background-color: var(--bg-color);
    position: relative;
    overflow-x: hidden;
  }
  
  body::after {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 600px;
    background: linear-gradient(180deg, rgba(224, 242, 254, 0.4) 0%, rgba(248, 250, 252, 0) 100%);
    z-index: -1;
    pointer-events: none;
  }

  .title-oversized {
    font-size: clamp(2.2rem, 3.5vw, 3.5rem);
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -0.02em;
    color: #0f172a;
    margin-bottom: 1rem;
  }
  .title-oversized span {
    color: #0ea5e9;
  }
  
  .subtitle-premium {
    font-size: 1.15rem;
    line-height: 1.8;
    color: var(--text-muted);
    font-weight: 400;
    max-width: 90%;
  }

  /* Custom Badge */
  .badge-premium {
    background: #e0f2fe;
    color: #0284c7;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.8rem;
    display: inline-block;
  }

  /* Bento Grid Layout */
  .bento-grid {
    display: flex;
    gap: 1rem;
    margin-top: 2.5rem;
  }

  .bento-card {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 16px;
    padding: 1.5rem 1rem;
    text-decoration: none !important;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .bento-card:hover {
    transform: translateY(-5px);
    border-color: #bae6fd;
    box-shadow: 0 15px 30px rgba(14, 165, 233, 0.08);
  }

  .bento-icon-wrapper {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
  }

  .bento-icon-wrapper svg {
    width: 20px;
    height: 20px;
  }

  .icon-blue { background: #e0f2fe; color: #0284c7; }
  .icon-green { background: #dcfce7; color: #16a34a; }
  .icon-orange { background: #fef3c7; color: #d97706; }

  .bento-title {
    color: var(--text-main);
    font-weight: 800;
    font-size: 1rem;
    margin-bottom: 0.3rem;
  }
  
  .bento-desc {
    color: var(--text-muted);
    font-size: 0.75rem;
    line-height: 1.4;
    margin-bottom: 0;
  }

  /* Premium Image Section */
  .premium-media-container {
    position: relative;
    border-radius: 24px;
    overflow: hidden;
    height: 550px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
  }
  .premium-img-main {
    width: 100%; height: 100%; object-fit: cover;
  }

  /* Workflow Steps */
  .workflow-step {
    text-align: center;
    position: relative;
    padding: 2rem;
    z-index: 2;
  }
  .step-icon {
    width: 80px; height: 80px;
    background: white; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.5rem auto;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    color: var(--accent);
    position: relative;
    z-index: 2;
  }
  .workflow-line {
    position: absolute;
    top: 40px; left: 50%; width: 100%; height: 2px;
    background: dashed 2px #cbd5e1;
    z-index: 1;
  }
  @media (max-width: 991px) { .workflow-line { display: none; } }

  /* Accordion Custom */
  .accordion-premium .accordion-item {
    border: 1px solid rgba(0,0,0,0.05);
    border-radius: 16px !important;
    margin-bottom: 1rem;
    background: #ffffff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    overflow: hidden;
  }
  .accordion-premium .accordion-button {
    background: transparent;
    font-weight: 600;
    color: var(--text-main);
    box-shadow: none;
    padding: 1.5rem;
  }
  .accordion-premium .accordion-button:not(.collapsed) {
    color: var(--accent);
    background: rgba(255,255,255,0.8);
  }
  .accordion-premium .accordion-body {
    padding: 0 1.5rem 1.5rem 1.5rem;
    color: var(--text-muted);
  }
  


  @media (max-width: 991px) {
    .premium-media-container { height: 400px; transform: none; margin-top: 3rem; }
    .premium-media-container:hover { transform: none; }
  }
</style>

<!-- ═══════════ HERO SECTION ═══════════ -->
<section class="section d-flex align-items-center" style="min-height: 90vh; padding-top: 8rem; padding-bottom: 5rem; overflow: hidden;">
  <div class="container position-relative z-1">
    <div class="row align-items-center justify-content-between">
      
      <!-- Bagian Kiri: Typografi & Bento Grid -->
      <div class="col-lg-6 pe-lg-5" data-aos="fade-up" data-aos-duration="1000">
        <div class="mb-4">
          <span class="badge-premium mb-3">Layanan KOMINFO</span>
          <h1 class="title-oversized">Pusat <span>Penelitian, Magang</span><br><span>& Publikasi Jurnal</span></h1>
          <p class="subtitle-premium">
            Diskominfo Kota Bogor memfasilitasi para mahasiswa, peneliti, dan akademisi untuk melaksanakan berbagai kegiatan akademik. Mulai dari pengajuan izin penelitian, program magang profesional (PKL), hingga pengumpulan berkas jurnal atau karya tulis ilmiah Anda secara terintegrasi.<br><br>
            Silakan pilih layanan yang Anda butuhkan di bawah ini.
          </p>
        </div>

        <div class="bento-grid">
          <a href="submit-penelitian.php" class="bento-card">
            <div class="bento-icon-wrapper icon-blue">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><circle cx="10" cy="13" r="2"></circle><line x1="11.4" y1="14.4" x2="15" y2="18"></line></svg>
            </div>
            <h3 class="bento-title">Penelitian</h3>
            <p class="bento-desc">Pengajuan Izin Riset & Data</p>
          </a>
          
          <a href="magang.php" class="bento-card">
            <div class="bento-icon-wrapper icon-green">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
            </div>
            <h3 class="bento-title">Magang</h3>
            <p class="bento-desc">Pendaftaran Program PKL</p>
          </a>

          <a href="daftar-jurnal.php" class="bento-card">
            <div class="bento-icon-wrapper icon-orange">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path><line x1="12" y1="6" x2="16" y2="6"></line><line x1="12" y1="10" x2="16" y2="10"></line></svg>
            </div>
            <h3 class="bento-title">Jurnal</h3>
            <p class="bento-desc">Publikasi Karya Hasil Akhir</p>
          </a>
        </div>
      </div>

      <!-- Bagian Kanan: Static Poster -->
      <div class="col-lg-5 offset-lg-1" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="200">
        <div class="premium-media-container">
          <img src="../includes/image/poster3.jpeg" class="premium-img-main" alt="Poster">
        </div>
      </div>

    </div>
  </div>
</section>


<!-- ═══════════ ALUR KERJA SECTION ═══════════ -->
<section class="section" style="padding: 6rem 0;">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="fw-bold mb-3">Alur Proses Pelaksanaan</h2>
      <p class="text-muted">Langkah mudah untuk memulai magang atau riset Anda di Diskominfo Kota Bogor</p>
    </div>
    
    <div class="row position-relative" data-aos="fade-up" data-aos-delay="100">
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="workflow-step">
          <div class="workflow-line"></div>
          <div class="step-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5c-2.2 0-4 1.8-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
          </div>
          <h5 class="fw-bold mb-2">1. Registrasi</h5>
          <p class="small text-muted mb-0">Isi form pengajuan secara online dengan melampirkan berkas dari Universitas/Sekolah.</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="workflow-step">
          <div class="workflow-line"></div>
          <div class="step-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
          </div>
          <h5 class="fw-bold mb-2">2. Verifikasi</h5>
          <p class="small text-muted mb-0">Tim SDM akan meninjau ketersediaan kuota dan kesesuaian jurusan Anda.</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="workflow-step">
          <div class="workflow-line"></div>
          <div class="step-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          </div>
          <h5 class="fw-bold mb-2">3. Pelaksanaan</h5>
          <p class="small text-muted mb-0">Melaksanakan magang/penelitian sesuai durasi dan arahan mentor pembimbing.</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="workflow-step">
          <div class="step-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
          </div>
          <h5 class="fw-bold mb-2">4. Laporan Akhir</h5>
          <p class="small text-muted mb-0">Mengumpulkan jurnal/laporan akhir ke sistem untuk diarsipkan.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ FAQ SECTION ═══════════ -->
<section class="section position-relative" style="padding: 6rem 0 50vh 0; z-index: 2;">
  <div class="container position-relative z-1">
    <div class="row justify-content-center">
      <div class="col-lg-8" data-aos="fade-up">
        <div class="text-center mb-5">
          <h2 class="fw-bold mb-3">Pertanyaan Umum</h2>
          <p class="text-muted">Informasi yang sering ditanyakan seputar magang dan riset</p>
        </div>

        <div class="accordion accordion-premium" id="faqAccordion">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true">
                Berapa lama durasi magang yang diperbolehkan?
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Durasi magang minimal yang disarankan adalah 1 bulan dan maksimal 6 bulan. Hal ini disesuaikan dengan kebutuhan instansi asal (Sekolah/Universitas) serta ketersediaan kuota pada divisi yang dituju di Diskominfo Kota Bogor.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                Apakah ada kompensasi finansial (gaji) selama magang?
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Sesuai dengan regulasi pemerintah daerah, program PKL/Magang ini bersifat sukarela dan akademik. Oleh karena itu, tidak ada kompensasi berupa gaji bulanan. Namun, peserta akan mendapatkan pengalaman, bimbingan, dan sertifikat resmi.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                Bagaimana cara mengetahui pengajuan saya diterima?
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Anda dapat mengecek status pengajuan pada tab "Cek Status" di halaman Magang menggunakan Nomor Tiket yang dikirim ke email Anda. Jika statusnya "Diterima", akan ada instruksi lebih lanjut mengenai tanggal kehadiran pertama.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Custom Cursor Effect Script -->
<script>
  document.querySelectorAll('.bento-card').forEach(card => {
    card.addEventListener('mousemove', e => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      card.style.setProperty('--mouse-x', `${x}px`);
      card.style.setProperty('--mouse-y', `${y}px`);
    });
  });
</script>
<style>
  .bento-card::after {
    content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0;
    background: radial-gradient(400px circle at var(--mouse-x) var(--mouse-y), rgba(255,255,255,0.4), transparent 40%);
    transition: opacity 0.3s ease; z-index: 0; pointer-events: none;
  }
  .bento-card:hover::after { opacity: 1; }
  .bento-card > * { position: relative; z-index: 2; }
</style>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
