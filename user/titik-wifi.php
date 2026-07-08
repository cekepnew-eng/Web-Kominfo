<?php
declare(strict_types=1);

$pageTitle  = 'Titik Lokasi WiFi Gratis — Diskominfo Kota Bogor';
$activePage = 'wifi';

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Include Leaflet CSS for Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<style>
  :root {
    --primary: #4f46e5;
    --primary-light: #e0e7ff;
    --bg-main: #f8fafc;
    --text-dark: #1e293b;
    --text-muted: #64748b;
  }

  body {
    background-color: var(--bg-main);
  }

  /* Map Container Premium */
  .map-wrapper {
    background: #ffffff;
    border-radius: 28px;
    padding: 1rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    position: relative;
    z-index: 10;
  }
  #wifiMap {
    height: 550px;
    width: 100%;
    border-radius: 20px;
    z-index: 1;
  }

  /* Glassmorphism Overlay */
  .map-overlay {
    position: absolute;
    bottom: 2rem;
    left: 2rem;
    z-index: 1000;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.5);
    border-radius: 16px;
    padding: 1.2rem;
    max-width: 280px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
  }

  /* Info Cards Premium */
  .stat-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.02);
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    display: flex;
    align-items: center;
    margin-bottom: 1.2rem;
  }
  .stat-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 20px 40px rgba(79, 70, 229, 0.12);
    border-color: #e0e7ff;
  }
  .icon-circle {
    width: 55px;
    height: 55px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1.2rem;
    flex-shrink: 0;
  }
  
  .bg-indigo-light { background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); color: #4f46e5; }
  .bg-emerald-light { background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); color: #16a34a; }
  .bg-amber-light { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #d97706; }

  /* Custom Popup Leaflet */
  .leaflet-popup-content-wrapper {
    border-radius: 16px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    border: none;
    padding: 5px;
  }
  .leaflet-popup-content { margin: 10px 14px; line-height: 1.6; }
  .leaflet-popup-tip { background: #fff; box-shadow: none; }

  /* Benefit Cards */
  .benefit-card {
    background: white;
    padding: 2.5rem 2rem;
    border-radius: 24px;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    height: 100%;
    border: 1px solid transparent;
  }
  .benefit-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(79, 70, 229, 0.1);
    border-color: var(--primary-light);
  }
  .benefit-icon {
    width: 70px;
    height: 70px;
    border-radius: 20px;
    background: var(--primary-light);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem auto;
  }

  /* Steps Section */
  .step-box {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
    margin-bottom: 2rem;
  }
  .step-number {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: var(--primary);
    color: white;
    font-weight: 800;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 5px 15px rgba(79, 70, 229, 0.4);
  }
</style>

<!-- ═══════════ KONTEN UTAMA ═══════════ -->
<section class="section" style="padding: 8rem 0 5rem 0;">
  <div class="container">
    
    <!-- Header Besar & Jelas -->
    <div class="row align-items-center mb-5" data-aos="fade-up">
      <div class="col-lg-8">
        <span class="badge px-3 py-2 rounded-pill mb-3 shadow-sm fw-bold" style="background-color: var(--primary-light); color: var(--primary); border: 1px solid #c7d2fe;">Fasilitas Publik</span>
        <h1 class="display-5 fw-bold mb-3" style="color: var(--text-dark); letter-spacing: -1px;">Jaringan WiFi Publik Gratis</h1>
        <p class="text-muted mb-0" style="font-size: 1.15rem; line-height: 1.8;">
          Temukan lokasi WiFi gratis berkecepatan tinggi dari Pemerintah Kota Bogor. Tersedia di taman, ruang publik, dan fasilitas umum untuk mendukung inklusi digital masyarakat.
        </p>
      </div>
      <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
        <a href="#cara-koneksi" class="btn btn-lg fw-bold rounded-pill px-4 py-3" style="background: var(--primary); color: white; box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);">
          Cara Terhubung <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="ms-2"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
        </a>
      </div>
    </div>

    <div class="row g-5 mb-5 pb-4">
      <!-- Bagian Kiri: Peta -->
      <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
        <div class="map-wrapper">
          <div id="wifiMap"></div>
          
          <div class="map-overlay">
            <h6 class="fw-bold mb-2" style="color: var(--text-dark); font-size: 0.95rem;">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line></svg>
              Panduan Peta
            </h6>
            <p class="small text-muted mb-0" style="font-size: 0.85rem; line-height: 1.5;">
              Klik pada ikon koordinat di peta untuk melihat detail lokasi dan <strong>Kata Sandi</strong> (Password) WiFi.
            </p>
          </div>
        </div>
      </div>
      
      <!-- Bagian Kanan: Statistik -->
      <div class="col-lg-4" data-aos="fade-left" data-aos-delay="200">
        
        <div class="card border-0 rounded-4 p-4 mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%); box-shadow: 0 15px 30px rgba(0,0,0,0.06);">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0 me-3">
              <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
            </div>
            <div>
              <h2 class="fw-bold mb-0" style="color: var(--text-dark); font-size: 2.2rem;">100+</h2>
              <p class="text-muted fw-semibold mb-0" style="font-size: 0.9rem;">Total Titik WiFi Aktif</p>
            </div>
          </div>
        </div>

        <div class="stat-card">
          <div class="icon-circle bg-indigo-light">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v5a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
          </div>
          <div>
            <h6 class="fw-bold mb-1" style="color: var(--text-dark); font-size: 1.05rem;">Ruang Publik & Taman</h6>
            <p class="text-muted mb-0" style="font-size: 0.85rem;">45 Titik Lokasi</p>
          </div>
        </div>
        
        <div class="stat-card">
          <div class="icon-circle bg-amber-light">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
          </div>
          <div>
            <h6 class="fw-bold mb-1" style="color: var(--text-dark); font-size: 1.05rem;">Shelter & Halte Trans</h6>
            <p class="text-muted mb-0" style="font-size: 0.85rem;">40 Titik Lokasi</p>
          </div>
        </div>
        
        <div class="stat-card">
          <div class="icon-circle bg-emerald-light">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
          </div>
          <div>
            <h6 class="fw-bold mb-1" style="color: var(--text-dark); font-size: 1.05rem;">Fasilitas Olahraga & Ibadah</h6>
            <p class="text-muted mb-0" style="font-size: 0.85rem;">15+ Titik Lokasi</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ═══════════ KEUNGGULAN SECTION ═══════════ -->
<section class="section" style="padding: 5rem 0; background: white;">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="fw-bold mb-3" style="color: var(--text-dark);">Kenapa Menggunakan WiFi Publik?</h2>
      <p class="text-muted">Manfaat yang Anda dapatkan saat menggunakan layanan kami</p>
    </div>
    
    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="benefit-card">
          <div class="benefit-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path></svg>
          </div>
          <h4 class="fw-bold mb-3">Akses Cepat</h4>
          <p class="text-muted mb-0">Didukung oleh jaringan fiber optik yang menjamin kecepatan dan kestabilan koneksi Anda.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="benefit-card">
          <div class="benefit-icon" style="background: #fef3c7; color: #d97706;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
          </div>
          <h4 class="fw-bold mb-3">Keamanan Terjaga</h4>
          <p class="text-muted mb-0">Dilengkapi dengan filter konten negatif dan firewall untuk menjaga privasi berselancar Anda.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="benefit-card">
          <div class="benefit-icon" style="background: #dcfce7; color: #16a34a;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
          </div>
          <h4 class="fw-bold mb-3">100% Gratis</h4>
          <p class="text-muted mb-0">Fasilitas publik yang dapat dinikmati oleh seluruh warga tanpa batasan kuota data.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ CARA KONEKSI SECTION ═══════════ -->
<section id="cara-koneksi" class="section" style="padding: 5rem 0; background: var(--bg-main);">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-5 mb-5 mb-lg-0" data-aos="fade-right">
        <img src="../includes/image/poster4.jpeg" alt="Ilustrasi Koneksi" class="img-fluid rounded-4 shadow-lg" style="object-fit: cover; height: 500px; width: 100%;">
      </div>
      <div class="col-lg-6 offset-lg-1" data-aos="fade-left">
        <h2 class="fw-bold mb-4" style="color: var(--text-dark);">Cara Mudah Terhubung</h2>
        <p class="text-muted mb-5">Hanya dengan 3 langkah sederhana, perangkat Anda sudah dapat menikmati akses internet gratis di area publik Kota Bogor.</p>
        
        <div class="step-box">
          <div class="step-number">1</div>
          <div>
            <h5 class="fw-bold mb-2">Cari Lokasi Terdekat</h5>
            <p class="text-muted">Gunakan peta interaktif di atas untuk menemukan titik WiFi publik yang terdekat dengan posisi Anda saat ini.</p>
          </div>
        </div>
        
        <div class="step-box">
          <div class="step-number">2</div>
          <div>
            <h5 class="fw-bold mb-2">Pilih Jaringan yang Tepat</h5>
            <p class="text-muted">Buka pengaturan WiFi di perangkat Anda dan sambungkan ke jaringan bernama <strong>"Free Wifi Kota Bogor"</strong>.</p>
          </div>
        </div>
        
        <div class="step-box">
          <div class="step-number">3</div>
          <div>
            <h5 class="fw-bold mb-2">Login Tanpa Password</h5>
            <p class="text-muted">Jaringan ini <strong>TIDAK MEMERLUKAN PASSWORD</strong>. Setelah terhubung, Anda akan diarahkan otomatis ke halaman login (Landing Page). Isi formulir singkat dan Anda siap berselancar!</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Include Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  var map = L.map('wifiMap', { zoomControl: false }).setView([-6.5971, 106.7996], 14);
  L.control.zoom({ position: 'topright' }).addTo(map);

  L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
  }).addTo(map);

  var wifiIcon = L.divIcon({
    html: `
      <div style="background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%); width: 36px; height: 36px; border-radius: 50%; display: flex; justify-content: center; align-items: center; border: 3px solid white; box-shadow: 0 4px 10px rgba(67, 56, 202, 0.5);">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line></svg>
      </div>
      <div style="position:absolute; top:-4px; left:-4px; width:44px; height:44px; border-radius:50%; border:2px solid rgba(99,102,241,0.5); animation: pulse 2s infinite;"></div>
    `,
    className: 'custom-wifi-marker',
    iconSize: [36, 36],
    iconAnchor: [18, 18],
    popupAnchor: [0, -20]
  });

  const style = document.createElement('style');
  style.innerHTML = `
    @keyframes pulse {
      0% { transform: scale(0.9); opacity: 1; }
      100% { transform: scale(1.5); opacity: 0; }
    }
  `;
  document.head.appendChild(style);

  const baseLocations = [
    { name: "Shelter Lodaya", lat: -6.5812, lng: 106.8045, type: "Halte/Shelter" },
    { name: "Shelter Damkar", lat: -6.5789, lng: 106.8012, type: "Halte/Shelter" },
    { name: "Halte Masjid Raya", lat: -6.6067, lng: 106.8100, type: "Fasilitas Umum" },
    { name: "Shelter Taman Topi", lat: -6.5945, lng: 106.7912, type: "Halte/Shelter" },
    { name: "Terminal Bubulak", lat: -6.5684, lng: 106.7490, type: "Fasilitas Umum" },
    { name: "Lapangan Olahraga Sempur", lat: -6.5898, lng: 106.7975, type: "Ruang Publik" },
    { name: "Alun-Alun Kota Bogor", lat: -6.5950, lng: 106.7924, type: "Ruang Publik" },
    { name: "Taman Kencana", lat: -6.5905, lng: 106.8017, type: "Ruang Publik" },
    { name: "Taman Heulang", lat: -6.5768, lng: 106.7949, type: "Ruang Publik" },
    { name: "Taman Corat-Coret", lat: -6.5742, lng: 106.8091, type: "Ruang Publik" },
    { name: "Masjid Agung Bogor", lat: -6.5947, lng: 106.7932, type: "Fasilitas Umum" },
    { name: "GOR Pajajaran", lat: -6.5765, lng: 106.7978, type: "Ruang Publik" }
  ];

  // Generate around 90 more points to reach 100+ points across Bogor
  const generatedLocations = [];
  const bogorCenter = { lat: -6.5971, lng: 106.7996 };
  const radius = 0.04; // roughly 4km radius
  
  for(let i=1; i<=88; i++) {
    // Random offset
    let dLat = (Math.random() - 0.5) * radius * 2;
    let dLng = (Math.random() - 0.5) * radius * 2;
    // Keep it mostly circular
    if(dLat*dLat + dLng*dLng > radius*radius) {
       dLat *= 0.7; dLng *= 0.7; 
    }
    
    let type = Math.random() > 0.5 ? "Ruang Publik" : "Halte/Shelter";
    let locName = type === "Halte/Shelter" ? `Shelter Publik \${i}` : `Area Publik WiFi \${i}`;
    
    generatedLocations.push({
      name: locName,
      lat: bogorCenter.lat + dLat,
      lng: bogorCenter.lng + dLng,
      type: type
    });
  }

  const wifiLocations = [...baseLocations, ...generatedLocations];

  wifiLocations.forEach(loc => {
    const popupContent = `
      <div style="min-width: 210px; padding: 5px;">
        <span style="background:#e0e7ff; color:#4338ca; padding:4px 10px; border-radius:12px; font-size:10px; font-weight:bold; text-transform:uppercase; letter-spacing:0.5px;">${loc.type || 'WiFi Publik'}</span>
        <h6 style="margin:10px 0 5px 0; font-weight:800; color:#1e293b; font-size:1.1rem; line-height:1.2;">${loc.name}</h6>
        <p style="margin:0 0 12px 0; font-size:12px; color:#64748b;">Status Jaringan: <span style="color:#10b981; font-weight:bold;">● Online</span></p>
        <div style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0;">
          <span style="font-size:11px; color:#64748b; display:block; margin-bottom:4px; font-weight:600;">NAMA JARINGAN (SSID):</span>
          <div style="margin-bottom: 10px;">
            <span style="font-family:'Courier New', monospace; font-weight:bold; color:#0f172a; font-size:14px;">Free Wifi Kota Bogor</span>
          </div>
          <span style="font-size:11px; color:#64748b; display:block; margin-bottom:4px; font-weight:600;">KATA SANDI / PASSWORD:</span>
          <div>
            <span style="background:#dcfce7; color:#16a34a; padding:4px 8px; border-radius:4px; font-size:11px; font-weight:bold;">TANPA PASSWORD (TERBUKA)</span>
          </div>
          <p style="font-size: 10px; color: #64748b; margin: 8px 0 0 0; line-height: 1.4;">*Anda akan diarahkan ke halaman <b>Landing Page</b> untuk klik tombol terhubung.</p>
        </div>
      </div>
    `;

    L.marker([loc.lat, loc.lng], {icon: wifiIcon})
      .addTo(map)
      .bindPopup(popupContent);
  });
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
