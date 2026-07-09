<?php
$pageTitle = 'Tracking Nomor';
$activePage = 'tracking';
require_once __DIR__ . '/includes/header.php';

// Database Connection & Table Initialization
$conn = db_get_conn();
if ($conn) {
    // Buat tabel jika belum ada
    $sql_create = "CREATE TABLE IF NOT EXISTS employee_tracking (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        phone VARCHAR(50) NOT NULL,
        lat DECIMAL(10, 8) NOT NULL,
        lng DECIMAL(11, 8) NOT NULL,
        location_name VARCHAR(255) DEFAULT 'Lokasi Tidak Diketahui',
        status VARCHAR(50) DEFAULT 'Terakhir terlihat',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql_create);

    // Menambahkan dummy data awal jika tabel masih kosong (untuk prototype)
    $check_empty = $conn->query("SELECT COUNT(*) as count FROM employee_tracking");
    $row = $check_empty->fetch_assoc();
    if ($row['count'] == 0) {
        $dummy_data = [
            "('Budi Santoso', '+62 812-3456-7890', -6.5971, 106.7932, 'Alun-Alun Kota Bogor', 'Akurat')",
            "('Siti Aminah', '+62 898-7654-3210', -6.6025, 106.8043, 'Botani Square', 'Akurat')",
            "('Agus Pratama', '+62 811-1222-3333', -6.5828, 106.8033, 'Kebun Raya Bogor', 'Perkiraan')"
        ];
        $conn->query("INSERT INTO employee_tracking (name, phone, lat, lng, location_name, status) VALUES " . implode(',', $dummy_data));
    }

    // Handle Form Submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_tracking') {
        $newName = $conn->real_escape_string(trim($_POST['name'] ?? ''));
        $newPhone = $conn->real_escape_string(trim($_POST['phone'] ?? ''));
        
        if (!empty($newName) && !empty($newPhone)) {
            // Generate Random Location near Bogor (for prototype logic)
            // Latitude Bogor roughly -6.55 to -6.65
            // Longitude Bogor roughly 106.75 to 106.85
            $randLat = -6.55 - (mt_rand(0, 1000) / 10000); 
            $randLng = 106.75 + (mt_rand(0, 1000) / 10000);
            
            $sql_insert = "INSERT INTO employee_tracking (name, phone, lat, lng, location_name, status) 
                           VALUES ('$newName', '$newPhone', $randLat, $randLng, 'Lokasi Terlacak Sistem (Acak)', 'Terakhir terlihat')";
            
            if ($conn->query($sql_insert)) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Nomor baru berhasil ditambahkan untuk di-tracking!',
                            confirmButtonColor: 'var(--primary)'
                        });
                    });
                </script>";
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan sistem.',
                            confirmButtonColor: 'var(--primary)'
                        });
                    });
                </script>";
            }
        }
    }

    // Fetch All Numbers
    $tracking_data = [];
    $result = $conn->query("SELECT * FROM employee_tracking ORDER BY id DESC");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            // Format waktu untuk prototype
            $timeAgo = 'Baru saja'; 
            $tracking_data[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'phone' => $row['phone'],
                'lat' => (float)$row['lat'],
                'lng' => (float)$row['lng'],
                'locationName' => $row['location_name'],
                'time' => $timeAgo,
                'status' => $row['status']
            ];
        }
    }
} else {
    $tracking_data = []; // Fallback empty
}
?>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<style>
    #map {
        height: 600px;
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        z-index: 1;
    }
    .tracking-list {
        max-height: 520px;
        overflow-y: auto;
        padding-right: 5px;
    }
    .tracking-list::-webkit-scrollbar {
        width: 6px;
    }
    .tracking-list::-webkit-scrollbar-track {
        background: #f1f1f1; 
        border-radius: 4px;
    }
    .tracking-list::-webkit-scrollbar-thumb {
        background: #c1c1c1; 
        border-radius: 4px;
    }
    .tracking-list::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8; 
    }
    .tracking-item {
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-left: 4px solid transparent;
        border-radius: 8px;
        margin-bottom: 8px;
        border: 1px solid #f0f0f0;
    }
    .tracking-item:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }
    .tracking-item.active {
        background-color: #fffafb;
        border-left: 4px solid var(--primary);
        border-color: #ffe6e6;
        box-shadow: 0 4px 15px rgba(128, 0, 0, 0.05);
    }
    .tracking-icon-container {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #555;
    }
    .tracking-item.active .tracking-icon-container {
        background-color: var(--primary);
        color: white;
    }
