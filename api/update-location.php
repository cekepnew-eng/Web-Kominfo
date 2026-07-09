<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/db.php';

// Cek method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid method']);
    exit;
}

$conn = db_get_conn();
if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

// Ambil data JSON dari body
$input = json_decode(file_get_contents('php://input'), true);

$phone = $input['phone'] ?? '';
$lat = $input['lat'] ?? '';
$lng = $input['lng'] ?? '';

if (empty($phone) || empty($lat) || empty($lng)) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    exit;
}

$phone = $conn->real_escape_string($phone);
$lat = (float)$lat;
$lng = (float)$lng;

// Cek apakah nomor ada di database
$check = $conn->query("SELECT id FROM employee_tracking WHERE phone = '$phone'");

if ($check && $check->num_rows > 0) {
    // Update lokasi
    $sql = "UPDATE employee_tracking SET 
            lat = $lat, 
            lng = $lng, 
            status = 'Akurat (GPS Realtime)',
            created_at = CURRENT_TIMESTAMP 
            WHERE phone = '$phone'";
            
    if ($conn->query($sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Lokasi berhasil diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui database']);
    }
} else {
    // Jika belum terdaftar, masukkan sebagai nomor baru secara otomatis
    $sql_insert = "INSERT INTO employee_tracking (name, phone, lat, lng, location_name, status) 
                   VALUES ('Target Baru (Otomatis)', '$phone', $lat, $lng, 'Terdeteksi dari Share Location', 'Akurat (GPS Realtime)')";
                   
    if ($conn->query($sql_insert)) {
        echo json_encode(['status' => 'success', 'message' => 'Nomor baru berhasil ditambahkan dan lokasi diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mendaftarkan nomor baru']);
    }
}
