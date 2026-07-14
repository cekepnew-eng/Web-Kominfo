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
    --accent: #0ea5e9;
    --accent-dark: #0284c7;
    --surface: #ffffff;
    --border: #e2e8f0;
    --text: #0f172a;
    --text-muted: #64748b;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-md: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
  }

  body {
    background-color: var(--bg-color);
    position: relative;
    overflow-x: hidden;
    font-family: 'Inter', sans-serif;
  }

  body::after {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 600px;
    background: linear-gradient(180deg, rgba(224, 242, 254, 0.4) 0%, rgba(248, 250, 252, 0) 100%);
    z-index: -1;
    pointer-events: none;
  }
  
  /* ─── Light Modern Hero ─── */
  .modern-hero {
    position: relative;
    padding: 120px 0 80px 0;
    z-index: 2;
    text-align: center;
    color: var(--text);
  }
  .hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(2, 132, 199, 0.1);
    border: 1px solid rgba(2, 132, 199, 0.2);
    padding: 8px 24px;
    border-radius: 50px;
    color: var(--primary);
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 24px;
  }
  .hero-badge-dot {
    width: 10px; height: 10px; background: var(--primary); border-radius: 50%;
    animation: pulseBlue 2s infinite;
  }
  @keyframes pulseBlue { 
    0% { box-shadow: 0 0 0 0 rgba(2, 132, 199, 0.4); } 
    70% { box-shadow: 0 0 0 10px rgba(2, 132, 199, 0); } 
    100% { box-shadow: 0 0 0 0 rgba(2, 132, 199, 0); } 
  }
  .modern-hero h1 {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    color: var(--text);
    letter-spacing: -1px;
    margin-bottom: 24px;
    line-height: 1.2;
  }
  .modern-hero h1 span {
    color: var(--accent);
  }
  .modern-hero p {
    font-size: 1.15rem;
    color: var(--text-muted);
    max-width: 700px;
    margin: 0 auto 40px;
    line-height: 1.8;
  }

  /* ─── TABS ─── */
  .custom-nav-pills {
    background: var(--surface);
    padding: 8px;
    border-radius: 50px;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-md);
    display: inline-flex;
    flex-wrap: wrap;
    justify-content: center;
    margin: 0 auto;
  }
  .custom-nav-pills .nav-link {
    color: var(--text-muted);
    border-radius: 40px;
    padding: 12px 32px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
  }
  .custom-nav-pills .nav-link:hover {
    color: var(--primary);
  }
  .custom-nav-pills .nav-link.active {
    color: #ffffff;
    background-color: var(--primary);
    box-shadow: var(--shadow);
  }

  /* ─── Rich Cards ─── */
  .posisi-wrapper {
    margin-top: -6rem;
    position: relative;
    z-index: 10;
  }
  .posisi-card {
    background: var(--surface);
    border-radius: 20px;
    padding: 3rem 1.5rem;
    height: 100%;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    aspect-ratio: 1/1;
    max-width: 280px;
    margin: 0 auto;
    position: relative;
    overflow: hidden;
  }
  .posisi-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    background: var(--primary);
  }
  .posisi-card-front {
    transition: all 0.3s ease;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .posisi-card-back {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #ffffff;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s ease;
  }
  .posisi-card-back p {
    margin: 0;
    font-size: 0.95rem;
    line-height: 1.6;
    font-weight: 500;
  }
  .posisi-card:hover .posisi-card-front {
    opacity: 0;
    transform: translateY(-20px);
  }
  .posisi-card:hover .posisi-card-back {
    opacity: 1;
    transform: translateY(0);
  }
  .posisi-icon {
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
  }
  .posisi-icon svg {
    width: 70px;
    height: 70px;
    stroke-width: 1.5;
  }
  .posisi-icon.icon-blue { color: #1e3a8a; }
  .posisi-icon.icon-pink { color: #ec4899; }
  .posisi-icon.icon-green { color: #10b981; }
  
  .posisi-card:hover .posisi-icon {
    color: #ffffff;
    transform: scale(1.1);
  }
  .posisi-card h4 {
    font-weight: 700;
    color: var(--primary);
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: color 0.3s ease;
    margin-bottom: 0;
    line-height: 1.4;
  }
  .posisi-card:hover h4 {
    color: #ffffff;
  }

  /* ─── Premium Glass Form Container ─── */
  .floating-card {
    background: var(--surface);
    border-radius: 24px;
    padding: 3.5rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--border);
    position: relative;
    z-index: 2;
  }

  .info-box {
    background: #f8fafc;
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 2.5rem;
    box-shadow: var(--shadow);
  }
  .info-box h5 {
    color: var(--primary); 
    font-weight: 700;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 1.25rem;
  }
  .info-box ol {
    padding-left: 1.2rem;
    color: var(--text-muted);
    font-size: 1rem;
    line-height: 1.9;
  }
  .info-box ol li { margin-bottom: 0.75rem; }
  .info-box ol li strong {
    color: var(--text);
  }

  /* ─── Inputs ─── */
  .form-label {
    font-weight: 600;
    color: var(--text);
    font-size: 0.95rem;
    margin-bottom: 0.6rem;
  }
  .form-control, .form-select {
    background: #f9fafb;
    border: 1px solid #d1d5db;
    border-radius: 12px;
    padding: 0.85rem 1.2rem;
    font-size: 1rem;
    color: var(--text);
    transition: all 0.2s ease;
  }
  .form-control:focus, .form-select:focus {
    background: #ffffff;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px var(--primary-light);
    outline: none;
  }
  .form-control::placeholder {
    color: #9ca3af;
  }

  /* ─── Premium Buttons ─── */
  .btn-premium {
    background: var(--accent);
    border: none;
    color: #ffffff;
    font-weight: 700;
    padding: 14px 32px;
    border-radius: 50px;
    box-shadow: 0 4px 14px rgba(245, 158, 11, 0.4);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
    font-size: 1.05rem;
  }
  .btn-premium:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(14, 165, 233, 0.4);
    color: #ffffff;
    background: var(--accent-dark);
  }
  .btn-primary-solid {
    background: var(--primary);
    font-weight: 700;
    padding: 14px 32px;
    border-radius: 50px;
    box-shadow: 0 4px 14px rgba(30, 58, 138, 0.3);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
    font-size: 1.05rem;
  }
  .btn-primary-solid:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
    color: #ffffff;
  }
  .btn-outline-light {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.4);
    color: #ffffff;
    font-weight: 600;
    padding: 14px 32px;
    border-radius: 50px;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    font-size: 1.05rem;
  }
  .btn-outline-light:hover {
    background: rgba(255,255,255,0.25);
    border-color: #ffffff;
    color: #ffffff;
  }

  .btn-back-sticky {
    position: fixed;
    top: 90px;
    left: 24px;
    width: 50px;
    height: 50px;
    background: var(--surface);
    border: 1px solid var(--border);
    color: var(--text);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1050;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-md);
  }
  .btn-back-sticky:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: #ffffff;
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
  }
  @media (max-width: 768px) {
    .btn-back-sticky {
      top: 80px;
      left: 16px;
      width: 44px;
      height: 44px;
    }
    .modern-hero {
      padding: 100px 0 40px 0;
    }
    .modern-hero h1 {
      font-size: 2rem !important;
    }
    .posisi-wrapper {
      margin-top: -2rem;
    }
    .floating-card {
      padding: 1.5rem;
      border-radius: 16px;
    }
    .info-box {
      padding: 1.5rem;
      margin-top: 2rem;
    }
    .custom-nav-pills {
      flex-direction: column;
      width: 100%;
      border-radius: 16px;
    }
    .custom-nav-pills .nav-link {
      width: 100%;
      border-radius: 8px;
    }
    .posisi-card {
      max-width: 100%;
      aspect-ratio: auto;
      padding: 2rem 1rem;
      min-height: 250px;
    }
  }
