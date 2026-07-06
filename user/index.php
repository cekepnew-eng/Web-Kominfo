<?php
declare(strict_types=1);

$pageTitle  = 'Beranda — Diskominfo Kota Bogor';
$activePage = 'home';

require_once __DIR__ . '/../includes/header.php';

// Get tanggal hari ini untuk kalender
$today     = (int)date('j');
$todayMonth = (int)date('n');
$todayYear  = (int)date('Y');
$daysInMonth= cal_days_in_month(CAL_GREGORIAN, $todayMonth, $todayYear);
$firstDay   = (int)date('N', mktime(0,0,0,$todayMonth,1,$todayYear)); // 1=Mon..7=Sun

require_once __DIR__ . '/../includes/db.php';
$conn = db_get_conn();
$settings = [];
if ($conn !== null) {
    $res = $conn->query("SELECT * FROM site_settings");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
}
$kadis_name = $settings['kadis_name'] ?? 'Nama Kepala Dinas';
$kadis_title = $settings['kadis_title'] ?? 'Kepala Dinas Kominfo';
$kadis_image = $settings['kadis_image'] ?? 'https://placehold.co/400x400?text=Foto+Kadis';
$kadis_greeting = $settings['kadis_greeting'] ?? "Assalamu'alaikum,";
$kadis_quote = $settings['kadis_quote'] ?? 'Selamat datang di website Diskominfo Kota Bogor.';
$kadis_body = $settings['kadis_body'] ?? 'Mari bersama mewujudkan Smart City untuk Bogor yang lebih maju dan inovatif.';
?>

<!-- ═══════════ HERO ═══════════ -->
<section class="hero text-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div data-aos="fade-up">
          <span class="hero-badge mx-auto">
            <span class="dot"></span>
            Selamat Datang di Website Resmi
          </span>
        </div>
        <h1 class="display-1 hero-title text-dark" data-aos="fade-up" data-aos-delay="80">
          Dinas Komunikasi &amp; Informatika Kota Bogor
        </h1>
        <p class="lead hero-lead mx-auto text-secondary" data-aos="fade-up" data-aos-delay="160">
          Membangun ekosistem digital yang inovatif untuk pelayanan publik yang lebih cepat, transparan, dan berkualitas tinggi bagi seluruh masyarakat Kota Bogor.
        </p>
        <div class="hero-actions justify-content-center" data-aos="fade-up" data-aos-delay="240">
          <a href="laporan.php" class="btn-primary" style="background-color: #0ea5e9; border: none; box-shadow: 0 4px 15px rgba(14, 165, 233, 0.4);">
            Jelajahi Layanan
          </a>
          <a href="#tentang" class="btn-secondary" style="border: 1px solid #cbd5e1;">
            Pelajari Lebih Lanjut
          </a>
        </div>
      </div>
    </div>

    <!-- Slider Banner (Swiper Coverflow) -->
    <div class="hero-slider-wrap w-100 mt-5" data-aos="fade-up" data-aos-delay="320">
      <div class="swiper heroSwiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <img src="../includes/image/poster1.jpeg" alt="Banner 1" loading="lazy">
          </div>
          <div class="swiper-slide">
            <img src="../includes/image/poster2.jpeg" alt="Banner 2" loading="lazy">
          </div>
          <div class="swiper-slide">
            <img src="../includes/image/poster3.jpeg" alt="Banner 3" loading="lazy">
          </div>
          <div class="swiper-slide">
            <img src="../includes/image/poster4.jpeg" alt="Banner 4" loading="lazy">
          </div>
          <!-- Duplicate for seamless looping -->
          <div class="swiper-slide">
            <img src="../includes/image/poster1.jpeg" alt="Banner 1" loading="lazy">
          </div>
          <div class="swiper-slide">
            <img src="../includes/image/poster2.jpeg" alt="Banner 2" loading="lazy">
          </div>
          <div class="swiper-slide">
            <img src="../includes/image/poster3.jpeg" alt="Banner 3" loading="lazy">
          </div>
          <div class="swiper-slide">
            <img src="../includes/image/poster4.jpeg" alt="Banner 4" loading="lazy">
          </div>
        </div>
        <!-- Pagination & Navigation -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev" style="color: #64748b; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1);"></div>
        <div class="swiper-button-next" style="color: #64748b; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1);"></div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ MENGENAL DISKOMINFO ═══════════ -->
