<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/report-service.php'; // to get enum constants

$conn = db_get_conn();
if (!$conn) die("DB Connection failed");

$conn->query("SET FOREIGN_KEY_CHECKS = 0");
$conn->query("TRUNCATE TABLE report_status_history");
$conn->query("TRUNCATE TABLE report_images");
$conn->query("TRUNCATE TABLE komentar");
$conn->query("TRUNCATE TABLE report_likes");
$conn->query("TRUNCATE TABLE reports");
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

$dummies = [
    [
        'ticket' => 'LP-20260707-0001',
        'category' => 'cctv_rusak',
        'title' => 'CCTV Simpang Tol BORR Rusak/Mati',
        'desc' => 'Kamera pengawas (CCTV) di simpang masuk Tol BORR arah Yasmin terpantau mati total sejak kemarin sore. Mohon segera diperbaiki karena titik tersebut rawan kemacetan.',
        'lat' => -6.5621,
        'lng' => 106.7924,
        'address' => 'Jl. K.H. Sholeh Iskandar, Bogor Utara',
        'status' => 'in_progress',
        'img' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&w=800&q=80'
    ],
    [
        'ticket' => 'LP-20260707-0002',
        'category' => 'internet_lemot',
        'title' => 'WiFi Publik Taman Sempur Lemot',
        'desc' => 'Koneksi WiFi gratis "Free Wifi Kota Bogor" di area Taman Sempur bisa tersambung tapi tidak bisa dipakai akses internet (sangat lambat).',
        'lat' => -6.5894,
        'lng' => 106.7946,
        'address' => 'Taman Sempur, Bogor Tengah',
        'status' => 'pending_verification',
        'img' => 'https://images.unsplash.com/photo-1563206767-5b18f218e8de?auto=format&fit=crop&w=800&q=80'
    ],
    [
        'ticket' => 'LP-20260707-0003',
        'category' => 'website_error',
        'title' => 'Aplikasi Antrian RSUD Error',
        'desc' => 'Saat mencoba mendaftar antrian via aplikasi RSUD Kota Bogor, selalu muncul pesan "Internal Server Error 500".',
        'lat' => -6.5815,
        'lng' => 106.7728,
        'address' => 'RSUD Kota Bogor, Menteng, Bogor Barat',
        'status' => 'verified',
        'img' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=800&q=80'
    ],
    [
        'ticket' => 'LP-20260707-0004',
        'category' => 'judi_online',
        'title' => 'Spanduk & Link Judi Online di Warnet Tajur',
        'desc' => 'Ditemukan promosi situs perjudian online yang terpasang sebagai homepage default di salah satu warnet daerah Tajur.',
        'lat' => -6.6341,
        'lng' => 106.8241,
        'address' => 'Jl. Raya Tajur, Bogor Selatan',
        'status' => 'resolved',
        'img' => 'https://images.unsplash.com/photo-1518133835878-5a93cc3f89e5?auto=format&fit=crop&w=800&q=80'
    ],
    [
        'ticket' => 'LP-20260707-0005',
        'category' => 'keamanan_siber',
        'title' => 'Penipuan Phising Mengatasnamakan Bansos Pemkot',
        'desc' => 'Banyak warga menerima SMS berisi link phising berbahaya yang mengatasnamakan undian bansos dari Pemkot Bogor. Mohon segera di-take down situs tersebut.',
        'lat' => -6.5947,
        'lng' => 106.7891,
        'address' => 'Balai Kota Bogor, Bogor Tengah',
        'status' => 'pending_verification',
        'img' => 'https://images.unsplash.com/photo-1510511459012-914015f9b4dd?auto=format&fit=crop&w=800&q=80'
    ]
];

foreach ($dummies as $d) {
    $stmt = $conn->prepare("INSERT INTO reports (ticket_number, category, title, description, latitude, longitude, address, reporter_name, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'Anonim', ?, NOW())");
    $stmt->bind_param("ssssddss", $d['ticket'], $d['category'], $d['title'], $d['desc'], $d['lat'], $d['lng'], $d['address'], $d['status']);
    $stmt->execute();
    $id = $stmt->insert_id;
    $stmt->close();

    $stmt2 = $conn->prepare("INSERT INTO report_images (report_id, image_url, is_primary) VALUES (?, ?, 1)");
    $stmt2->bind_param("is", $id, $d['img']);
    $stmt2->execute();
    $stmt2->close();
}

echo "Database seeded successfully.\n";
