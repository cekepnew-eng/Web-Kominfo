<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/services.php';

$pageTitle = 'Form Pengaduan Masyarakat';
$activePage = 'laporan';

// Menangkap pre-fill dari AI Chatbot
$catPrefill = trim((string)($_GET['cat'] ?? ''));
$descPrefill = trim((string)($_GET['desc'] ?? ''));

require __DIR__ . '/../includes/header.php';
?>

<div class="py-5 mt-5">
    <div class="container py-5">
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-lg-8 mx-auto text-center">
                <h6 class="text-primary-maroon fw-bold text-uppercase">Layanan Publik</h6>
                <h2 class="display-6 fw-bold">Sampaikan Pengaduan Anda</h2>
                <p class="text-muted">Isi form di bawah ini dengan detail yang jelas. Laporan Anda akan segera diproses oleh instansi terkait secara transparan.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                <div class="card shadow-sm border-0 rounded-4 p-4 p-sm-5">
                    <form action="#" method="POST" id="pengaduanForm">
                        
                        <div class="mb-4">
                            <label for="kategori" class="form-label fw-bold">Kategori Aduan <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg" id="kategori" name="kategori" required>
                                <option value="" disabled <?= $catPrefill === '' ? 'selected' : '' ?>>Pilih kategori...</option>
                                <option value="Jalan Rusak" <?= $catPrefill === 'Jalan Rusak' ? 'selected' : '' ?>>Jalan Rusak</option>
                                <option value="Lampu Mati" <?= $catPrefill === 'Lampu Mati' ? 'selected' : '' ?>>Lampu Jalan Mati</option>
                                <option value="Sampah" <?= $catPrefill === 'Sampah' ? 'selected' : '' ?>>Penumpukan Sampah</option>
                                <option value="Banjir" <?= $catPrefill === 'Banjir' ? 'selected' : '' ?>>Banjir / Genangan</option>
                                <option value="Infrastruktur" <?= $catPrefill === 'Infrastruktur' ? 'selected' : '' ?>>Kerusakan Infrastruktur</option>
                                <option value="Layanan Publik" <?= $catPrefill === 'Layanan Publik' ? 'selected' : '' ?>>Keluhan Layanan Publik</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="lokasi" class="form-label fw-bold">Lokasi Kejadian <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Contoh: Jl. Pajajaran depan Botani" required>
                                <button class="btn btn-outline-primary" type="button" id="btnLokasi">
                                    📍 Lacak Lokasi
                                </button>
                            </div>
                            <input type="hidden" id="latitude" name="latitude" required>
                            <input type="hidden" id="longitude" name="longitude" required>
                            <input type="hidden" id="title" name="title" value="Laporan Masyarakat">
                            <small id="lokasiStatus" class="form-text text-muted">Klik tombol di atas untuk menyematkan koordinat GPS Anda.</small>
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi Laporan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="deskripsi" name="description" rows="5" placeholder="Ceritakan detail kronologi atau kondisi di lapangan..." required><?= esc($descPrefill) ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="foto" class="form-label fw-bold">Bukti Foto <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="foto" name="images[]" accept="image/*" required>
                            <div class="form-text">Format didukung: JPG, PNG, WEBP. Maksimal ukuran 5MB. Wajib dilampirkan.</div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="" id="persetujuan" required>
                            <label class="form-check-label text-muted" for="persetujuan">
                                Saya menyatakan bahwa laporan ini benar dan dapat dipertanggungjawabkan sesuai hukum yang berlaku.
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary-maroon btn-lg">Kirim Laporan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pengaduanForm');
    const btnLokasi = document.getElementById('btnLokasi');
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const statusText = document.getElementById('lokasiStatus');

    if (btnLokasi) {
        btnLokasi.addEventListener('click', function() {
            if (!navigator.geolocation) {
                statusText.innerHTML = '<span class="text-danger">Geolokasi tidak didukung oleh browser Anda.</span>';
                return;
            }
            statusText.textContent = 'Mencari lokasi...';
            navigator.geolocation.getCurrentPosition(
                async function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    latInput.value = lat;
                    lngInput.value = lng;
                    
                    statusText.innerHTML = '<span class="text-success">Koordinat ditemukan, sedang mencari alamat...</span>';
                    
                    try {
                        // Reverse Geocoding menggunakan OpenStreetMap Nominatim API
                        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
                        const data = await response.json();
                        
                        if (data && data.display_name) {
                            document.getElementById('address').value = data.display_name;
                            statusText.innerHTML = `<span class="text-success">Lokasi berhasil disematkan! (${lat.toFixed(5)}, ${lng.toFixed(5)})</span>`;
                        } else {
                            document.getElementById('address').value = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
                            statusText.innerHTML = '<span class="text-warning">Gagal mendapat nama jalan, menggunakan koordinat GPS.</span>';
                        }
                    } catch (e) {
                        document.getElementById('address').value = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
                        statusText.innerHTML = `<span class="text-success">Lokasi berhasil disematkan! (${lat.toFixed(5)}, ${lng.toFixed(5)})</span>`;
                    }
                },
                function(error) {
                    statusText.innerHTML = '<span class="text-danger">Gagal mengambil lokasi. Pastikan GPS aktif dan izin diberikan.</span>';
                },
                { enableHighAccuracy: true }
            );
        });
    }

    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            if (!latInput.value || !lngInput.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Lokasi Belum Dipilih',
                    text: 'Silakan klik tombol "Lacak Lokasi" terlebih dahulu sebelum mengirim laporan.'
                });
                return;
            }

            Swal.fire({
                title: 'Sedang Memproses...',
                text: 'Mengirim laporan dan foto Anda secara aman.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // File input otomatis menggunakan name="images[]" dari HTML

            try {
                // Gunakan fetch API untuk mengirim data form
                const formData = new FormData(form);
                // Tambahkan title karena di backend wajib ada title
                formData.set('title', 'Laporan ' + formData.get('kategori') + ' - ' + new Date().toLocaleDateString());
                // Backend memakai 'category' bahasa inggris untuk key array (opsional disamakan atau biarkan mapping handle)
                formData.set('category', 'lainnya'); // Fallback jika validasi enum ketat, idealnya mapping dari form value
                
                // Mapping field select kategori ke value enum backend
                const katVal = document.getElementById('kategori').value;
                const catMap = {
                    'Jalan Rusak': 'jalan_rusak',
                    'Sampah': 'sampah',
                    'Lampu Mati': 'penerangan_jalan',
                    'Banjir': 'drainase_banjir',
                    'Infrastruktur': 'fasilitas_umum',
                    'Layanan Publik': 'lainnya'
                };
                if(catMap[katVal]) {
                    formData.set('category', catMap[katVal]);
                }

                const response = await fetch('laporan-api.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    let errorMsg = result.message || 'Gagal mengirim laporan.';
                    if (result.errors && typeof result.errors === 'object') {
                        const errVals = Object.values(result.errors);
                        if (errVals.length > 0) errorMsg = errVals[0];
                    }
                    throw new Error(errorMsg);
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Laporan Berhasil Terkirim!',
                    text: result.message + '\nNomor Tiket: ' + result.ticket_number,
                    confirmButtonColor: 'var(--primary-color)'
                }).then(() => {
                    form.reset();
                    window.location.href = 'daftar-pengaduan.php';
                });

            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: err.message
                });
            }
        });
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
