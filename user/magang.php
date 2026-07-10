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
    --primary-light: #e0f2fe;
    --surface: #ffffff;
    --border: #e2e8f0;
    --text: #0f172a;
    --text-muted: #64748b;
    --accent-glow: rgba(14, 165, 233, 0.2);
  }

  body {
    background-color: var(--bg-color);
    position: relative;
    overflow-x: hidden;
    font-family: 'Inter', sans-serif;
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

  .pattern-dots {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(#cbd5e1 1.5px, transparent 1.5px);
    background-size: 32px 32px;
    opacity: 0.3;
    z-index: 0;
    pointer-events: none;
  }

  /* ─── Centered Modern Hero ─── */
  .modern-hero {
    position: relative;
    padding: 100px 0 70px 0;
    z-index: 2;
    text-align: center;
  }
  .hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.6);
    padding: 8px 18px;
    border-radius: 100px;
    color: var(--primary-dark);
    font-weight: 700;
    font-size: 0.9rem;
    box-shadow: 0 4px 20px var(--accent-glow);
    margin-bottom: 28px;
    transition: transform 0.3s ease;
  }
  .hero-badge:hover {
    transform: translateY(-2px);
  }
  .hero-badge-dot {
    width: 10px; height: 10px; background: #10b981; border-radius: 50%;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
    animation: pulse 2s infinite;
  }
  @keyframes pulse { 
    0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); } 
    70% { box-shadow: 0 0 0 12px rgba(16, 185, 129, 0); } 
    100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); } 
  }
  .modern-hero h1 {
    font-size: clamp(2.5rem, 5vw, 4.5rem);
    font-weight: 900;
    color: var(--text);
    letter-spacing: -1.5px;
    margin-bottom: 24px;
    line-height: 1.1;
  }
  .modern-hero h1 span {
    background: linear-gradient(135deg, #0ea5e9, #8b5cf6, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-size: 200% 200%;
    animation: gradientFlow 6s ease infinite;
  }
  @keyframes gradientFlow {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  .modern-hero p {
    font-size: 1.15rem;
    color: var(--text-muted);
    max-width: 650px;
    margin: 0 auto 40px;
    line-height: 1.8;
  }

  /* ─── TABS ─── */
  .custom-nav-pills {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(20px);
    padding: 8px;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.8);
    box-shadow: 0 10px 40px rgba(0,0,0,0.04);
    display: inline-flex;
    flex-wrap: wrap;
    justify-content: center;
    margin: 0 auto;
  }
  .custom-nav-pills .nav-link {
    color: var(--text-muted);
    background-color: transparent;
    border: none;
    border-radius: 14px;
    padding: 12px 28px;
    font-weight: 700;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .custom-nav-pills .nav-link:hover {
    background-color: rgba(255,255,255,0.9);
    color: var(--text);
  }
  .custom-nav-pills .nav-link.active {
    color: var(--primary-dark);
    background-color: #ffffff;
    box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    transform: translateY(-1px);
  }

  /* ─── Rich Cards ─── */
  .posisi-card {
    background: rgba(255, 255, 255, 0.65);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.8);
    border-radius: 32px;
    padding: 3rem 2.5rem;
    height: 100%;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.04);
    text-align: left;
    display: flex;
    flex-direction: column;
  }
  .posisi-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 6px;
    background: linear-gradient(90deg, #0ea5e9, #8b5cf6);
    opacity: 0;
    transition: opacity 0.4s;
  }
  .posisi-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 30px 60px rgba(14, 165, 233, 0.15);
    background: rgba(255, 255, 255, 0.95);
    border-color: #bae6fd;
  }
  .posisi-card:hover::before { opacity: 1; }
  .posisi-icon {
    width: 72px; height: 72px;
    background: linear-gradient(135deg, #f0f9ff, #bae6fd);
    color: var(--primary-dark);
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 2rem;
    box-shadow: inset 0 2px 4px rgba(255,255,255,1), 0 10px 20px rgba(14, 165, 233, 0.1);
    transition: transform 0.4s ease;
  }
  .posisi-card:hover .posisi-icon {
    transform: scale(1.1) rotate(5deg);
  }

  /* ─── Premium Glass Form Container ─── */
  .floating-card {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border-radius: 32px;
    padding: 3.5rem;
    box-shadow: 0 30px 60px rgba(0,0,0,0.06);
    border: 1px solid rgba(255,255,255,1);
    position: relative;
    z-index: 2;
  }

  .info-box {
    background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(241,245,249,0.95) 100%);
    border: 1px solid #e2e8f0;
    border-radius: 24px;
    padding: 2.5rem;
    box-shadow: 0 20px 40px rgba(0,0,0,0.05);
  }
  .info-box h5 {
    color: #ef4444; 
    font-weight: 800;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.2rem;
  }
  .info-box ol {
    padding-left: 1.2rem;
    color: var(--text-muted);
    font-size: 1rem;
    line-height: 1.9;
  }
  .info-box ol li { margin-bottom: 0.5rem; }
  .info-box ol li strong {
    color: var(--text);
  }

  /* ─── Inputs ─── */
  .form-label {
    font-weight: 700;
    color: var(--text-muted);
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
  }
  .form-control, .form-select {
    background: rgba(255,255,255,0.9);
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    padding: 0.85rem 1.2rem;
    font-size: 1rem;
    color: var(--text);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 4px rgba(0,0,0,0.01);
  }
  .form-control:focus, .form-select:focus {
    background: #ffffff;
    border-color: #7dd3fc;
    box-shadow: 0 0 0 5px rgba(14, 165, 233, 0.15);
    transform: translateY(-2px);
  }

  /* ─── Premium Buttons ─── */
  .btn-premium {
    background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%);
    border: none;
    color: white;
    font-weight: 800;
    padding: 16px 36px;
    border-radius: 100px;
    box-shadow: 0 10px 25px var(--accent-glow);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    font-size: 1.05rem;
    letter-spacing: 0.3px;
  }
  .btn-premium:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 20px 40px rgba(14, 165, 233, 0.3);
    color: white;
  }
  .btn-outline-premium {
    background: rgba(255,255,255,0.8);
    backdrop-filter: blur(12px);
    border: 2px solid #bae6fd;
    color: var(--primary-dark);
    font-weight: 800;
    padding: 14px 32px;
    border-radius: 100px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    font-size: 1.05rem;
  }
  .btn-outline-premium:hover {
    background: #e0f2fe;
    border-color: #7dd3fc;
    transform: translateY(-4px);
    box-shadow: 0 15px 30px rgba(14, 165, 233, 0.15);
  }

  .btn-back-sticky {
    position: fixed;
    top: 100px;
    left: 24px;
    width: 56px;
    height: 56px;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    border: 2px solid #e2e8f0;
    color: var(--text);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1050;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
  }
  .btn-back-sticky:hover {
    background: #ffffff;
    border-color: var(--primary);
    color: var(--primary);
    transform: scale(1.1) rotate(-10deg);
    box-shadow: 0 12px 30px var(--accent-glow);
  }
  @media (max-width: 768px) {
    .btn-back-sticky {
      top: 85px;
      left: 15px;
      width: 48px;
      height: 48px;
    }
  }

  .hero-img-wrap {
    position: relative;
    max-width: 1000px;
    margin: 50px auto 0;
    border-radius: 32px;
    overflow: hidden;
    box-shadow: 0 40px 80px rgba(0,0,0,0.15);
    border: 10px solid rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
  }
  .hero-img-wrap img {
    width: 100%;
    height: 500px;
    object-fit: cover;
    transition: transform 0.7s ease;
  }
  .hero-img-wrap:hover img {
    transform: scale(1.05);
  }