<section class="section bg-alt" id="tentang">
  <div class="container">
    <div class="row align-items-center g-5">

      <!-- Kiri: Narasi -->
      <div class="col-lg-5" data-aos="fade-right">
        <span class="section-label">Tentang Kami</span>
        <div class="d-flex align-items-center gap-3 mb-3">
          <img src="../includes/image/kominfo.jpg" alt="Logo Diskominfo" style="width: 55px; height: 55px; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
          <h2 class="h2-section m-0">Mengenal Diskominfo</h2>
        </div>
        <p style="color:var(--slate-500); line-height:1.75; margin-bottom:1.75rem;">
          Dinas Komunikasi dan Informatika Kota Bogor adalah instansi pemerintah yang bertugas membantu Wali Kota dalam urusan pemerintahan di bidang komunikasi, informatika, statistik, dan persandian.
        </p>
        <a href="visi-misi.php" class="btn-primary">
          Selengkapnya
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>

      <!-- Kanan: 4 Feature Cards -->
      <div class="col-lg-7" data-aos="fade-left">
        <div class="features-grid">

          <div class="feature-card">
            <div class="feature-icon">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 11a9 9 0 0 1 9 9M4 4a16 16 0 0 1 16 16M4 20h.01"/></svg>
            </div>
            <div class="feature-text">
              <h4>Komunikasi Publik</h4>
              <p>Diseminasi informasi yang akurat dan transparan kepada masyarakat Kota Bogor.</p>
            </div>
          </div>

          <div class="feature-card">
            <div class="feature-icon">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/></svg>
            </div>
            <div class="feature-text">
              <h4>Pengelolaan TIK</h4>
              <p>Pembangunan dan pemeliharaan infrastruktur teknologi informasi pemerintah.</p>
            </div>
          </div>

          <div class="feature-card">
            <div class="feature-icon">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            </div>
            <div class="feature-text">
              <h4>Statistik Daerah</h4>
              <p>Pengelolaan data sektoral untuk mendukung kebijakan berbasis bukti.</p>
            </div>
          </div>

          <div class="feature-card">
            <div class="feature-icon">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <div class="feature-text">
              <h4>Persandian &amp; Keamanan</h4>
              <p>Penerapan kriptografi dan keamanan siber untuk menjaga integritas data.</p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ KEPALA DINAS ═══════════ -->
