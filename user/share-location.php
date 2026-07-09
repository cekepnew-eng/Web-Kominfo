<?php
$pageTitle = 'Aktivasi Pelacakan GPS';
$activePage = 'share_location';
require_once __DIR__ . '/../includes/header.php';
?>

<style>
    body {
        background-color: #f4f7f6;
    }
    .tracking-card {
        max-width: 500px;
        margin: 50px auto;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: none;
        overflow: hidden;
    }
    .tracking-header {
        background: linear-gradient(135deg, var(--primary) 0%, #a30000 100%);
        color: white;
        padding: 30px 20px;
        text-align: center;
    }
    .radar-icon {
        font-size: 3rem;
        margin-bottom: 10px;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
    .status-badge {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .status-inactive { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
    .status-active { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
</style>

<div class="container py-5">
    <div class="card tracking-card">
        <div class="tracking-header">
            <i class="bi bi-broadcast radar-icon" id="radarIcon"></i>
            <h3 class="fw-bold mb-0">Satelit Link Karyawan</h3>
            <p class="mb-0 text-white-50 small mt-1">Transmisi Lokasi Real-Time ke Pusat</p>
        </div>
        <div class="card-body p-4 text-center">
            
            <div id="statusContainer" class="status-badge status-inactive">
                <i class="bi bi-x-circle me-1"></i> Transmisi Nonaktif
            </div>

            <div id="setupSection">
                <p class="text-muted small mb-4">Masukkan nomor HP Anda yang telah didaftarkan oleh Admin untuk mulai mengirimkan lokasi asli Anda secara real-time.</p>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-telephone"></i></span>
                    <input type="text" class="form-control bg-light border-0" id="phoneNumber" placeholder="Contoh: +62 812-3333-4444">
                </div>
                <button class="btn btn-primary bg-maroon w-100 py-3 rounded-pill fw-bold border-0 shadow-sm mt-2" id="startBtn">
                    <i class="bi bi-geo-alt-fill me-2"></i> Aktifkan Sensor GPS
                </button>
            </div>

            <div id="activeSection" style="display: none;">
                <div class="bg-light rounded-4 p-3 mb-4 text-start">
                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle text-primary me-2"></i>Data Transmisi</h6>
                    <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                        <span class="text-muted small">Nomor Target</span>
                        <span class="fw-semibold" id="displayPhone">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                        <span class="text-muted small">Latitude</span>
                        <span class="fw-semibold font-monospace" id="displayLat">Menunggu...</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                        <span class="text-muted small">Longitude</span>
                        <span class="fw-semibold font-monospace" id="displayLng">Menunggu...</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Akurasi Sensor</span>
                        <span class="fw-semibold" id="displayAcc">-</span>
                    </div>
                </div>
                
                <p class="text-muted small mb-4"><i class="bi bi-shield-check text-success me-1"></i> Lokasi Anda saat ini sedang dikirim secara live ke Sistem Pusat Kominfov2. Jangan tutup halaman ini.</p>
                
                <button class="btn btn-outline-danger w-100 py-3 rounded-pill fw-bold" id="stopBtn">
                    <i class="bi bi-stop-circle me-2"></i> Hentikan Transmisi
                </button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startBtn = document.getElementById('startBtn');
    const stopBtn = document.getElementById('stopBtn');
    const phoneInput = document.getElementById('phoneNumber');
    
    const setupSection = document.getElementById('setupSection');
    const activeSection = document.getElementById('activeSection');
    const statusContainer = document.getElementById('statusContainer');
    
    let watchId = null;
    let currentUserPhone = '';

    startBtn.addEventListener('click', function() {
        const phone = phoneInput.value.trim();
        if(!phone) {
            Swal.fire({icon: 'warning', title: 'Oops', text: 'Silakan masukkan nomor HP Anda'});
            return;
        }

        if (!navigator.geolocation) {
            Swal.fire({icon: 'error', title: 'Tidak Mendukung', text: 'Browser Anda tidak mendukung fitur GPS.'});
            return;
        }

        Swal.fire({
            title: 'Meminta Akses GPS',
            text: 'Mohon izinkan browser untuk mengakses lokasi Anda.',
            icon: 'info',
            showConfirmButton: false,
            timer: 2000
        });

        // Minta akses GPS dan pantau pergerakan (watchPosition)
        watchId = navigator.geolocation.watchPosition(
            function(position) {
                // Success Callback
                currentUserPhone = phone;
                
                // Update UI
                setupSection.style.display = 'none';
                activeSection.style.display = 'block';
                statusContainer.className = 'status-badge status-active';
                statusContainer.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Transmisi Aktif (Live)';
                
                document.getElementById('displayPhone').innerText = phone;
                document.getElementById('displayLat').innerText = position.coords.latitude.toFixed(6);
                document.getElementById('displayLng').innerText = position.coords.longitude.toFixed(6);
                document.getElementById('displayAcc').innerText = position.coords.accuracy.toFixed(1) + ' meter';

                // Kirim data ke server (API)
                sendLocationToServer(phone, position.coords.latitude, position.coords.longitude);
            },
            function(error) {
                // Error Callback
                let msg = 'Gagal mendapatkan lokasi.';
                if(error.code === 1) msg = 'Anda menolak izin akses lokasi GPS.';
                if(error.code === 2) msg = 'Sinyal GPS tidak tersedia.';
                if(error.code === 3) msg = 'Waktu permintaan lokasi habis.';
                
                Swal.fire({icon: 'error', title: 'Akses Gagal', text: msg});
            },
            {
                enableHighAccuracy: true,
                maximumAge: 0,
                timeout: 10000
            }
        );
    });

    stopBtn.addEventListener('click', function() {
        if(watchId !== null) {
            navigator.geolocation.clearWatch(watchId);
            watchId = null;
        }
        
        setupSection.style.display = 'block';
        activeSection.style.display = 'none';
        statusContainer.className = 'status-badge status-inactive';
        statusContainer.innerHTML = '<i class="bi bi-x-circle me-1"></i> Transmisi Nonaktif';
        
        Swal.fire({icon: 'success', title: 'Dihentikan', text: 'Transmisi lokasi telah dihentikan.', timer: 2000, showConfirmButton:false});
    });

    function sendLocationToServer(phone, lat, lng) {
        fetch('/kominfov2/api/update-location.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                phone: phone,
                lat: lat,
                lng: lng
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'error') {
                console.error('Server error:', data.message);
                // Jika nomor tidak terdaftar, kita bisa memberitahu user
                if(data.message.includes('tidak terdaftar')) {
                    stopBtn.click();
                    Swal.fire({icon: 'error', title: 'Nomor Ditolak', text: data.message});
                }
            } else {
                console.log('Lokasi sukses terkirim ke satelit pusat.');
            }
        })
        .catch(error => {
            console.error('Network Error:', error);
        });
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
