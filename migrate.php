<?php
require_once __DIR__ . '/includes/db.php';

$conn = db_get_conn();
if (!$conn) {
    die("Gagal koneksi ke database.");
}

// Coba jalankan ALTER TABLE untuk menambahkan kolom stop_status
$sql = "ALTER TABLE employee_tracking ADD COLUMN stop_status VARCHAR(20) DEFAULT 'none'";

if ($conn->query($sql)) {
    echo "<h1>BERHASIL!</h1>";
    echo "<p>Kolom 'stop_status' berhasil ditambahkan ke database Anda di Railway.</p>";
} else {
    // Jika error karena kolom sudah ada (Duplicate column name)
    if (strpos($conn->error, 'Duplicate column name') !== false) {
        echo "<h1>SUDAH ADA!</h1>";
        echo "<p>Database sudah memiliki kolom 'stop_status', aman untuk digunakan.</p>";
    } else {
        echo "<h1>GAGAL / ERROR:</h1>";
        echo "<p>" . $conn->error . "</p>";
    }
}

echo "<br><a href='user/index.php'>Kembali ke Home</a>";