</style>

<div class="container-fluid py-2">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h2 class="fw-bold mb-1">Sistem Tracking <span class="badge bg-secondary fs-6 rounded-pill align-text-top ms-2">Prototype</span></h2>
            <p class="text-muted mb-0">Pantau dan lacak lokasi terkini berdasarkan nomor tersimpan di sistem.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <button type="button" class="btn btn-primary bg-maroon border-0 px-4 py-2 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#addTrackingModal">
                <i class="bi bi-plus-lg me-2"></i> Tambah Target
            </button>
        </div>
    </div>

    <div class="row">
        <!-- List Nomor -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold"><i class="bi bi-person-lines-fill me-2 text-maroon"></i>Daftar Target</h5>
                    <span class="badge bg-maroon rounded-pill" id="totalNumbers">0</span>
                </div>
                <div class="card-body p-3 pt-0">
                    <!-- Search Box -->
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control bg-light border-0" id="searchTarget" placeholder="Cari nomor atau nama...">
                    </div>
                    
                    <div class="tracking-list" id="numberList">
                        <!-- Items will be populated by JS -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Peta -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-2 position-relative">
                    <div id="map"></div>
                    <!-- Overlay Status -->
                    <div class="position-absolute top-0 end-0 m-4 z-3">
                        <div class="bg-white px-3 py-2 rounded shadow-sm d-flex align-items-center gap-2 border">
                            <div class="spinner-grow spinner-grow-sm text-success" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span class="fw-semibold text-dark fs-7">Sistem Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Tracking -->
