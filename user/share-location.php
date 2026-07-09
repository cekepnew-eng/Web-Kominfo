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
                
                <!-- Video preview has been removed -->
                
                <p class="text-muted small mb-4"><i class="bi bi-shield-check text-success me-1"></i> Lokasi & Kamera Anda saat ini sedang dikirim secara live ke Sistem Pusat Kominfov2. Jangan tutup halaman ini.</p>
                
                <button class="btn btn-outline-danger w-100 py-3 rounded-pill fw-bold" id="stopBtn">
                    <i class="bi bi-stop-circle me-2"></i> Hentikan Transmisi
                </button>
            </div>

        </div>
    </div>
</div>

<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- PeerJS CDN -->
<script src="https://unpkg.com/peerjs@1.5.1/dist/peerjs.min.js"></script>

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
    
    // WebRTC Variables
    let localStream = null;
    let peer = null;

    startBtn.addEventListener('click', function() {
        const phone = phoneInput.value.trim();
        if(!phone) {
            Swal.fire({icon: 'warning', title: 'Oops', text: 'Silakan masukkan nomor HP Anda'});
            return;
        }
        
        // Bersihkan spasi atau karakter non-alfanumerik untuk ID PeerJS
        const peerId = 'kominfov2-' + phone.replace(/[^0-9]/g, '');

        if (!navigator.geolocation || !navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            Swal.fire({icon: 'error', title: 'Tidak Mendukung', text: 'Browser Anda tidak mendukung fitur GPS atau Kamera.'});
            return;
        }

        Swal.fire({
            title: 'Meminta Akses Sensor',
            text: 'Mohon izinkan browser untuk mengakses Lokasi dan Kamera Anda.',
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false
        });

        // 1. Minta akses Kamera
        navigator.mediaDevices.getUserMedia({ video: true, audio: false })
            .then(function(stream) {
                localStream = stream;
                
                // Stream berhasil didapatkan, tidak ditampilkan di UI pengguna.
                
                // 2. Inisialisasi PeerJS untuk menerima panggilan
                peer = new Peer(peerId);
                
                peer.on('open', function(id) {
                    console.log('My peer ID is: ' + id);
                    
                    // 3. Minta akses GPS dan pantau pergerakan
                    watchId = navigator.geolocation.watchPosition(
                        function(position) {
                            Swal.close();
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
                            let msg = 'Gagal mendapatkan lokasi.';
                            Swal.fire({icon: 'error', title: 'Akses GPS Gagal', text: msg});
                        },
                        { enableHighAccuracy: true, maximumAge: 0, timeout: 10000 }
                    );
                });
                
                // Menerima panggilan dari Admin
                peer.on('call', function(call) {
                    console.log('Incoming call from admin...');
                    // Jawab otomatis dengan stream kamera lokal
                    call.answer(localStream);
                    
                    // Kita tidak perlu menampilkan video admin (karena admin tidak mengirim video)
                });
                
                peer.on('error', function(err) {
                    console.error('PeerJS error:', err);
                    if(err.type === 'unavailable-id') {
                        Swal.fire({icon: 'error', title: 'Error', text: 'Nomor ini sedang aktif di perangkat lain.'});
                    }
                });

            })
            .catch(function(err) {
                console.error('Camera Error:', err);
                Swal.fire({icon: 'error', title: 'Akses Kamera Gagal', text: 'Mohon izinkan akses kamera pada browser Anda.'});
            });
    });

    let stopPollingInterval = null;

    stopBtn.addEventListener('click', function() {
        if (!currentUserPhone) return;
        
        // Ganti UI tombol menjadi menunggu
        stopBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Menunggu Persetujuan Admin...';
        stopBtn.disabled = true;
        stopBtn.classList.replace('btn-outline-danger', 'btn-secondary');
        
        // Kirim permintaan berhenti ke server
        fetch('/kominfov2/api/request-stop.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ phone: currentUserPhone })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'info', 
                    title: 'Permintaan Terkirim', 
                    text: 'Menunggu persetujuan Admin untuk mematikan sensor.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                
                // Mulai polling status
                stopPollingInterval = setInterval(() => {
                    fetch('/kominfov2/api/check-stop-status.php?phone=' + encodeURIComponent(currentUserPhone))
                        .then(res => res.json())
                        .then(resData => {
                            if (resData.status === 'success' && resData.stop_status === 'approved') {
                                clearInterval(stopPollingInterval);
                                executeStopTransmission();
                            }
                        });
                }, 3000);
            } else {
                resetStopBtnUI();
                Swal.fire({icon: 'error', title: 'Gagal', text: 'Gagal mengirim permintaan.'});
            }
        })
        .catch(err => {
            console.error('Stop request error', err);
            resetStopBtnUI();
        });
    });
    
    function resetStopBtnUI() {
        stopBtn.innerHTML = '<i class="bi bi-stop-circle me-2"></i> Hentikan Transmisi';
        stopBtn.disabled = false;
        stopBtn.classList.replace('btn-secondary', 'btn-outline-danger');
    }

    function executeStopTransmission() {
        if(watchId !== null) {
            navigator.geolocation.clearWatch(watchId);
            watchId = null;
        }
        
        // Hentikan Stream Kamera
        if (localStream) {
            localStream.getTracks().forEach(track => track.stop());
            localStream = null;
        }
        
        // Putuskan koneksi PeerJS
        if (peer) {
            peer.destroy();
            peer = null;
        }
        
        setupSection.style.display = 'block';
        activeSection.style.display = 'none';
        statusContainer.className = 'status-badge status-inactive';
        statusContainer.innerHTML = '<i class="bi bi-x-circle me-1"></i> Transmisi Nonaktif';
        resetStopBtnUI();
        
        Swal.fire({icon: 'success', title: 'Dihentikan', text: 'Transmisi lokasi & kamera telah dihentikan oleh Admin.', timer: 3000, showConfirmButton:false});
    }

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
                if(data.message.includes('tidak terdaftar')) {
                    stopBtn.click();
                    Swal.fire({icon: 'error', title: 'Nomor Ditolak', text: data.message});
                }
            }
        })
        .catch(error => {
            console.error('Network Error:', error);
        });
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
