<?php
declare(strict_types=1);

$pageTitle  = 'Informasi Penelitian & Jurnal — Diskominfo Kota Bogor';
$activePage = 'penelitian';

require_once __DIR__ . '/../includes/header.php';
?>

<style>
  /* Efek Hover untuk Card Navigasi */
  .hover-scale {
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    border: 1px solid rgba(0,0,0,0.05);
    background-color: #ffffff;
    cursor: pointer;
  }
  .hover-scale:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 35px rgba(14, 165, 233, 0.15) !important;
    border-color: #bae6fd;
  }
  .icon-box {
    width: 55px;
    height: 55px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.2rem;
    transition: all 0.4s ease;
  }
  .hover-scale:hover .icon-box {
    transform: scale(1.1) rotate(5deg);
  }
  
  .icon-penelitian { background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); color: #0284c7; }
  .icon-magang { background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); color: #16a34a; }
  .icon-jurnal { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #d97706; }

  /* Style Premium untuk Wrapper Carousel (Tanpa Padding Putih) */
  .carousel-wrapper-premium {
    background: #000000;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    border: 1px solid rgba(255,255,255,0.2);
    transition: all 0.4s ease;
    height: 550px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
  }
  
  .carousel-wrapper-premium:hover {
    transform: translateY(-4px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.2);
  }

  /* Style Gambar Carousel (Blur Background + Object Fit Contain) */
  .poster-bg-blur {
    position: absolute;
    top: -10%; left: -10%; right: -10%; bottom: -10%;
    width: 120%; height: 120%;
    object-fit: cover;
    filter: blur(25px) brightness(0.6);
    z-index: 1;
    transition: opacity 0.5s ease;
  }

  .poster-img {
    position: relative;
    object-fit: contain; 
    width: 100%;
    height: 100%;
    z-index: 2;
    transition: transform 0.6s ease;
    filter: drop-shadow(0 10px 30px rgba(0,0,0,0.5));
  }

  .carousel-item.active .poster-img {
    animation: zoomIn 0.8s cubic-bezier(0.25, 0.8, 0.25, 1) forwards;
  }
  
  @keyframes zoomIn {
    from { transform: scale(0.95); opacity: 0.8; }
    to { transform: scale(1); opacity: 1; }
  }

  /* Navigasi Bulat Semi-Transparan Modern */
  .carousel-control-prev,
  .carousel-control-next {
    width: 45px;
    height: 45px;
    background-color: rgba(0, 0, 0, 0.4);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0;
    transition: all 0.3s ease;
    backdrop-filter: blur(8px);
    z-index: 10;
  }
  .carousel-control-prev { left: 1rem; }
  .carousel-control-next { right: 1rem; }
  
  .carousel-wrapper-premium:hover .carousel-control-prev,
  .carousel-wrapper-premium:hover .carousel-control-next {
    opacity: 1;
  }
  .carousel-control-prev:hover,
  .carousel-control-next:hover {
    background-color: rgba(0, 0, 0, 0.8);
    transform: translateY(-50%) scale(1.1);
  }

  .carousel-control-prev-icon,
  .carousel-control-next-icon {
    width: 1.2rem;
    height: 1.2rem;
    filter: none;
  }

  /* Indikator Slide */
  .carousel-indicators {
    bottom: 1rem;
    margin-bottom: 0;
    z-index: 10;
  }
  .carousel-indicators button {
    width: 8px !important;
    height: 8px !important;
    border-radius: 50%;
    background-color: rgba(255,255,255,0.4) !important;
    border: none !important;
    margin: 0 4px !important;
    transition: all 0.4s ease !important;
  }
  .carousel-indicators button.active {
    width: 24px !important;
    border-radius: 4px;
    background-color: #ffffff !important;
  }

  @media (max-width: 768px) {
    .carousel-wrapper-premium { height: 450px; }
  }
</style>

<!-- ═══════════ KONTEN UTAMA ═══════════ -->
<section class="section d-flex align-items-center" style="min-height: 85vh; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); padding-top: 8rem; padding-bottom: 4rem;">
  <div class="container mt-2">
    <div class="row align-items-center justify-content-between g-5">
      
      <!-- Bagian Kiri: Penjelasan & Menu Navigasi -->
      <div class="col-lg-6" data-aos="fade-right">
        
        <div class="mb-5 pe-lg-4">
          <span class="badge rounded-pill mb-3 shadow-sm fw-semibold" style="background-color: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; padding: 8px 16px;">Layanan Akademik</span>
          <h2 class="display-6 fw-bold mb-4" style="color: #0f172a; line-height: 1.2; letter-spacing: -0.5px;">Pusat Penelitian, Magang <br>& Publikasi Jurnal</h2>
          <p class="text-secondary" style="font-size: 1.1rem; line-height: 1.7;">
            Diskominfo Kota Bogor memfasilitasi para mahasiswa, peneliti, dan akademisi untuk melaksanakan berbagai kegiatan akademik. Mulai dari pengajuan izin penelitian, program magang profesional (PKL), hingga pengumpulan berkas jurnal atau karya tulis ilmiah Anda secara terintegrasi.
          </p>
          <p class="text-secondary mb-0 mt-3 fw-medium">Silakan pilih layanan yang Anda butuhkan di bawah ini:</p>
        </div>

        <div class="d-flex gap-3 flex-wrap">
          <a href="submit-penelitian.php" class="text-decoration-none text-dark flex-grow-1" style="min-width: 140px; max-width: 180px;">
            <div class="card rounded-4 shadow-sm text-center hover-scale p-4 d-flex flex-column align-items-center justify-content-center h-100">
              <div class="icon-box icon-penelitian">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><circle cx="10" cy="13" r="2"></circle><line x1="11.4" y1="14.4" x2="15" y2="18"></line></svg>
              </div>
              <h6 class="fw-bold mb-2" style="font-size: 1rem;">Penelitian</h6>
              <p class="text-muted mb-0" style="font-size: 0.75rem; line-height: 1.3;">Pengajuan Izin<br>Riset & Data</p>
            </div>
          </a>
          
          <a href="magang.php" class="text-decoration-none text-dark flex-grow-1" style="min-width: 140px; max-width: 180px;">
            <div class="card rounded-4 shadow-sm text-center hover-scale p-4 d-flex flex-column align-items-center justify-content-center h-100">
              <div class="icon-box icon-magang">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
              </div>
              <h6 class="fw-bold mb-2" style="font-size: 1rem;">Magang</h6>
              <p class="text-muted mb-0" style="font-size: 0.75rem; line-height: 1.3;">Pendaftaran<br>Program PKL</p>
            </div>
          </a>

          <a href="daftar-jurnal.php" class="text-decoration-none text-dark flex-grow-1" style="min-width: 140px; max-width: 180px;">
            <div class="card rounded-4 shadow-sm text-center hover-scale p-4 d-flex flex-column align-items-center justify-content-center h-100">
              <div class="icon-box icon-jurnal">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path><line x1="12" y1="6" x2="16" y2="6"></line><line x1="12" y1="10" x2="16" y2="10"></line></svg>
              </div>
              <h6 class="fw-bold mb-2" style="font-size: 1rem;">Jurnal</h6>
              <p class="text-muted mb-0" style="font-size: 0.75rem; line-height: 1.3;">Daftar Laporan<br>Hasil Akhir</p>
            </div>
          </a>
        </div>

      </div>

      <!-- Bagian Kanan: Carousel Slider Poster (Desain Premium) -->
      <div class="col-lg-5" data-aos="fade-left">
        <div class="carousel-wrapper-premium">
          
          <div id="penelitianCarousel" class="carousel slide w-100 h-100" data-bs-ride="carousel">
            
            <div class="carousel-inner h-100">
              
              <!-- Slide 1 -->
              <div class="carousel-item active h-100" data-bs-interval="5000">
                <!-- Background blur dinamis dari gambar yang sama -->
                <img src="../includes/image/poster1.jpeg" class="poster-bg-blur" alt="blur">
                <!-- Gambar utama yang tampil utuh di depan -->
                <img src="../includes/image/poster1.jpeg" class="poster-img p-2" alt="Informasi Dokumen">
              </div>
              
              <!-- Slide 2 -->
              <div class="carousel-item h-100" data-bs-interval="5000">
                <img src="../includes/image/poster2.jpeg" class="poster-bg-blur" alt="blur">
                <img src="../includes/image/poster2.jpeg" class="poster-img p-2" alt="Syarat Magang">
              </div>
              
              <!-- Slide 3 -->
              <div class="carousel-item h-100" data-bs-interval="5000">
                <img src="../includes/image/poster3.jpeg" class="poster-bg-blur" alt="blur">
                <img src="../includes/image/poster3.jpeg" class="poster-img p-2" alt="Alur Penelitian">
              </div>
              
            </div>
            
            <!-- Tombol Navigasi Premium -->
            <button class="carousel-control-prev" type="button" data-bs-target="#penelitianCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#penelitianCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>

            <!-- Indikator Slide Modern -->
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#penelitianCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#penelitianCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#penelitianCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
