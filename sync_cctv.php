<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/services.php';

$conn = db_get_conn();

echo "Mulai mengambil data dari bsw.kotabogor.go.id/cctv...\n";

// Mengambil HTML halaman utama CCTV
$listing = http_get_simple('https://bsw.kotabogor.go.id/cctv', 30);
if (!$listing) {
    die("Gagal memuat halaman utama BSW CCTV.\n");
}

// Mencari semua link detail
preg_match_all('/<a[^>]+href="https:\/\/bsw\.kotabogor\.go\.id\/cctv\/(\d+)\/detail"[^>]*>(.*?)<\/a>/is', $listing, $matches, PREG_SET_ORDER);

if (empty($matches)) {
    die("Tidak ada CCTV yang ditemukan.\n");
}

echo "Ditemukan " . count($matches) . " link CCTV potensial. Mulai mengekstrak stream m3u8...\n";

$inserted = 0;
$unique = [];

foreach ($matches as $match) {
    $id = $match[1];
    
    // Hindari duplikat
    if (isset($unique[$id])) {
        continue;
    }
    $unique[$id] = true;

    $rawName = trim(strip_tags($match[2]));
    $name = preg_replace('/^CCTV\s*[-:]*\s*/i', '', $rawName);
    $name = $name !== '' ? $name : ('CCTV ' . $id);

    $detailUrl = 'https://bsw.kotabogor.go.id/cctv/' . $id . '/detail';
    
    // Ambil halaman detail untuk mencari link m3u8
    $detailHtml = http_get_simple($detailUrl, 15);
    if ($detailHtml === null) {
        echo "Gagal memuat detail $id. Lewati.\n";
        continue;
    }

    if (!preg_match('/https:\/\/restreamer2\.kotabogor\.go\.id\/memfs\/[^"\'\s<>]+\.m3u8/i', $detailHtml, $streamMatch)) {
        // Coba restreamer alternatif jika ada
        if (!preg_match('/https:\/\/[^"\'\s<>]+\.m3u8/i', $detailHtml, $streamMatch)) {
            echo "Gagal menemukan m3u8 untuk $name ($id). Lewati.\n";
            continue;
        }
    }

    $streamUrl = $streamMatch[0];

    // Cek apakah sudah ada di DB
    $stmt = $conn->prepare("SELECT id FROM cctv_streams WHERE external_id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $exists = $res->fetch_assoc();
    $stmt->close();

    if (!$exists) {
        $insert = $conn->prepare("INSERT INTO cctv_streams (external_id, name, stream_url, detail_url, is_active) VALUES (?, ?, ?, ?, 1)");
        $insert->bind_param("ssss", $id, $name, $streamUrl, $detailUrl);
        $insert->execute();
        $insert->close();
        echo " [+] Berhasil menambahkan: $name\n";
        $inserted++;
    } else {
        echo " [~] Sudah ada di database: $name\n";
    }
}

echo "Selesai! Berhasil menambahkan $inserted CCTV baru.\n";