<section class="section">
  <div class="container">
    <div class="section-header text-center" data-aos="fade-up">
      <span class="section-label">Pimpinan</span>
      <h2 class="h2-section">Profil Kepala Dinas</h2>
    </div>

    <div class="profile-card" data-aos="fade-up" data-aos-delay="80">
      <!-- Foto -->
      <div class="profile-img-col">
        <img src="<?= esc($kadis_image) ?>"
             onerror="this.src='https://picsum.photos/seed/kadis/400/500'"
             alt="Kepala Dinas Diskominfo">
        <div class="profile-name">
          <h4><?= esc($kadis_name) ?></h4>
          <p><?= $kadis_title // HTML allowed for <br> ?></p>
        </div>
      </div>
      <!-- Konten -->
      <div class="profile-content">
        <p class="profile-greeting"><?= esc($kadis_greeting) ?></p>
        <div class="profile-quote">
          <?= esc($kadis_quote) ?>
        </div>
        <p class="profile-body">
          <?= $kadis_body // HTML allowed for <br> ?>
        </p>
        <a href="sejarah.php" class="btn-primary" style="display:inline-flex; width:fit-content;">
          Baca Selengkapnya
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ PORTAL LAYANAN ═══════════ -->
<section class="section bg-alt">
  <div class="container">
    <div class="row align-items-end mb-5" data-aos="fade-up">
      <div class="col-lg-7">
        <span class="section-label">Layanan Digital</span>
        <h2 class="h2-section">Layanan Digital Terpadu</h2>
        <p class="section-desc">Akses berbagai portal layanan publik dan informasi resmi dari Pemerintah Kota Bogor dalam satu tempat yang terintegrasi.</p>
      </div>
    </div>

    <div class="portal-grid">
      <!-- PPID — Featured (Biru) -->
      <div class="portal-card featured" data-aos="fade-up" data-aos-delay="0">
        <span class="portal-badge">Informasi Publik</span>
        <h4>PPID</h4>
        <p>Pejabat Pengelola Informasi dan Dokumentasi — akses dokumen publik secara legal dan transparan.</p>
        <a href="https://ppid.kotabogor.go.id" target="_blank" class="portal-link">
          Kunjungi <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>
      <!-- Smart City -->
      <div class="portal-card" data-aos="fade-up" data-aos-delay="60">
        <span class="portal-badge">Smart City</span>
        <h4>Smart City Bogor</h4>
        <p>Platform terintegrasi pemantauan kota secara real-time berbasis teknologi cerdas.</p>
        <a href="https://smartcity.kotabogor.go.id" target="_blank" class="portal-link">
          Kunjungi <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>
      <!-- Pengaduan Internal -->
      <div class="portal-card" data-aos="fade-up" data-aos-delay="120">
        <span class="portal-badge">Pengaduan</span>
        <h4>Daftar Pengaduan</h4>
        <p>Sampaikan keluhan dan pantau status pengaduan Anda secara langsung melalui layanan kami.</p>
        <a href="laporan.php" class="portal-link">
          Akses <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>
      <!-- Wowoembege AI -->
      <div class="portal-card" data-aos="fade-up" data-aos-delay="180">
        <span class="portal-badge">AI Baru</span>
        <h4>Wowoembege AI</h4>
        <p>Asisten virtual cerdas berbasis AI untuk bantuan seputar layanan Diskominfo.</p>
        <a href="wowoembege.php" class="portal-link">
          Mulai Chat <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ BERITA & KALENDER ═══════════ -->
<section class="section">
  <div class="container">
    <div class="row g-5">

      <!-- Kiri: Berita -->
      <div class="col-lg-7" data-aos="fade-right">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <div>
            <span class="section-label">Informasi Terkini</span>
            <h2 class="h2-section mb-0">Berita &amp; Inovasi</h2>
          </div>
          <a href="berita.php" class="btn-secondary" style="flex-shrink:0; padding:.625rem 1.25rem; font-size:.875rem;">
            Semua Berita
          </a>
        </div>

        <div class="news-grid" id="newsContainer">
          <!-- Berita dimuat oleh JS/PHP -->
          <div class="news-card">
            <img class="news-card-img" loading="lazy" src="https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=200&q=60" alt="">
            <div class="news-card-body">
              <span class="news-source">kotabogor.go.id</span>
              <p class="news-title">Program Smart City Kota Bogor Raih Penghargaan Nasional 2025</p>
              <span class="news-date">20 Juni 2025</span>
            </div>
          </div>
          <div class="news-card">
            <img class="news-card-img" loading="lazy" src="https://images.unsplash.com/photo-1496171367470-9ed9a91ea931?w=200&q=60" alt="">
            <div class="news-card-body">
              <span class="news-source">detik.com</span>
              <p class="news-title">Diskominfo Luncurkan Sistem Pengaduan Digital Terintegrasi SiBadra</p>
              <span class="news-date">18 Juni 2025</span>
            </div>
          </div>
          <div class="news-card">
            <img class="news-card-img" loading="lazy" src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=200&q=60" alt="">
            <div class="news-card-body">
              <span class="news-source">kotabogor.go.id</span>
              <p class="news-title">Pembangunan Infrastruktur Jaringan Fiber Optik di 68 Kelurahan</p>
              <span class="news-date">15 Juni 2025</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Kanan: Kalender -->
      <div class="col-lg-5" data-aos="fade-left">
        <span class="section-label">Agenda</span>
        <h2 class="h2-section mb-4">Kalender Kegiatan</h2>

        <div class="calendar-widget">
          <div class="cal-header">
            <button class="cal-nav-btn" id="calPrev">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <span id="calMonthYear"><?= date('F Y') ?></span>
            <button class="cal-nav-btn" id="calNext">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
          </div>

          <div style="padding:1rem 1.25rem;">
            <div class="cal-grid mb-1">
              <?php foreach(['S','S','R','K','J','S','M'] as $d): ?>
              <div class="cal-day-label"><?= $d ?></div>
              <?php endforeach; ?>
            </div>
            <div class="cal-grid" id="calGrid">
              <!-- Built by JS -->
            </div>
          </div>

          <div style="padding:.75rem 1.25rem; border-top:1px solid var(--border); font-size:.8125rem; color:var(--slate-500); text-align:center;">
            Tidak ada agenda pada bulan ini
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

