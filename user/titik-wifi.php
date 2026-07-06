<?php
declare(strict_types=1);

$pageTitle  = 'Titik Lokasi WiFi Gratis — Diskominfo Kota Bogor';
$activePage = 'wifi';

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Include Leaflet CSS for Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<style>
  /* Removed Hero CSS */

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
  .bg-rose-light { background: linear-gradient(135deg, #ffe4e6 0%, #fecdd3 100%); color: #e11d48; }

  /* Custom Popup Leaflet */
  .leaflet-popup-content-wrapper {
    border-radius: 16px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    border: none;
    padding: 5px;
  }
  .leaflet-popup-content { margin: 10px 14px; line-height: 1.6; }
  .leaflet-popup-tip { background: #fff; box-shadow: none; }
</style>

<!-- ═══════════ KONTEN UTAMA ═══════════ -->
<section class="section" style="background-color: #f8fafc; padding: 8rem 0 5rem 0; min-height: 85vh;">
  <div class="container">
    
    <!-- Judul Sederhana dengan Tambahan Teks -->
    <div class="mb-5" data-aos="fade-up">
      <span class="badge px-3 py-2 rounded-pill mb-3 shadow-sm fw-bold" style="background-color: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe;">Fasilitas Publik</span>
      <h2 class="fw-bold mb-3" style="color: #312e81;">Jaringan WiFi Publik Gratis</h2>
      <p class="text-secondary mb-0" style="font-size: 1.1rem; max-width: 800px; line-height: 1.7;">
        Temukan lokasi WiFi gratis berkecepatan tinggi yang disediakan oleh Pemerintah Kota Bogor. Fasilitas ini tersebar di berbagai taman kota, ruang publik, halte, terminal, dan fasilitas umum lainnya untuk mendukung produktivitas dan inklusi digital bagi seluruh masyarakat Kota Bogor.
      </p>
    </div>

    <div class="row g-5">
      
      <!-- Bagian Kiri: Peta -->
      <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
        <div class="map-wrapper">
          <div id="wifiMap"></div>
          
          <!-- Map Overlay Info -->
          <div class="map-overlay">
            <h6 class="fw-bold mb-2" style="color: #312e81; font-size: 0.95rem;">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line></svg>
              Panduan Akses
            </h6>
            <p class="small text-secondary mb-0" style="font-size: 0.85rem; line-height: 1.5;">
              Klik pada salah satu ikon titik koordinat di peta untuk melihat detail lokasi dan <strong>Kata Sandi</strong> (Password) WiFi di area tersebut.
            </p>
          </div>
        </div>
      </div>
      
      <!-- Bagian Kanan: Statistik (Tampil Lebih Premium) -->
      <div class="col-lg-4" data-aos="fade-left" data-aos-delay="200">
        
        <!-- Summary Card -->
        <div class="card border-0 rounded-4 p-4 mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%); box-shadow: 0 15px 30px rgba(0,0,0,0.06);">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0 me-3">
              <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
            </div>
            <div>
              <h2 class="fw-bold mb-0" style="color: #312e81; font-size: 2.2rem;">38</h2>
              <p class="text-secondary fw-semibold mb-0" style="font-size: 0.9rem;">Total Titik WiFi Aktif</p>
            </div>
          </div>
        </div>

        <!-- Detail Cards -->
        <div class="stat-card">
          <div class="icon-circle bg-indigo-light">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v5a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
          </div>
          <div>
            <h6 class="fw-bold mb-1" style="color: #1e293b; font-size: 1.05rem;">Ruang Publik & Taman</h6>
            <p class="text-secondary mb-0" style="font-size: 0.85rem;">15 Titik Lokasi</p>
          </div>
        </div>
        
        <div class="stat-card">
          <div class="icon-circle bg-amber-light">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
          </div>
          <div>
            <h6 class="fw-bold mb-1" style="color: #1e293b; font-size: 1.05rem;">Shelter & Halte Trans</h6>
            <p class="text-secondary mb-0" style="font-size: 0.85rem;">22 Titik Lokasi</p>
          </div>
        </div>
        
        <div class="stat-card">
          <div class="icon-circle bg-emerald-light">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
          </div>
          <div>
            <h6 class="fw-bold mb-1" style="color: #1e293b; font-size: 1.05rem;">Terminal Transportasi</h6>
            <p class="text-secondary mb-0" style="font-size: 0.85rem;">1 Titik Lokasi</p>
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
  // Koordinat pusat Kota Bogor
  var map = L.map('wifiMap', {
    zoomControl: false // Disable default zoom to reposition it
  }).setView([-6.5971, 106.7996], 14);

  // Add repositioned zoom control
  L.control.zoom({ position: 'topright' }).addTo(map);

  // Menggunakan style basemap Carto yang bersih dan terang
  L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
  }).addTo(map);

  // Custom icon for WiFi Premium
  var wifiIcon = L.divIcon({
    html: `
      <div style="background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%); width: 36px; height: 36px; border-radius: 50%; display: flex; justify-content: center; align-items: center; border: 3px solid white; box-shadow: 0 4px 10px rgba(67, 56, 202, 0.5);">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line></svg>
      </div>
      <!-- Pulse Effect -->
      <div style="position:absolute; top:-4px; left:-4px; width:44px; height:44px; border-radius:50%; border:2px solid rgba(99,102,241,0.5); animation: pulse 2s infinite;"></div>
    `,
    className: 'custom-wifi-marker',
    iconSize: [36, 36],
    iconAnchor: [18, 18],
    popupAnchor: [0, -20]
  });

  // Inject CSS animation for pulse
  const style = document.createElement('style');
  style.innerHTML = `
    @keyframes pulse {
      0% { transform: scale(0.9); opacity: 1; }
      100% { transform: scale(1.5); opacity: 0; }
    }
  `;
  document.head.appendChild(style);

  // Data WiFi Location 
  const wifiLocations = [
    // Halte / Shelter
    { name: "Shelter Lodaya", lat: -6.5812, lng: 106.8045, type: "shelter" },
    { name: "Shelter Damkar", lat: -6.5789, lng: 106.8012, type: "shelter" },
    { name: "Halte Masjid Raya", lat: -6.6067, lng: 106.8100, type: "shelter" },
    { name: "Shelter Taman Topi", lat: -6.5945, lng: 106.7912, type: "shelter" },
    { name: "Halte RS Salak", lat: -6.5912, lng: 106.7955, type: "shelter" },
    { name: "Halte Sudirman 1", lat: -6.5855, lng: 106.7955, type: "shelter" },
    { name: "Halte Sudirman 2", lat: -6.5867, lng: 106.7960, type: "shelter" },
    { name: "Shelter SBRI 1", lat: -6.5755, lng: 106.8000, type: "shelter" },
    { name: "Shelter UIKA 1", lat: -6.5600, lng: 106.7925, type: "shelter" },
    { name: "Shelter Cidangiang", lat: -6.6033, lng: 106.8055, type: "shelter" },
    { name: "Shelter PDAM", lat: -6.6050, lng: 106.8120, type: "shelter" },
    { name: "Shelter RS PMI", lat: -6.6025, lng: 106.8016, type: "shelter" },
    { name: "Shelter Kebun Raya", lat: -6.5976, lng: 106.7996, type: "shelter" },
    { name: "Shelter NHX 3", lat: -6.5800, lng: 106.8100, type: "shelter" },
    { name: "Shelter Juanda", lat: -6.5980, lng: 106.7950, type: "shelter" },
    { name: "Shelter Budi Mulia", lat: -6.5999, lng: 106.7980, type: "shelter" },
    { name: "Shelter BTN", lat: -6.5960, lng: 106.7900, type: "shelter" },
    { name: "Shelter DPRD", lat: -6.5700, lng: 106.7900, type: "shelter" },
    { name: "Shelter SMPN 5", lat: -6.5720, lng: 106.7920, type: "shelter" },
    { name: "Shelter Warung Jambu", lat: -6.5740, lng: 106.8050, type: "shelter" },
    { name: "Shelter Radar Bogor", lat: -6.5650, lng: 106.7750, type: "shelter" },
    { name: "Shelter SDN Cibuluh 1", lat: -6.5610, lng: 106.8120, type: "shelter" },
    // Terminal
    { name: "Terminal Bubulak", lat: -6.5684, lng: 106.7490, type: "terminal" },
    // Ruang Publik & Taman
    { name: "Lapangan Olahraga Sempur", lat: -6.5898, lng: 106.7975, type: "taman" },
    { name: "Alun-Alun Kota Bogor", lat: -6.5950, lng: 106.7924, type: "taman" },
    { name: "Taman Kencana", lat: -6.5905, lng: 106.8017, type: "taman" },
    { name: "Taman Heulang", lat: -6.5768, lng: 106.7949, type: "taman" },
    { name: "Taman Corat-Coret", lat: -6.5742, lng: 106.8091, type: "taman" },
    { name: "Taman Lodaya", lat: -6.5822, lng: 106.8035, type: "taman" },
    { name: "Taman Lansia", lat: -6.5780, lng: 106.7950, type: "taman" },
    { name: "Taman Kaulinan", lat: -6.5891, lng: 106.7980, type: "taman" },
    { name: "Taman Bangbarung", lat: -6.5772, lng: 106.8105, type: "taman" },
    { name: "Foodcourt Taman Sempur", lat: -6.5899, lng: 106.7960, type: "taman" },
    { name: "Taman Mayasari", lat: -6.5955, lng: 106.7930, type: "taman" },
    { name: "Masjid Agung Bogor", lat: -6.5947, lng: 106.7932, type: "taman" },
    { name: "Balai Kota", lat: -6.5975, lng: 106.7945, type: "taman" },
    { name: "Kecamatan Tanah Sareal", lat: -6.5655, lng: 106.7905, type: "taman" },
    { name: "Kecamatan Bogor Selatan", lat: -6.6205, lng: 106.8015, type: "taman" }
  ];

  const defaultPassword = "bogorjuara2026";

  wifiLocations.forEach(loc => {
    // Generate popup HTML Premium
    const popupContent = `
      <div style="min-width: 200px; padding: 5px;">
        <span style="background:#e0e7ff; color:#4338ca; padding:2px 8px; border-radius:12px; font-size:10px; font-weight:bold; text-transform:uppercase; letter-spacing:0.5px;">WiFi Publik</span>
        <h6 style="margin:8px 0 5px 0; font-weight:800; color:#1e293b; font-size:1.1rem; line-height:1.2;">${loc.name}</h6>
        <p style="margin:0 0 12px 0; font-size:12px; color:#64748b;">Status Jaringan: <span style="color:#10b981; font-weight:bold;">● Online</span></p>
        
        <div style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0;">
          <span style="font-size:11px; color:#64748b; display:block; margin-bottom:4px; font-weight:600;">KATA SANDI / PASSWORD:</span>
          <div style="display:flex; justify-content:space-between; align-items:center;">
            <span style="font-family:'Courier New', monospace; font-weight:bold; color:#0f172a; font-size:16px; letter-spacing: 1px;">${defaultPassword}</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2" style="cursor:pointer;" onclick="alert('Password tersalin!')"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
          </div>
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
