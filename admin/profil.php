<?php
declare(strict_types=1);

$pageTitle = 'Pengaturan Profil Dinas';
$activePage = 'profil';
require_once __DIR__ . '/includes/header.php';

$conn = db_get_conn();

// Auto-create table & defaults if not exists
$conn->query("CREATE TABLE IF NOT EXISTS site_settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$defaults = [
    'kadis_name' => 'Rudiyana, S.STP., M.Sc',
    'kadis_title' => 'Kepala Dinas Diskominfo<br>Kota Bogor',
    'kadis_image' => 'https://diskominfo.kotabogor.go.id/assets/kepala-dinas.jpg',
    'kadis_greeting' => "Assalamu'alaikum Warahmatullahi Wabarakatuh,",
    'kadis_quote' => 'Selamat datang di website resmi Dinas Komunikasi dan Informatika Kota Bogor. Website ini hadir sebagai jendela informasi, wadah komunikasi, dan sarana partisipasi bagi seluruh warga.',
    'kadis_body' => 'Di era digital yang terus berkembang, keterbukaan informasi dan kemudahan akses layanan publik adalah kunci tata kelola pemerintahan yang baik dan terpercaya.<br><br>Melalui platform ini, kami berkomitmen untuk terus berinovasi dalam memberikan pelayanan terbaik, membangun Smart City yang inklusif, dan mewujudkan transformasi digital yang berkelanjutan demi Kota Bogor yang lebih maju.'
];

$res = $conn->query("SELECT COUNT(*) as c FROM site_settings");
if ($res && $res->fetch_assoc()['c'] == 0) {
    foreach ($defaults as $k => $v) {
        $vSafe = $conn->real_escape_string($v);
        $conn->query("INSERT INTO site_settings (setting_key, setting_value) VALUES ('$k', '$vSafe')");
    }
}

// Handle Form Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profil') {
    // Handle File Upload if exists
    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['foto_profil']['tmp_name'];
        $ext = strtolower(pathinfo($_FILES['foto_profil']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($ext, $allowed)) {
            $filename = 'kadis_' . time() . '.' . $ext;
            $uploadDir = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $destination = $uploadDir . $filename;
            if (move_uploaded_file($tmp, $destination)) {
                // Set the new URL
                $_POST['settings']['kadis_image'] = '/kominfov2/uploads/' . $filename;
            }
        }
    }

    $settingsData = $_POST['settings'] ?? [];
    foreach ($settingsData as $key => $val) {
        $valSafe = $conn->real_escape_string($val);
        $keySafe = $conn->real_escape_string($key);
        // Fallback for old URL if new photo wasn't uploaded
        if ($key === 'kadis_image' && empty($val)) {
            continue; // Skip updating image if it's empty (no new upload and URL cleared)
        }
        $conn->query("UPDATE site_settings SET setting_value='$valSafe' WHERE setting_key='$keySafe'");
    }
    echo "<script>alert('Profil dinas berhasil diperbarui'); window.location.href='profil.php';</script>";
}

// Fetch Current Settings
$res = $conn->query("SELECT * FROM site_settings");
$settings = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
}
$conn->close();
?>

<div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold m-0" style="color: #0f172a;">Edit Profil Kepala Dinas</h5>
    </div>
    <div class="card-body p-4">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="update_profil">
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card bg-light border-0">
                        <div class="card-body text-center">
                            <img src="<?= esc($settings['kadis_image'] ?? '') ?>" alt="Foto" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 250px; object-fit: cover;">
                            <div class="mb-3 text-start">
                                <label class="form-label fw-semibold">Upload Foto Baru (Opsional)</label>
                                <input type="file" class="form-control" name="foto_profil" accept="image/*">
                                <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP.</small>
                            </div>
                            <div class="mb-3 text-start">
                                <label class="form-label fw-semibold">Atau URL Foto</label>
                                <input type="url" class="form-control" name="settings[kadis_image]" value="<?= esc($settings['kadis_image'] ?? '') ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap & Gelar</label>
                        <input type="text" class="form-control" name="settings[kadis_name]" value="<?= esc($settings['kadis_name'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jabatan Pimpinan</label>
                        <textarea class="form-control" name="settings[kadis_title]" rows="2" required><?= esc($settings['kadis_title'] ?? '') ?></textarea>
                        <small class="text-muted">Gunakan &lt;br&gt; untuk membuat baris baru.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kalimat Sapaan</label>
                        <input type="text" class="form-control" name="settings[kadis_greeting]" value="<?= esc($settings['kadis_greeting'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kutipan Utama (Quote)</label>
                        <textarea class="form-control" name="settings[kadis_quote]" rows="3" required><?= esc($settings['kadis_quote'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Isi Pesan / Sambutan Lengkap</label>
                        <textarea class="form-control" name="settings[kadis_body]" rows="5" required><?= esc($settings['kadis_body'] ?? '') ?></textarea>
                        <small class="text-muted">Gunakan &lt;br&gt;&lt;br&gt; untuk memisahkan paragraf.</small>
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-sm px-4 py-2" style="background: linear-gradient(135deg, #0ea5e9, #3b82f6); color: white; font-weight: 600; border-radius: 8px; border: none;">
                            <i class="bi bi-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
