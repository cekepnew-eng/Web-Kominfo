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
  .blob-3 { bottom: 60%; left: 15%; width: 600px; height: 600px; background: #e0e7ff; animation-delay: -6s; }
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
    padding: 120px 0 80px 0;
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
  .hero-badge-dot {
    width: 8px; height: 8px; background: #10b981; border-radius: 50%;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    animation: pulse 2s infinite;
  }
  @keyframes pulse { 
    0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); } 
    70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); } 
    100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); } 
  }
  .modern-hero h1 {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    color: var(--text);
    letter-spacing: -1.5px;
    margin-bottom: 24px;
    line-height: 1.1;
  }
  .modern-hero h1 span {
    background: linear-gradient(135deg, #0ea5e9, #6366f1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  .modern-hero p {
    font-size: 1.1rem;
    color: var(--text-muted);
    max-width: 600px;
    margin: 0 auto 40px;
    line-height: 1.7;
  }

  /* ─── TABS ─── */
  .custom-nav-pills {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(16px);
    padding: 8px;
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.8);
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    display: inline-flex;
    flex-wrap: wrap;
    justify-content: center;
    margin: 0 auto;
  }
  .custom-nav-pills .nav-link {
    color: var(--text-muted);
    background-color: transparent;
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
  }
  .custom-nav-pills .nav-link:hover {
    background-color: rgba(255,255,255,0.8);
    color: var(--text);
  }
  .custom-nav-pills .nav-link.active {
    color: var(--primary-dark);
    background-color: #ffffff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
  }

  /* ─── Rich Cards ─── */
  .posisi-card {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.6);
    border-radius: 24px;
    padding: 2.5rem;
    height: 100%;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    text-align: left;
  }
  .posisi-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 5px;
    background: linear-gradient(90deg, #0ea5e9, #3b82f6);
    opacity: 0;
    transition: opacity 0.4s;
  }
  .posisi-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(14, 165, 233, 0.12);
    background: rgba(255, 255, 255, 0.95);
    border-color: #bae6fd;
  }
  .posisi-card:hover::before { opacity: 1; }
  .posisi-icon {
    width: 64px; height: 64px;
    background: linear-gradient(135deg, #e0f2fe, #bae6fd);
    color: var(--primary-dark);
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1.5rem;
    box-shadow: inset 0 2px 4px rgba(255,255,255,0.8);
  }

  .floating-card {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 3rem;
    box-shadow: 0 20px 50px rgba(0,0,0,0.05);
    border: 1px solid rgba(255,255,255,0.8);
    position: relative;
    z-index: 2;
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
    text-decoration: none;
  }
  .btn-premium:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(14, 165, 233, 0.4);
    color: white;
  }
  .btn-outline-premium {
    background: rgba(255,255,255,0.8);
    backdrop-filter: blur(10px);
    border: 2px solid #e0f2fe;
    color: var(--primary-dark);
    font-weight: 700;
    padding: 12px 30px;
    border-radius: 100px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
  }
  .btn-outline-premium:hover {
    background: #e0f2fe;
    border-color: #bae6fd;
    transform: translateY(-3px);
  }

  .hero-img-wrap {
    position: relative;
    max-width: 900px;
    margin: 40px auto 0;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0,0,0,0.15);
    border: 8px solid rgba(255,255,255,0.8);
  }
  .hero-img-wrap img {
    width: 100%;
    height: 450px;
    object-fit: cover;
  }
</style>

<!-- ─── Abstract Shapes ─── -->
<div class="shape-blob blob-1"></div>
<div class="shape-blob blob-2"></div>
<div class="shape-blob blob-3"></div>
<div class="pattern-dots"></div>

<!-- ─── CENTERED HERO ─── -->
<div class="modern-hero">
  <div class="container" data-aos="fade-up">
    <div class="text-start mb-4">
      <a href="penelitian.php" class="btn-outline-premium" style="padding: 8px 20px; font-size: 0.85rem;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Kembali ke Profil
      </a>
    </div>
    
    <div class="hero-badge">
      <div class="hero-badge-dot"></div>
      Program Magang Batch 2026
    </div>
    
    <h1>Program Magang <span>Profesional</span></h1>
    <p>Bangun karier masa depan Anda bersama Diskominfo Kota Bogor. Dapatkan pengalaman nyata dalam mengembangkan ekosistem digital cerdas berskala kota.</p>
    
    <div class="d-flex flex-wrap justify-content-center gap-3">
      <a href="#form-daftar" class="btn btn-premium">Daftar Sekarang <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
      <a href="#posisi" class="btn btn-outline-premium">Lihat Posisi Tersedia</a>
    </div>

    <div class="hero-img-wrap" data-aos="zoom-in" data-aos-delay="200">
      <img src="../includes/image/poster5.jpeg" alt="Magang Diskominfo">
    </div>
  </div>
</div>

