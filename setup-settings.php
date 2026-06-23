<?php
require_once __DIR__ . '/includes/db.php';
$conn = db_get_conn();

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

foreach ($defaults as $k => $v) {
    $vSafe = $conn->real_escape_string($v);
    $conn->query("INSERT IGNORE INTO site_settings (setting_key, setting_value) VALUES ('$k', '$vSafe')");
}

echo "Tabel site_settings berhasil dibuat dan diisi.";
$conn->close();
