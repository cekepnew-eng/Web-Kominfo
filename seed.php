<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';
$conn = db_get_conn();

// Create comments table if not exists
$conn->query("
CREATE TABLE IF NOT EXISTS report_comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    report_id INT NOT NULL,
    parent_id INT NULL,
    commenter_name VARCHAR(100) NOT NULL,
    comment_text TEXT NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (report_id) REFERENCES reports(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES report_comments(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

$reports = [
    [
        'category' => 'Infrastruktur',
        'title' => 'Jalan Berlubang di area Kebun Raya',
        'description' => 'Terdapat lubang yang cukup dalam di jalan raya seputaran Kebun Raya Bogor, sangat membahayakan pengendara motor terutama saat hujan karena tertutup genangan air. Mohon segera ditindak karena sudah ada korban jatuh kemarin.',
        'lat' => -6.6002,
        'lng' => 106.7975,
        'address' => 'Jl. Ir. H. Juanda, Paledang, Bogor Tengah',
        'name' => 'Budi Santoso',
        'status' => 'in_progress',
        'img' => 'https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?auto=format&fit=crop&w=800&q=80' 
    ],
    [
        'category' => 'Kebersihan',
        'title' => 'Tumpukan Sampah di Pasar Anyar',
        'description' => 'Sampah menumpuk di pinggir jalan dekat area Pasar Anyar, sudah 3 hari belum diangkut oleh petugas. Menimbulkan bau tidak sedap dan sangat mengganggu pejalan kaki serta warga sekitar.',
        'lat' => -6.5940,
        'lng' => 106.7890,
        'address' => 'Pasar Anyar, Jl. Pengadilan, Bogor Tengah',
        'name' => 'Siti Aminah',
        'status' => 'pending_verification',
        'img' => 'https://images.unsplash.com/photo-1605600659873-d808a1d14f48?auto=format&fit=crop&w=800&q=80' 
    ],
    [
        'category' => 'Fasilitas Publik',
        'title' => 'Lampu PJU Padam di Pajajaran',
        'description' => 'Lampu Penerangan Jalan Umum (PJU) mati di beberapa titik sepanjang Jalan Pajajaran dekat Taman Kencana. Sangat gelap di malam hari dan rawan kecelakaan atau tindak kejahatan.',
        'lat' => -6.5898,
        'lng' => 106.8041,
        'address' => 'Jl. Pajajaran (Dekat Taman Kencana), Bogor Tengah',
        'name' => 'Andi Wijaya',
        'status' => 'resolved',
        'img' => 'https://images.unsplash.com/photo-1518047910543-9111e5f0d3a7?auto=format&fit=crop&w=800&q=80' 
    ],
    [
        'category' => 'Lalu Lintas',
        'title' => 'Kemacetan Parah Akibat Galian PDAM',
        'description' => 'Ada proyek galian pipa air yang memakan separuh jalan di area Tajur, tidak ada petugas yang mengatur lalu lintas sehingga menyebabkan kemacetan parah pada jam berangkat dan pulang kerja.',
        'lat' => -6.6341,
        'lng' => 106.8245,
        'address' => 'Jl. Raya Tajur, Bogor Selatan',
        'name' => 'Deni Pratama',
        'status' => 'in_progress',
        'img' => 'https://images.unsplash.com/photo-1613327663363-231a478b2737?auto=format&fit=crop&w=800&q=80' 
    ],
    [
        'category' => 'Fasilitas Publik',
        'title' => 'Fasilitas Taman Sempur Rusak',
        'description' => 'Beberapa alat olahraga dan bangku taman di area Taman Sempur mengalami kerusakan. Anak tangga juga banyak yang retak. Mohon agar diperbaiki demi kenyamanan pengunjung.',
        'lat' => -6.5888,
        'lng' => 106.7946,
        'address' => 'Taman Sempur, Sempur, Bogor Tengah',
        'name' => 'Lestari',
        'status' => 'pending_verification',
        'img' => 'https://images.unsplash.com/photo-1584464457692-7489ddbf3b02?auto=format&fit=crop&w=800&q=80'
    ]
];

$conn->query("SET FOREIGN_KEY_CHECKS=0;");
$conn->query("TRUNCATE TABLE reports;");
$conn->query("TRUNCATE TABLE report_images;");
$conn->query("TRUNCATE TABLE report_comments;");
$conn->query("SET FOREIGN_KEY_CHECKS=1;");

foreach ($reports as $r) {
    $ticket = 'BGR-' . strtoupper(substr(md5(uniqid()), 0, 8));
    $cat = $conn->real_escape_string($r['category']);
    $title = $conn->real_escape_string($r['title']);
    $desc = $conn->real_escape_string($r['description']);
    $addr = $conn->real_escape_string($r['address']);
    $name = $conn->real_escape_string($r['name']);
    $status = $conn->real_escape_string($r['status']);
    
    $sql = "INSERT INTO reports (ticket_number, category, title, description, latitude, longitude, address, reporter_name, status, likes_count) 
            VALUES ('$ticket', '$cat', '$title', '$desc', {$r['lat']}, {$r['lng']}, '$addr', '$name', '$status', " . rand(5, 42) . ")";
    $conn->query($sql);
    $report_id = $conn->insert_id;
    
    // Insert Image
    $imgUrl = $conn->real_escape_string($r['img']);
    $conn->query("INSERT INTO report_images (report_id, image_url, is_primary) VALUES ($report_id, '$imgUrl', 1)");

    // Insert dummy comments
    $conn->query("INSERT INTO report_comments (report_id, commenter_name, comment_text, is_admin) VALUES 
        ($report_id, 'Admin Diskominfo', 'Terima kasih atas laporan Anda. Laporan ini telah kami terima dan segera dikoordinasikan dengan dinas terkait.', 1)");
    $conn->query("INSERT INTO report_comments (report_id, commenter_name, comment_text, is_admin) VALUES 
        ($report_id, 'Warga Sekitar', 'Iya nih min, tolong segera diperbaiki karena kondisinya sangat mengganggu aktivitas warga.', 0)");
    $conn->query("INSERT INTO report_comments (report_id, commenter_name, comment_text, is_admin) VALUES 
        ($report_id, 'Kang Ojol', 'Sering banget lewat sini, bahaya banget kalau malem.', 0)");
}
echo "Dummy data generated successfully.";