<!-- ─── KONTEN UTAMA ─── -->
<section class="section position-relative" style="padding-top: 4rem; padding-bottom: 6rem; z-index: 2;">
  <div class="container">
    
    <!-- Posisi Magang -->
    <div id="posisi" class="text-center mb-5" data-aos="fade-up">
      <h2 class="fw-bold mb-2">Posisi Tersedia</h2>
      <p class="text-muted">Pilih bidang yang sesuai dengan passion dan keahlian Anda.</p>
    </div>
    
    <div class="row g-4 mb-5" data-aos="fade-up" data-aos-delay="100">
      <div class="col-md-4">
        <div class="posisi-card">
          <div class="posisi-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
          </div>
          <h5 class="fw-bold mb-3">Web / App Developer</h5>
          <p class="text-muted small mb-0" style="line-height: 1.7;">Fokus pada pengembangan aplikasi e-Government (PHP, Laravel, React) dan manajemen database skala kota yang melayani ratusan ribu warga.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="posisi-card">
          <div class="posisi-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
          </div>
          <h5 class="fw-bold mb-3">Network & SysAdmin</h5>
          <p class="text-muted small mb-0" style="line-height: 1.7;">Troubleshooting infrastruktur jaringan, administrasi server Linux berkinerja tinggi, dan memastikan uptime layanan publik 24/7.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="posisi-card">
          <div class="posisi-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
          </div>
          <h5 class="fw-bold mb-3">Multimedia & Sosmed</h5>
          <p class="text-muted small mb-0" style="line-height: 1.7;">Desain grafis interaktif, produksi video kreatif, dan manajemen konten untuk seluruh kanal publikasi resmi Pemkot Bogor.</p>
        </div>
      </div>
    </div>

    <!-- Bagian Form & Tabs -->
    <div id="form-daftar" class="mt-5" data-aos="fade-up">
      <!-- TABS -->
      <div class="text-center mb-4">
        <ul class="nav nav-pills gap-2 custom-nav-pills" id="magangTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pengajuan-tab" data-bs-toggle="pill" data-bs-target="#pengajuan" type="button" role="tab">Pengajuan Magang</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="status-tab" data-bs-toggle="pill" data-bs-target="#status" type="button" role="tab">Status Pengajuan</button>
          </li>
        </ul>
      </div>

      <div class="tab-content" id="magangTabsContent">
        <!-- TAB 1: PENGAJUAN -->
        <div class="tab-pane fade show active floating-card" id="pengajuan" role="tabpanel">
          <div class="text-center mb-5">
            <h3 class="fw-bold mb-2">Formulir Pendaftaran</h3>
            <p class="text-muted">Isi data diri Anda dengan lengkap dan benar.</p>
          </div>
          <form action="#" method="POST" enctype="multipart/form-data">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label fw-bold small text-muted">Nama Lengkap</label>
                <input type="text" class="form-control form-control-lg" required style="border-radius: 12px; border: 2px solid #e2e8f0; background: rgba(255,255,255,0.8);">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold small text-muted">Asal Sekolah / Universitas</label>
                <input type="text" class="form-control form-control-lg" required style="border-radius: 12px; border: 2px solid #e2e8f0; background: rgba(255,255,255,0.8);">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold small text-muted">Posisi yang Diminati</label>
                <select class="form-select form-select-lg" required style="border-radius: 12px; border: 2px solid #e2e8f0; background: rgba(255,255,255,0.8);">
                  <option value="" selected disabled>Pilih Posisi...</option>
                  <option value="developer">Web / App Developer</option>
                  <option value="network">Network / SysAdmin</option>
                  <option value="multimedia">Multimedia & Sosmed</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold small text-muted">Durasi Magang (Bulan)</label>
                <input type="number" class="form-control form-control-lg" min="1" max="6" required style="border-radius: 12px; border: 2px solid #e2e8f0; background: rgba(255,255,255,0.8);">
              </div>
              <div class="col-12 mt-4">
                <label class="form-label fw-bold small text-muted">Surat Pengantar & CV (PDF)</label>
                <input class="form-control form-control-lg" type="file" accept=".pdf" required style="border-radius: 12px; border: 2px dashed #cbd5e1; background: rgba(255,255,255,0.5); padding: 12px;">
              </div>
            </div>

            <div class="text-center mt-5">
              <button type="button" class="btn btn-premium px-5 py-3" style="font-size: 1.05rem;" onclick="alert('Pengajuan Terkirim!')">
                Kirim Pengajuan
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ms-1"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
              </button>
            </div>
          </form>
        </div>
        
        <!-- TAB 2: STATUS -->
        <div class="tab-pane fade floating-card text-center" id="status" role="tabpanel">
          <div class="mb-4 d-inline-flex justify-content-center align-items-center" style="width: 72px; height: 72px; background: #e0f2fe; border-radius: 50%; color: var(--primary);">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
          </div>
          <h4 class="fw-bold mb-3">Lacak Pengajuan Magang</h4>
          <p class="text-secondary mb-4">Masukkan Nomor Tiket atau Email untuk mengetahui status pengajuan magang Anda.</p>
          
          <form class="mx-auto" style="max-width: 400px;">
            <div class="mb-4">
              <input type="text" class="form-control form-control-lg text-center fw-bold" placeholder="TKT-XXXXX / Email" required style="letter-spacing: 1px; border-radius: 12px; border: 2px solid #e2e8f0; background: rgba(255,255,255,0.8);">
            </div>
            <button type="button" class="btn btn-premium w-100 justify-content-center" onclick="alert('Status: Menunggu Konfirmasi.')">Cek Status</button>
          </form>
        </div>
      </div>
    </div>

  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