</style>

<div class="pattern-dots"></div>

<!-- ─── CENTERED HERO ─── -->
<a href="penelitian.php" class="btn-back-sticky" title="Kembali ke Profil">
  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
</a>

<div class="modern-hero">
  <div class="container" data-aos="fade-up">
    
    <div class="hero-badge">
      <div class="hero-badge-dot"></div>
      Program Magang Batch 2026
    </div>
    
    <h1>Program Magang <span>Profesional</span></h1>
    <p>Bangun karier masa depan Anda bersama Diskominfo Kota Bogor. Dapatkan pengalaman nyata dalam mengembangkan ekosistem digital cerdas berskala kota dengan standar tinggi.</p>
    
    <div class="d-flex flex-wrap justify-content-center gap-4">
      <a href="#form-daftar" class="btn btn-premium">
        Daftar Sekarang 
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
      <a href="#posisi" class="btn btn-outline-premium">
        Lihat Posisi Tersedia
      </a>
    </div>
  </div>
</div>

<!-- ─── KONTEN UTAMA ─── -->
<section class="section position-relative" style="padding-top: 5rem; padding-bottom: 50vh; z-index: 2;">
  <div class="container">
    
    <!-- Posisi Magang -->
    <div id="posisi" class="text-center mb-5 pb-3" data-aos="fade-up">
      <h2 class="fw-bold mb-3" style="font-size: 2.5rem; letter-spacing: -1px;">Posisi Tersedia</h2>
      <p class="text-muted" style="font-size: 1.1rem;">Pilih bidang yang sesuai dengan passion dan keahlian Anda.</p>
    </div>
    
    <div class="row g-5 mb-5 pb-5" data-aos="fade-up" data-aos-delay="100">
      <div class="col-md-4">
        <div class="posisi-card">
          <div class="posisi-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
          </div>
          <h4 class="fw-bold mb-3 text-dark">Web / App Developer</h4>
          <p class="text-muted mb-0" style="line-height: 1.8; font-size: 0.95rem;">Fokus pada pengembangan aplikasi e-Government (PHP, Laravel, React) dan manajemen database skala kota yang melayani ratusan ribu warga.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="posisi-card">
          <div class="posisi-icon" style="background: linear-gradient(135deg, #ecfdf5, #a7f3d0); color: #059669;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
          </div>
          <h4 class="fw-bold mb-3 text-dark">Network & SysAdmin</h4>
          <p class="text-muted mb-0" style="line-height: 1.8; font-size: 0.95rem;">Troubleshooting infrastruktur jaringan, administrasi server Linux berkinerja tinggi, dan memastikan uptime layanan publik 24/7.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="posisi-card">
          <div class="posisi-icon" style="background: linear-gradient(135deg, #fefce8, #fde047); color: #d97706;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
          </div>
          <h4 class="fw-bold mb-3 text-dark">Multimedia & Sosmed</h4>
          <p class="text-muted mb-0" style="line-height: 1.8; font-size: 0.95rem;">Desain grafis interaktif, produksi video kreatif, dan manajemen konten untuk seluruh kanal publikasi resmi Pemkot Bogor.</p>
        </div>
      </div>
    </div>

    <!-- Bagian Form & Tabs -->
    <div id="form-daftar" class="mt-5 pt-4" data-aos="fade-up">
      <!-- TABS -->
      <div class="text-center mb-5">
        <ul class="nav nav-pills gap-2 custom-nav-pills" id="magangTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pengajuan-tab" data-bs-toggle="pill" data-bs-target="#pengajuan" type="button" role="tab">Pengajuan Magang</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="status-tab" data-bs-toggle="pill" data-bs-target="#status" type="button" role="tab">Cek Status Pengajuan</button>
          </li>
        </ul>
      </div>

      <div class="tab-content" id="magangTabsContent">
        <!-- TAB 1: PENGAJUAN -->
        <div class="tab-pane fade show active" id="pengajuan" role="tabpanel">
          
          <div class="row g-5 align-items-start">
            <!-- Kolom Form Kiri -->
            <div class="col-lg-7">
              <div class="floating-card m-0">
                <div class="mb-5 border-bottom pb-4">
                  <h3 class="fw-bold mb-2 text-dark">Formulir Pendaftaran</h3>
                  <p class="text-muted">Lengkapi data diri Anda dengan informasi yang valid dan sesuai dokumen.</p>
                </div>
                
                <form action="#" method="POST" enctype="multipart/form-data">
                  <div class="row g-4">
                    <div class="col-md-6">
                      <label class="form-label">Nama Lengkap</label>
                      <input type="text" class="form-control" required placeholder="Sesuai Identitas">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Email Aktif</label>
                      <input type="email" class="form-control" required placeholder="email@domain.com">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">No. WhatsApp</label>
                      <input type="tel" class="form-control" required placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Posisi Diminati</label>
                      <select class="form-select" required>
                        <option value="" selected disabled>-- Pilih Posisi --</option>
                        <option value="developer">Web / App Developer</option>
                        <option value="network">Network / SysAdmin</option>
                        <option value="multimedia">Multimedia & Sosmed</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <label class="form-label">Asal Kampus / Sekolah</label>
                      <input type="text" class="form-control" required placeholder="Nama Universitas atau Sekolah Tinggi">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Lokasi Magang</label>
                      <select class="form-select" required>
                        <option value="" selected disabled>-- Penempatan --</option>
                        <option value="Diskominfo">Diskominfo Kota Bogor</option>
                        <option value="Kecamatan">Kecamatan/Kelurahan</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Bidang Tujuan</label>
                      <select class="form-select" required>
                        <option value="" selected disabled>-- Pilih Bidang --</option>
                        <option value="Aplikasi">Aplikasi / e-Government</option>
                        <option value="IKP">Informasi & Komunikasi Publik</option>
                        <option value="Infrastruktur">Infrastruktur & Jaringan</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Lama Magang (Minggu)</label>
                      <input type="number" class="form-control" min="4" max="24" required placeholder="Cth: 12">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Surat Pengantar & CV (PDF)</label>
                      <input class="form-control" type="file" accept=".pdf" required style="border: 2px dashed #94a3b8; padding: 6px 12px; cursor: pointer;">
                    </div>
                  </div>

                  <div class="text-center mt-5 pt-4">
                    <button type="button" class="btn btn-premium px-5 py-3 w-100" style="max-width: 400px;" onclick="alert('Pengajuan Terkirim! Mohon tunggu konfirmasi email.')">
                      Kirim Permohonan Magang
                      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="ms-2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <!-- Kolom Info Kanan -->
            <div class="col-lg-5">
              <div class="info-box sticky-top" style="top: 120px;">
                <h5>
                  <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                  Informasi Penting
                </h5>
                <ol>
                  <li>Pastikan Data yang anda kirimkan <strong>Valid dan Sesuai Dokumen Fisik</strong>.</li>
                  <li><strong>Nomor Tiket</strong> Permohonan Pengajuan akan dikirimkan secara otomatis melalui <strong>email yang Anda daftarkan</strong>.</li>
                  <li>Gunakan Nomor Tiket tersebut pada tab <strong>Status Pengajuan</strong> untuk melacak progres permohonan secara berkala.</li>
                  <li>Jika disetujui, <strong>surat balasan resmi</strong> akan dikirimkan melalui email tersebut.</li>
                </ol>
                
                <div class="text-center mt-5">
                  <img src="../includes/image/poster4.jpeg" alt="Ilustrasi Magang" class="img-fluid" style="border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: 4px solid white; max-height: 220px; width: 100%; object-fit: cover;">
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- TAB 2: STATUS -->
        <div class="tab-pane fade" id="status" role="tabpanel">
          <div class="floating-card mx-auto text-center" style="max-width: 650px;">
            <div class="mb-4 d-inline-flex justify-content-center align-items-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #e0f2fe, #bae6fd); border-radius: 50%; color: var(--primary-dark); box-shadow: inset 0 2px 5px rgba(255,255,255,1), 0 10px 20px rgba(14,165,233,0.15);">
              <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
            <h3 class="fw-bold mb-3 text-dark">Lacak Pengajuan Magang</h3>
            <p class="text-secondary mb-5" style="font-size: 1.1rem;">Masukkan Nomor Tiket atau Email yang didaftarkan untuk mengetahui status terkini pengajuan magang Anda.</p>
            
            <form class="mx-auto" style="max-width: 450px;">
              <div class="mb-4">
                <label class="form-label text-start w-100">Nomor Tiket / Email</label>
                <input type="text" class="form-control text-center fw-bold" placeholder="Cth: TKT-12345" required style="letter-spacing: 1px; font-size: 1.15rem; padding: 1rem;">
              </div>
              <button type="button" class="btn btn-premium w-100 justify-content-center py-3" onclick="alert('Status: Dokumen Sedang Direview.')">
                Cek Status Sekarang
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
