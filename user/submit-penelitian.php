<?php
declare(strict_types=1);

$pageTitle  = 'Pengajuan Penelitian — Diskominfo Kota Bogor';
$activePage = 'penelitian';

require_once __DIR__ . '/../includes/header.php';
?>

<style>
  .custom-nav-pills .nav-link {
    color: #475569;
    background-color: #fff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.2s ease;
  }
  .custom-nav-pills .nav-link:hover {
    border-color: #94a3b8;
    background-color: #f8fafc;
  }
  .custom-nav-pills .nav-link.active {
    color: #fff;
    background-color: #0ea5e9;
    border-color: #0ea5e9;
  }
  .info-box {
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 24px;
  }
  .info-box h5 {
    color: #dc2626; /* Red color for warning/important */
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 1rem;
  }
  .info-box ol {
    padding-left: 1rem;
    color: #475569;
    font-size: 0.9rem;
    line-height: 1.8;
  }
  .info-box ol li strong {
    color: #1e293b;
  }
</style>

<section class="section">
  <div class="container mt-3">
    
    <div class="mb-4">
      <a href="penelitian.php" class="btn btn-light border fw-bold text-secondary rounded-3" style="font-size: 0.9rem;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Kembali
      </a>
    </div>

    <!-- TABS -->
    <ul class="nav nav-pills gap-3 mb-5 custom-nav-pills" id="penelitianTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pengajuan-tab" data-bs-toggle="pill" data-bs-target="#pengajuan" type="button" role="tab">Pengajuan Permohonan</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="status-tab" data-bs-toggle="pill" data-bs-target="#status" type="button" role="tab">Status Pengajuan</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="unggah-tab" data-bs-toggle="pill" data-bs-target="#unggah" type="button" role="tab">Unggah Jurnal</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="status-jurnal-tab" data-bs-toggle="pill" data-bs-target="#status-jurnal" type="button" role="tab">Status Jurnal</button>
      </li>
    </ul>

    <div class="tab-content" id="penelitianTabsContent">
      
      <!-- TAB 1: PENGAJUAN PERMOHONAN -->
      <div class="tab-pane fade show active" id="pengajuan" role="tabpanel">
        <h4 class="fw-bold mb-4">Pengajuan Permohonan Penelitian</h4>
        
        <div class="row g-5">
          <!-- Kolom Form (Kiri) -->
          <div class="col-lg-7">
            <form action="#" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
              <div class="mb-3">
                <label class="form-label fw-bold text-secondary small">Nama Lengkap</label>
                <input type="text" class="form-control bg-light" required>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold text-secondary small">No Telepon</label>
                  <input type="tel" class="form-control bg-light" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold text-secondary small">Alamat Email</label>
                  <input type="email" class="form-control bg-light" required>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold text-secondary small">Nama Instansi</label>
                <input type="text" class="form-control bg-light" required>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold text-secondary small">Judul Penelitian</label>
                <input type="text" class="form-control bg-light" required>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold text-secondary small">Lokasi Penelitian</label>
                  <select class="form-select bg-light" required>
                    <option value="" selected disabled>-- Pilih Lokasi --</option>
                    <option value="Diskominfo">Diskominfo Kota Bogor</option>
                    <option value="Kecamatan">Kecamatan/Kelurahan</option>
                    <option value="Publik">Ruang Publik / Masyarakat</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold text-secondary small">Bidang Tujuan</label>
                  <select class="form-select bg-light" required>
                    <option value="" selected disabled>-- Pilih Bidang --</option>
                    <option value="Aplikasi">Aplikasi / e-Government</option>
                    <option value="IKP">Informasi & Komunikasi Publik</option>
                    <option value="Infrastruktur">Infrastruktur & Jaringan</option>
                    <option value="Statistik">Statistik Sektoral</option>
                  </select>
                </div>
              </div>

              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-bold text-secondary small">Surat Penelitian</label>
                  <input type="file" class="form-control bg-light" accept=".pdf" required>
                  <div class="form-text" style="font-size: 0.75rem;">Format file harus .pdf dan ukuran maksimal 2MB</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold text-secondary small">Surat Kesbangpol</label>
                  <input type="file" class="form-control bg-light" accept=".pdf">
                  <div class="form-text" style="font-size: 0.75rem;">Format file harus .pdf dan ukuran maksimal 2MB</div>
                </div>
              </div>

              <button type="button" class="btn btn-primary px-4 py-2" style="background-color: #0ea5e9; border: none; border-radius: 6px; font-weight: bold;" onclick="submitMock('pengajuan')">Submit</button>
            </form>
          </div>

          <!-- Kolom Info (Kanan) -->
          <div class="col-lg-5">
            <div class="info-box">
              <h5>Informasi Penting!</h5>
              <ol>
                <li>Pastikan Data yang anda kirimkan <strong>Valid</strong>.</li>
                <li><strong>Nomor Tiket</strong> Permohonan Pengajuan akan dikirimkan melalui <strong>alamat email anda</strong>.</li>
                <li>Nomor Tiket Permohonan Pengajuan dapat digunakan <strong>untuk melihat status permohonan anda</strong>.</li>
                <li>Jika disetujui, <strong>surat jawaban</strong> akan dikirimkan melalui alamat email anda.</li>
              </ol>
              
              <div class="text-center mt-4">
                <!-- Illustration Image Mockup -->
                <img src="../includes/image/poster3.jpeg" alt="Ilustrasi Penelitian" class="img-fluid rounded-4 shadow-sm" style="max-height: 200px; object-fit: cover;">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- TAB 2: STATUS PENGAJUAN -->
      <div class="tab-pane fade" id="status" role="tabpanel">
        <div class="row justify-content-center">
          <div class="col-md-6 text-center">
            <h4 class="fw-bold mb-4">Cek Status Pengajuan</h4>
            <div class="card shadow-sm border-0 bg-light p-5 rounded-4">
              <p class="text-secondary mb-4">Masukkan Nomor Tiket yang telah dikirimkan ke email Anda untuk melacak status persetujuan penelitian.</p>
              <form>
                <div class="mb-4">
                  <input type="text" class="form-control form-control-lg text-center" placeholder="Nomor Tiket (Contoh: TKT-12345)" required>
                </div>
                <button type="button" class="btn btn-primary btn-lg px-5" style="background-color: #0ea5e9; border: none;" onclick="checkStatusMock()">Cek Status</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- TAB 3: UNGGAH JURNAL -->
      <div class="tab-pane fade" id="unggah" role="tabpanel">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <h4 class="fw-bold mb-4">Unggah Hasil Penelitian / Jurnal</h4>
            <div class="card shadow-sm border-0 p-4 rounded-4">
              <form>
                <div class="mb-3">
                  <label class="form-label fw-bold text-secondary small">Nomor Tiket Pengajuan</label>
                  <input type="text" class="form-control bg-light" placeholder="Masukkan nomor tiket penelitian Anda" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-secondary small">File Dokumen Final / Jurnal</label>
                  <input type="file" class="form-control bg-light" accept=".pdf" required>
                  <div class="form-text">Unggah dokumen hasil akhir penelitian dalam format PDF (Maks 10MB).</div>
                </div>
                <div class="mb-4">
                  <label class="form-label fw-bold text-secondary small">Link Publikasi Jurnal (Opsional)</label>
                  <input type="url" class="form-control bg-light" placeholder="https://jurnal.universitas.ac.id/...">
                </div>
                <button type="button" class="btn btn-primary px-4 py-2" style="background-color: #0ea5e9; border: none; font-weight: bold;" onclick="submitMock('jurnal')">Unggah Dokumen</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- TAB 4: STATUS JURNAL -->
      <div class="tab-pane fade" id="status-jurnal" role="tabpanel">
        <div class="row justify-content-center">
          <div class="col-md-6 text-center">
            <h4 class="fw-bold mb-4">Cek Status Verifikasi Jurnal</h4>
            <div class="card shadow-sm border-0 bg-light p-5 rounded-4">
              <p class="text-secondary mb-4">Masukkan Nomor Tiket untuk melihat apakah dokumen akhir / jurnal Anda telah diverifikasi dan diterima oleh Diskominfo.</p>
              <form>
                <div class="mb-4">
                  <input type="text" class="form-control form-control-lg text-center" placeholder="Nomor Tiket" required>
                </div>
                <button type="button" class="btn btn-primary btn-lg px-5" style="background-color: #0ea5e9; border: none;" onclick="checkStatusJurnalMock()">Cek Status</button>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
function submitMock(type) {
  alert(type === 'pengajuan' 
    ? "Pengajuan berhasil dikirim! Silakan periksa email Anda untuk Nomor Tiket."
    : "Jurnal berhasil diunggah! Terima kasih telah melaporkan hasil penelitian Anda.");
  window.location.reload();
}
function checkStatusMock() {
  alert("Status Pengajuan: Sedang dalam proses verifikasi (Pending).");
}
function checkStatusJurnalMock() {
  alert("Status Jurnal: Menunggu peninjauan admin.");
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