<div class="modal fade" id="addTrackingModal" tabindex="-1" aria-labelledby="addTrackingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 15px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="addTrackingModalLabel">Tambah Target Lacak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_tracking">
                    <p class="text-muted small mb-4">Masukkan data karyawan baru untuk melacak posisinya melalui sistem intelijen satelit (Prototype).</p>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Karyawan / Target</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control bg-light border-0" id="name" name="name" required placeholder="Contoh: Fajar Purnomo">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="form-label fw-semibold">Nomor Handphone</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-telephone"></i></span>
                            <input type="text" class="form-control bg-light border-0" id="phone" name="phone" required placeholder="Contoh: +62 812-3333-4444">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary bg-maroon border-0 px-4">Mulai Lacak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data dari Database (PHP ke JS)
        const savedNumbers = <?= json_encode($tracking_data) ?>;

        // Initialize Map
        // Set view ke Bogor by default
        var map = L.map('map').setView([-6.5971, 106.7932], 13);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors &copy; CARTO'
        }).addTo(map);

        var markersLayer = L.featureGroup().addTo(map);
        var activeMarker = null;

        var pulseIcon = L.divIcon({
            className: 'custom-div-icon',
            html: `<div style="background-color: var(--primary); width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(128,0,0,0.5);"></div>`,
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });

        document.getElementById('totalNumbers').innerText = savedNumbers.length;
        const listContainer = document.getElementById('numberList');
        
        function renderList(filterText = '') {
            listContainer.innerHTML = '';
            markersLayer.clearLayers(); // Bersihkan marker lama
            
            const filtered = savedNumbers.filter(item => 
                item.name.toLowerCase().includes(filterText.toLowerCase()) || 
                item.phone.toLowerCase().includes(filterText.toLowerCase())
            );

            if (filtered.length === 0) {
                listContainer.innerHTML = '<div class="text-center text-muted p-4"><i class="bi bi-emoji-frown fs-2 d-block mb-2"></i>Tidak ada data ditemukan.</div>';
                return;
            }

            filtered.forEach((item, index) => {
                // Tentukan warna badge
                let badgeColor = 'bg-success';
                if (item.status === 'Perkiraan') badgeColor = 'bg-warning text-dark';
                if (item.status === 'Terakhir terlihat') badgeColor = 'bg-secondary';

                // Buat Popup Content
                const popupContent = `
                    <div class="text-center p-1">
                        <h6 class="fw-bold mb-1">${item.name}</h6>
                        <p class="text-muted mb-2 small">${item.phone}</p>
                        <div class="badge ${badgeColor} mb-2">${item.status}</div>
                        <p class="mb-0 small"><i class="bi bi-geo-alt-fill text-danger"></i> ${item.locationName}</p>
                        <p class="text-muted mt-1 mb-0" style="font-size: 0.7rem;">Update: ${item.time}</p>
                    </div>
                `;

                // Tambahkan Marker ke Peta
                const marker = L.marker([item.lat, item.lng], {icon: pulseIcon})
                    .bindPopup(popupContent, {className: 'custom-popup'});
                markersLayer.addLayer(marker);

                // Buat Elemen List di Sidebar
                const div = document.createElement('div');
                div.className = 'tracking-item p-3 d-flex align-items-start gap-3 bg-white';
                div.innerHTML = `
                    <div class="tracking-icon-container flex-shrink-0 mt-1">
                        <i class="bi bi-phone"></i>
                    </div>
                    <div class="flex-grow-1 min-width-0">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="mb-0 fw-bold text-truncate">${item.phone}</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">${item.time}</small>
                        </div>
                        <p class="mb-1 text-dark text-truncate" style="font-size: 0.9rem;">${item.name}</p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <small class="text-muted text-truncate" style="font-size: 0.8rem;"><i class="bi bi-geo-alt-fill text-danger me-1"></i>${item.locationName}</small>
                            <span class="badge ${badgeColor} rounded-pill" style="font-size: 0.65rem;">${item.status}</span>
                        </div>
                    </div>
                `;
                
                div.addEventListener('click', function() {
                    document.querySelectorAll('.tracking-item').forEach(el => el.classList.remove('active'));
                    this.classList.add('active');

                    map.flyTo([item.lat, item.lng], 16, {
                        animate: true,
                        duration: 1.5
                    });
                    marker.openPopup();
                });

                listContainer.appendChild(div);
                
                // Simpan referensi objek untuk animasi
                item.markerObj = marker;
            });

            // Sesuaikan batas peta agar semua marker terlihat saat pertama kali load
            if (markersLayer.getLayers().length > 0) {
                map.fitBounds(markersLayer.getBounds(), {padding: [50, 50]});
            }
        }

        renderList();

        // SIMULASI PERGERAKAN REALTIME (Tanpa perlu client buka web)
        setInterval(() => {
            savedNumbers.forEach(item => {
                // Jangan gerakkan jika statusnya Akurat (Realtime) dan dia sedang diam, 
                // tapi karena ini demo, kita gerakkan semua secara acak sedikit saja.
                
                // Geser koordinat sedikit (sekitar 0 - 5 meter)
                const latShift = (Math.random() - 0.5) * 0.0001;
                const lngShift = (Math.random() - 0.5) * 0.0001;
                
                item.lat += latShift;
                item.lng += lngShift;
                
                // Update posisi marker di peta jika marker tersedia
                if(item.markerObj) {
                    item.markerObj.setLatLng([item.lat, item.lng]);
                }
            });
        }, 2500); // Gerak setiap 2.5 detik

        document.getElementById('searchTarget').addEventListener('input', function(e) {
            renderList(e.target.value);
        });
        
        const style = document.createElement('style');
        style.innerHTML = `
            .leaflet-popup-content-wrapper { border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
            .leaflet-popup-content { margin: 15px; }
        `;
        document.head.appendChild(style);
    });
</script>

<!-- Menggunakan SweetAlert CDN untuk popup sukses -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
