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
  
  body::before {
    content: '';
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background-image: url('../includes/image/image.png');
    background-size: cover;
    background-position: center bottom;
    z-index: -2;
    opacity: 0.9;
  }

  body::after {
    content: '';
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background-image: 
      radial-gradient(at 0% 0%, rgba(186, 230, 253, 0.8) 0px, transparent 50%),
      radial-gradient(at 100% 0%, rgba(167, 243, 208, 0.6) 0px, transparent 50%),
      radial-gradient(at 100% 100%, rgba(224, 231, 255, 0.9) 0px, transparent 50%);
    z-index: -1;
    pointer-events: none;
  }

  /* Typography */
  .title-oversized {
    font-size: clamp(2.5rem, 4vw, 4.5rem);
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.04em;
    background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 1.5rem;
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
    background: rgba(224, 242, 254, 0.8);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(186, 230, 253, 0.5);
    color: var(--accent);
    padding: 0.5rem 1.25rem;
    border-radius: 100px;
    font-weight: 600;
    font-size: 0.85rem;
    display: inline-block;
    box-shadow: 0 4px 15px rgba(2, 132, 199, 0.08);
  }

  /* Bento Grid Layout */
  .bento-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1.5rem;
    margin-top: 3rem;
  }

  .bento-card {
    background: var(--card-bg);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--card-border);
    border-radius: 24px;
    padding: 2rem;
    text-decoration: none !important;
    position: relative;
    overflow: hidden;
    transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
    box-shadow: 0 10px 30px rgba(0,0,0,0.02), inset 0 1px 0 rgba(255,255,255,0.8);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 220px;
    z-index: 1;
  }

  .bento-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: radial-gradient(circle at top right, var(--hover-glow), transparent 60%);
    opacity: 0;
    transition: opacity 0.5s ease;
    z-index: -1;
  }

  .bento-card:hover {
    transform: translateY(-8px) scale(1.02);
    border-color: rgba(2, 132, 199, 0.3);
    box-shadow: 0 25px 50px rgba(2, 132, 199, 0.1), inset 0 1px 0 rgba(255,255,255,0.8);
  }

  .bento-card:hover::before { opacity: 1; }

  .bento-icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    transition: all 0.5s ease;
    background: white;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
  }

  .icon-blue { color: #0284c7; }
  .icon-green { color: #16a34a; }
  .icon-orange { color: #d97706; }

  .bento-card:hover .bento-icon-wrapper {
    transform: scale(1.1) rotate(-5deg);
  }

  .bento-title {
    color: var(--text-main);
    font-weight: 700;
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
    transition: color 0.3s ease;
  }
  
  .bento-desc {
    color: var(--text-muted);
    font-size: 0.85rem;
    line-height: 1.5;
    margin-bottom: 0;
  }

  .bento-arrow {
    position: absolute;
    bottom: 2rem;
    right: 2rem;
    width: 35px;
    height: 35px;
    background: #0f172a;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transform: translate(-10px, 10px);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  }

  .bento-card:hover .bento-arrow {
    opacity: 1;
    transform: translate(0, 0);
  }

  /* Premium Image Carousel Section */
  .premium-media-container {
    position: relative;
    border-radius: 32px;
    overflow: hidden;
    height: 600px;
    box-shadow: 0 30px 60px rgba(0,0,0,0.12);
    transform: perspective(1000px) rotateY(-5deg);
    transition: transform 0.8s cubic-bezier(0.23, 1, 0.32, 1);
  }
  .premium-media-container:hover { transform: perspective(1000px) rotateY(0deg) scale(1.02); }

  .carousel-item { height: 100%; background: #000; }
  .premium-img-blur {
    position: absolute; top: -15%; left: -15%; width: 130%; height: 130%;
    object-fit: cover; filter: blur(40px) brightness(0.5); z-index: 1;
  }
  .premium-img-main {
    position: relative; width: 100%; height: 100%; object-fit: contain;
    z-index: 2; padding: 1rem; animation: scaleIn 1s cubic-bezier(0.23, 1, 0.32, 1) forwards;
  }
  @keyframes scaleIn {
    0% { transform: scale(1.05); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
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
    background: rgba(255,255,255,0.6);
    backdrop-filter: blur(10px);
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
  
  /* Marquee */
  .marquee-wrapper {
    overflow: hidden;
    white-space: nowrap;
    padding: 2rem 0;
    background: rgba(255,255,255,0.5);
    border-top: 1px solid rgba(0,0,0,0.05);
    border-bottom: 1px solid rgba(0,0,0,0.05);
  }
  .marquee-content {
    display: inline-block;
    animation: marquee 30s linear infinite;
  }
  .marquee-item {
    display: inline-block;
    font-size: 1.5rem;
    font-weight: 800;
    color: #cbd5e1;
    margin: 0 3rem;
    text-transform: uppercase;
    letter-spacing: 2px;
  }
  @keyframes marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
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
      
      <!-- Bagian Kiri: Typografi Awwwards & Bento Grid -->
      <div class="col-lg-6 pe-lg-5" data-aos="fade-up" data-aos-duration="1000">
        <div class="mb-4">
          <span class="badge-premium mb-4">✨ Layanan Akademik Terpadu</span>
          <h1 class="title-oversized">Eksplorasi,<br>Penelitian &<br>Publikasi.</h1>
          <p class="subtitle-premium">
            Platform terpadu Diskominfo Kota Bogor untuk memfasilitasi riset, program magang profesional, dan akses jurnal ilmiah. Bergabunglah bersama kami menciptakan inovasi digital.
          </p>
        </div>

        <div class="bento-grid">
          <a href="submit-penelitian.php" class="bento-card">
            <div>
              <div class="bento-icon-wrapper icon-blue">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><circle cx="10" cy="13" r="2"></circle><line x1="11.4" y1="14.4" x2="15" y2="18"></line></svg>
              </div>
              <h3 class="bento-title">Penelitian</h3>
              <p class="bento-desc">Ajukan izin riset dan akses data terbuka.</p>
            </div>
            <div class="bento-arrow">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </a>
          
          <a href="magang.php" class="bento-card">
            <div>
              <div class="bento-icon-wrapper icon-green">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
              </div>
              <h3 class="bento-title">Magang</h3>
              <p class="bento-desc">Program PKL dan pengembangan karir.</p>
            </div>
            <div class="bento-arrow">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </a>

          <a href="daftar-jurnal.php" class="bento-card">
            <div>
              <div class="bento-icon-wrapper icon-orange">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path><line x1="12" y1="6" x2="16" y2="6"></line><line x1="12" y1="10" x2="16" y2="10"></line></svg>
              </div>
              <h3 class="bento-title">Jurnal</h3>
              <p class="bento-desc">Publikasi laporan hasil akhir penelitian.</p>
            </div>
            <div class="bento-arrow">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </a>
        </div>
      </div>

      <!-- Bagian Kanan: Premium Media Showcase -->
      <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="200">
        <div class="premium-media-container">
          <div id="premiumCarousel" class="carousel slide w-100 h-100" data-bs-ride="carousel">
            <div class="carousel-inner h-100">
              <div class="carousel-item active">
                <img src="../includes/image/poster1.jpeg" class="premium-img-blur" alt="Blur">
                <img src="../includes/image/poster1.jpeg" class="premium-img-main" alt="Poster">
              </div>
              <div class="carousel-item">
                <img src="../includes/image/poster2.jpeg" class="premium-img-blur" alt="Blur">
                <img src="../includes/image/poster2.jpeg" class="premium-img-main" alt="Poster">
              </div>
              <div class="carousel-item">
                <img src="../includes/image/poster3.jpeg" class="premium-img-blur" alt="Blur">
                <img src="../includes/image/poster3.jpeg" class="premium-img-main" alt="Poster">
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ═══════════ MARQUEE MITRA SECTION ═══════════ -->
<div class="marquee-wrapper mt-5">
  <div class="marquee-content">
    <!-- Diulang 2x agar animasi smooth tak terputus -->
    <span class="marquee-item">Universitas Indonesia</span>
    <span class="marquee-item">Institut Pertanian Bogor</span>
    <span class="marquee-item">Universitas Pakuan</span>
    <span class="marquee-item">Telkom University</span>
    <span class="marquee-item">Universitas Terbuka</span>
    <span class="marquee-item">Universitas Indonesia</span>
    <span class="marquee-item">Institut Pertanian Bogor</span>
    <span class="marquee-item">Universitas Pakuan</span>
    <span class="marquee-item">Telkom University</span>
    <span class="marquee-item">Universitas Terbuka</span>
  </div>
</div>

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
