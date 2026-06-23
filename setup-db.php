<?php
declare(strict_types=1);

$host = '127.0.0.1';
$user = 'root';
$pass = '';

$conn = @new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Koneksi ke MySQL gagal: " . $conn->connect_error . "\nPastikan MySQL berjalan di Laragon/XAMPP.");
}

// Buat database jika belum ada
$sql = "CREATE DATABASE IF NOT EXISTS kominfov2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if (!$conn->query($sql)) {
    die("Gagal membuat database: " . $conn->error);
}
echo "Database 'kominfov2' OK.\n";

$conn->select_db('kominfov2');

// Tabel reports
$sqlReports = "
CREATE TABLE IF NOT EXISTS reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_number VARCHAR(50) NOT NULL UNIQUE,
    category VARCHAR(50) NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    latitude DECIMAL(10, 8) NOT NULL,
    longitude DECIMAL(11, 8) NOT NULL,
    address VARCHAR(255) NOT NULL,
    reporter_name VARCHAR(100) NULL,
    reporter_contact VARCHAR(50) NULL,
    status VARCHAR(50) DEFAULT 'pending_verification',
    likes_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (ticket_number),
    INDEX (status),
    INDEX (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

if (!$conn->query($sqlReports)) {
    die("Gagal membuat tabel reports: " . $conn->error);
}
echo "Tabel 'reports' OK.\n";

// Tabel report_images
$sqlImages = "
CREATE TABLE IF NOT EXISTS report_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    report_id INT NOT NULL,
    image_url VARCHAR(500) NOT NULL,
    is_primary TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (report_id) REFERENCES reports(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

if (!$conn->query($sqlImages)) {
    die("Gagal membuat tabel report_images: " . $conn->error);
}
echo "Tabel 'report_images' OK.\n";

// Tabel report_status_history
$sqlHistory = "
CREATE TABLE IF NOT EXISTS report_status_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    report_id INT NOT NULL,
    status VARCHAR(50) NOT NULL,
    note TEXT NULL,
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (report_id) REFERENCES reports(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

if (!$conn->query($sqlHistory)) {
    die("Gagal membuat tabel report_status_history: " . $conn->error);
}
echo "Tabel 'report_status_history' OK.\n";

// Tabel cctv_streams
$conn->query("DROP TABLE IF EXISTS cctv_streams");
$sqlCctv = "
CREATE TABLE cctv_streams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    external_id VARCHAR(50) NULL,
    name VARCHAR(150) NOT NULL,
    stream_url VARCHAR(500) NOT NULL,
    detail_url VARCHAR(500) NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";
if (!$conn->query($sqlCctv)) die("Gagal membuat tabel cctv: " . $conn->error);
echo "Tabel 'cctv_streams' OK.\n";

$conn->query("INSERT INTO cctv_streams (external_id, name, stream_url, detail_url) VALUES 
    ('76', 'Simpang Kapten Muslihat-Djuanda', 'https://restreamer2.kotabogor.go.id/memfs/3ec6eaf2-4da1-4adb-8c15-0251e69121d6.m3u8', 'https://bsw.kotabogor.go.id/cctv/76/detail'),
    ('79', 'Simpang Tugu Kujang', 'https://restreamer2.kotabogor.go.id/memfs/5a5cf878-9d9b-4400-a73a-27a5b24a6ec4.m3u8', 'https://bsw.kotabogor.go.id/cctv/79/detail'),
    ('82', 'Depan Alun Alun', 'https://restreamer2.kotabogor.go.id/memfs/c07c1926-288c-46e4-a19c-9f51022edc5d.m3u8', 'https://bsw.kotabogor.go.id/cctv/82/detail'),
    ('83', 'Pasar Bogor', 'https://restreamer2.kotabogor.go.id/memfs/b43066d4-b1e4-4e90-8e17-86c15a9a944e.m3u8', 'https://bsw.kotabogor.go.id/cctv/83/detail'),
    ('85', 'Juanda', 'https://restreamer2.kotabogor.go.id/memfs/62cded1f-90d0-4af6-b330-dc40af5fdd67.m3u8', 'https://bsw.kotabogor.go.id/cctv/85/detail'),
    ('86', 'Seketeng Surken', 'https://restreamer2.kotabogor.go.id/memfs/3d51d3a1-0d90-4230-956c-60dea3c11ac3.m3u8', 'https://bsw.kotabogor.go.id/cctv/86/detail')
");

// Tabel news_articles
$conn->query("DROP TABLE IF EXISTS news_articles");
$sqlNews = "
CREATE TABLE news_articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(500) NULL,
    source VARCHAR(100) DEFAULT 'kotabogor.go.id',
    published VARCHAR(100) NOT NULL,
    published_iso TIMESTAMP NULL,
    excerpt TEXT NOT NULL,
    image VARCHAR(500) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";
if (!$conn->query($sqlNews)) die("Gagal membuat tabel news: " . $conn->error);
echo "Tabel 'news_articles' OK.\n";

$conn->query("INSERT INTO news_articles (title, url, source, published, published_iso, excerpt, image) VALUES 
    ('Program Smart City Kota Bogor Raih Penghargaan', 'https://kotabogor.go.id/berita', 'kotabogor.go.id', 'Update terbaru', CURRENT_TIMESTAMP, 'Pemerintah Kota Bogor kembali meraih penghargaan nasional...', 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=600&q=80'),
    ('Diskominfo Luncurkan Sistem Pengaduan Digital Terintegrasi', 'https://kotabogor.go.id/berita', 'kotabogor.go.id', 'Update terbaru', CURRENT_TIMESTAMP, 'Diskominfo meluncurkan integrasi terbaru untuk pengaduan...', 'https://images.unsplash.com/photo-1496171367470-9ed9a91ea931?w=600&q=80'),
    ('Pembangunan Infrastruktur Jaringan Fiber Optik di 68 Kelurahan', 'https://kotabogor.go.id/berita', 'kotabogor.go.id', 'Update terbaru', CURRENT_TIMESTAMP, 'Pembangunan infrastruktur FO ini bertujuan untuk meningkatkan aksesibilitas internet...', 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&q=80')
");

$conn->close();
echo "Setup database selesai!\n";