<style>
/* CSS Khusus Swiper Coverflow */
.hero-slider-wrap {
  position: relative;
  width: 100%;
  padding-top: 1rem;
  padding-bottom: 2rem;
  overflow: hidden;
}
.heroSwiper {
  width: 100%;
  padding-top: 20px;
  padding-bottom: 50px;
}
.heroSwiper .swiper-slide {
  width: 320px;
  max-width: 80%;
  height: auto;
  border-radius: 1.5rem;
  overflow: hidden;
  box-shadow: 0 15px 35px rgba(0,0,0,0.15);
  background-color: transparent;
  opacity: 0.5;
  transition: opacity 0.4s ease;
}
.heroSwiper .swiper-slide-active {
  opacity: 1;
}
@media (max-width: 991px) {
  .heroSwiper .swiper-slide {
    width: 280px;
  }
}
@media (max-width: 576px) {
  .heroSwiper .swiper-slide {
    width: 260px;
  }
}
.heroSwiper .swiper-slide img {
  display: block;
  width: 100%;
  height: auto;
  object-fit: cover;
  margin: 0;
}
.heroSwiper .swiper-button-prev,
.heroSwiper .swiper-button-next {
  color: var(--primary);
  background: rgba(255,255,255,0.8);
  width: 44px;
  height: 44px;
  border-radius: 50%;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  backdrop-filter: blur(5px);
}
.heroSwiper .swiper-button-prev:after,
.heroSwiper .swiper-button-next:after {
  font-size: 1.25rem;
  font-weight: bold;
}
.heroSwiper .swiper-pagination-bullet {
  background: var(--slate-300);
  opacity: 1;
  width: 10px;
  height: 10px;
  transition: all 0.3s ease;
}
.heroSwiper .swiper-pagination-bullet-active {
  background: var(--primary);
  width: 25px;
  border-radius: 5px;
}
</style>

<script>
/* ── Swiper Coverflow Init ───────────────────────────────── */
const swiper = new Swiper('.heroSwiper', {
  effect: 'coverflow',
  grabCursor: true,
  centeredSlides: true,
  slidesPerView: 'auto',
  loop: true,
  autoplay: {
    delay: 3500,
    disableOnInteraction: false,
  },
  coverflowEffect: {
    rotate: 0,
    stretch: -30,
    depth: 250,
    modifier: 1,
    slideShadows: false,
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});

/* ── Calendar ───────────────────────────────── */
const monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
let calYear = <?= $todayYear ?>;
let calMonth = <?= $todayMonth - 1 ?>; // 0-indexed

function buildCal(year, month) {
  const grid = document.getElementById('calGrid');
  const label = document.getElementById('calMonthYear');
  const today = new Date();
  const firstDay = new Date(year, month, 1).getDay(); // 0=Sun
  const daysInMo = new Date(year, month + 1, 0).getDate();
  // Shift: make Mon=0
  const offset = (firstDay + 6) % 7;
  
  label.textContent = monthNames[month] + ' ' + year;
  
  let html = '';
  for (let i = 0; i < offset; i++) html += '<div class="cal-day other"></div>';
  for (let d = 1; d <= daysInMo; d++) {
    const isToday = (d === today.getDate() && month === today.getMonth() && year === today.getFullYear());
    html += `<div class="cal-day${isToday ? ' today' : ''}">${d}</div>`;
  }
  grid.innerHTML = html;
}
buildCal(calYear, calMonth);
document.getElementById('calPrev').addEventListener('click', () => {
  calMonth--; if(calMonth<0){calMonth=11;calYear--;} buildCal(calYear,calMonth);
});
document.getElementById('calNext').addEventListener('click', () => {
  calMonth++; if(calMonth>11){calMonth=0;calYear++;} buildCal(calYear,calMonth);
});
</script>