</style>

<div class="pattern-overlay"></div>

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
    
    <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
      <a href="#form-daftar" class="btn btn-premium">
        Daftar Sekarang 
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
      <a href="#posisi" class="btn btn-primary-solid">
        Lihat Posisi Tersedia
      </a>
    </div>
  </div>
</div>

<!-- ─── KONTEN UTAMA ─── -->
<section class="section position-relative" style="padding-top: 2rem; padding-bottom: 5rem; z-index: 2;">
  <div class="container">
    
    <!-- Posisi Magang -->
    <div id="posisi" class="posisi-wrapper mb-5 pb-5" data-aos="fade-up" data-aos-delay="100">
      <div class="row g-4 justify-content-center">
        <div class="col-md-4 col-sm-6">
          <div class="posisi-card">
            <div class="posisi-card-front">
              <div class="posisi-icon icon-blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
              </div>
              <h4>Web / App<br>Developer</h4>
            </div>
            <div class="posisi-card-back">
              <p>Membangun dan mengembangkan aplikasi web cerdas (Smart City) dengan teknologi modern untuk pelayanan publik.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-6">
          <div class="posisi-card">
            <div class="posisi-card-front">
              <div class="posisi-icon icon-pink">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
              </div>
              <h4>Network &<br>SysAdmin</h4>
            </div>
            <div class="posisi-card-back">
              <p>Mengelola jaringan fiber optik kota, pemeliharaan server, dan memastikan keamanan infrastruktur IT daerah.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-6">
          <div class="posisi-card">
            <div class="posisi-card-front">
              <div class="posisi-icon icon-green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
              </div>
              <h4>Multimedia &<br>Sosmed</h4>
            </div>
            <div class="posisi-card-back">
              <p>Mendesain grafis, memproduksi video kreatif, dan mengelola media sosial resmi pemerintah kota.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bagian Form & Tabs -->
    <div id="form-daftar" class="mt-2" data-aos="fade-up">
      <!-- TABS -->
      <div class="mb-5">
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
          
          <div class="row g-4 align-items-start">
            <!-- Kolom Form Kiri -->
            <div class="col-lg-7">
              <div class="floating-card">
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
                      <input class="form-control" type="file" accept=".pdf" required style="border: 2px dashed #cbd5e1; padding: 6px 12px; cursor: pointer;">
                    </div>
                  </div>

                  <div class="text-center mt-5 pt-3">
                    <button type="button" class="btn btn-primary-solid px-5 py-3 w-100" style="max-width: 400px;" onclick="alert('Pengajuan Terkirim! Mohon tunggu konfirmasi email.')">
                      Kirim Permohonan Magang
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="ms-2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <!-- Kolom Info Kanan -->
            <div class="col-lg-5">
              <div class="info-box sticky-top" style="top: 120px;">
                <h5>
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                  Informasi Penting
                </h5>
                <ol>
                  <li>Pastikan Data yang anda kirimkan <strong>Valid dan Sesuai Dokumen Fisik</strong>.</li>
                  <li><strong>Nomor Tiket</strong> Permohonan Pengajuan akan dikirimkan secara otomatis melalui <strong>email yang Anda daftarkan</strong>.</li>
                  <li>Gunakan Nomor Tiket tersebut pada tab <strong>Status Pengajuan</strong> untuk melacak progres permohonan secara berkala.</li>
                  <li>Jika disetujui, <strong>surat balasan resmi</strong> akan dikirimkan melalui email tersebut.</li>
                </ol>
                
                <div class="text-center mt-4">
                  <img src="../includes/image/poster4.jpeg" alt="Ilustrasi Magang" class="img-fluid" style="border-radius: 16px; box-shadow: var(--shadow); width: 100%; object-fit: cover; aspect-ratio: 16/9;">
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- TAB 2: STATUS -->
        <div class="tab-pane fade" id="status" role="tabpanel">
          <div class="row">
            <div class="col-lg-7">
              <div class="floating-card">
                <div class="mb-4 d-inline-flex justify-content-center align-items-center" style="width: 72px; height: 72px; background: var(--primary-light); border-radius: 50%; color: var(--primary);">
                  <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <h3 class="fw-bold mb-3 text-dark">Lacak Pengajuan Magang</h3>
                <p class="text-muted mb-4" style="font-size: 1.05rem;">Masukkan Nomor Tiket atau Email yang didaftarkan untuk mengetahui status terkini pengajuan magang Anda.</p>
                
                <form style="max-width: 450px;">
                  <div class="mb-4 text-start">
                    <label class="form-label w-100">Nomor Tiket / Email</label>
                    <input type="text" class="form-control fw-semibold" placeholder="Cth: TKT-12345" required style="letter-spacing: 1px; font-size: 1.1rem; padding: 1rem;">
                  </div>
                  <button type="button" class="btn btn-primary-solid py-3" onclick="alert('Status: Dokumen Sedang Direview.')">
                    Cek Status Sekarang
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
