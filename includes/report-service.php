<?php
declare(strict_types=1);

require_once __DIR__ . '/services.php';
require_once __DIR__ . '/db.php';

const REPORT_CATEGORIES = [
    'cctv_rusak' => 'CCTV Rusak',
    'internet_lemot' => 'Internet/WiFi Lemot',
    'website_error' => 'Website Error',
    'keamanan_siber' => 'Keamanan Siber/Phising',
    'judi_online' => 'Judi Online',
    'lainnya' => 'Lainnya',
];

const REPORT_STATUSES = [
    'pending_verification' => 'Menunggu Verifikasi',
    'verified' => 'Terverifikasi',
    'in_progress' => 'Sedang Diproses',
    'resolved' => 'Selesai',
    'rejected' => 'Ditolak',
];

const REPORT_STATUS_COLORS = [
    'pending_verification' => '#eab308',
    'verified' => '#316bda',
    'in_progress' => '#2563eb',
    'resolved' => '#16a34a',
    'rejected' => '#94a3b8',
];

const REPORT_ALLOWED_MIMES = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp',
];

const REPORT_MAX_IMAGE_BYTES = 5 * 1024 * 1024;
const REPORT_MAX_IMAGES = 5;

function report_upload_dir(): string
{
    $dir = __DIR__ . '/../uploads/reports';
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    return $dir;
}

function report_sanitize_text(string $value, int $maxLength): string
{
    $clean = clean_text($value);
    if (mb_strlen($clean, 'UTF-8') > $maxLength) {
        $clean = mb_substr($clean, 0, $maxLength, 'UTF-8');
    }
    return $clean;
}

function report_generate_ticket_number(mysqli $conn): string
{
    $datePart = date('Ymd');
    $prefix = 'LP-' . $datePart . '-';

    $stmt = $conn->prepare('SELECT COUNT(*) AS total FROM reports WHERE ticket_number LIKE ?');
    $like = $prefix . '%';
    $stmt->bind_param('s', $like);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    $sequence = ((int) ($row['total'] ?? 0)) + 1;
    return $prefix . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
}

function report_validate_payload(array $data): array
{
    $errors = [];

    $category = trim((string) ($data['category'] ?? ''));
    if ($category === '' || !isset(REPORT_CATEGORIES[$category])) {
        $errors['category'] = 'Kategori wajib dipilih.';
    }

    $title = report_sanitize_text((string) ($data['title'] ?? ''), 100);
    if ($title === '') {
        $errors['title'] = 'Judul laporan wajib diisi.';
    } elseif (mb_strlen($title, 'UTF-8') > 100) {
        $errors['title'] = 'Judul maksimal 100 karakter.';
    }

    $description = report_sanitize_text((string) ($data['description'] ?? ''), 5000);
    if ($description === '') {
        $errors['description'] = 'Deskripsi wajib diisi.';
    }

    $latitude = filter_var($data['latitude'] ?? null, FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($data['longitude'] ?? null, FILTER_VALIDATE_FLOAT);
    if ($latitude === false || $longitude === false) {
        $errors['location'] = 'Lokasi wajib dipilih di peta.';
    } elseif ($latitude < -90 || $latitude > 90 || $longitude < -180 || $longitude > 180) {
        $errors['location'] = 'Koordinat lokasi tidak valid.';
    }

    $address = report_sanitize_text((string) ($data['address'] ?? ''), 512);
    $reporterName = report_sanitize_text((string) ($data['reporter_name'] ?? ''), 100);
    $reporterContact = report_sanitize_text((string) ($data['reporter_contact'] ?? ''), 50);

    if ($reporterContact !== '' && !preg_match('/^[\d\s+\-@.a-zA-Z]{5,50}$/', $reporterContact)) {
        $errors['reporter_contact'] = 'Format kontak tidak valid.';
    }

    return [
        'errors' => $errors,
        'valid' => empty($errors),
        'data' => [
            'category' => $category,
            'title' => $title,
            'description' => $description,
            'latitude' => (float) $latitude,
            'longitude' => (float) $longitude,
            'address' => $address,
            'reporter_name' => $reporterName !== '' ? $reporterName : null,
            'reporter_contact' => $reporterContact !== '' ? $reporterContact : null,
        ],
    ];
}

function report_validate_uploaded_files(array $files): array
{
    $errors = [];
    $normalized = [];

    if (!isset($files['name']) || !is_array($files['name'])) {
        return ['errors' => ['images' => 'Minimal 1 foto wajib diunggah.'], 'files' => []];
    }

    $count = count($files['name']);
    if ($count < 1) {
        return ['errors' => ['images' => 'Minimal 1 foto wajib diunggah.'], 'files' => []];
    }
    if ($count > REPORT_MAX_IMAGES) {
        return ['errors' => ['images' => 'Maksimal ' . REPORT_MAX_IMAGES . ' foto.'], 'files' => []];
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);

    for ($i = 0; $i < $count; $i++) {
        $error = (int) ($files['error'][$i] ?? UPLOAD_ERR_NO_FILE);
        if ($error === UPLOAD_ERR_NO_FILE) {
            continue;
        }
        if ($error !== UPLOAD_ERR_OK) {
            $errors['images'] = 'Gagal mengunggah foto.';
            break;
        }

        $tmpName = (string) ($files['tmp_name'][$i] ?? '');
        $size = (int) ($files['size'][$i] ?? 0);
        if ($size <= 0 || $size > REPORT_MAX_IMAGE_BYTES) {
            $errors['images'] = 'Ukuran foto maksimal 5MB per file.';
            break;
        }

        $mime = $finfo->file($tmpName) ?: '';
        if (!isset(REPORT_ALLOWED_MIMES[$mime])) {
            $errors['images'] = 'Format foto harus JPG, PNG, atau WEBP.';
            break;
        }

        $normalized[] = [
            'tmp_name' => $tmpName,
            'mime' => $mime,
            'ext' => REPORT_ALLOWED_MIMES[$mime],
            'size' => $size,
        ];
    }

    if (empty($normalized) && !isset($errors['images'])) {
        $errors['images'] = 'Minimal 1 foto wajib diunggah.';
    }

    return ['errors' => $errors, 'files' => $normalized];
}

function report_store_images(array $files): array
{
    $stored = [];
    $uploadDir = report_upload_dir();
    $subdir = date('Y/m');
    $targetDir = $uploadDir . '/' . $subdir;

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    foreach ($files as $index => $file) {
        $filename = sprintf('%s_%s.%s', date('YmdHis'), bin2hex(random_bytes(6)), $file['ext']);
        $absolutePath = $targetDir . '/' . $filename;
        $relativePath = 'uploads/reports/' . $subdir . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $absolutePath)) {
            throw new RuntimeException('Gagal menyimpan foto laporan.');
        }

        $stored[] = [
            'path' => $relativePath,
            'is_primary' => $index === 0,
        ];
    }

    return $stored;
}

function report_create(array $payload, array $uploadedFiles): array
{
    $validation = report_validate_payload($payload);
    if (!$validation['valid']) {
        return ['success' => false, 'errors' => $validation['errors']];
    }

    $fileValidation = report_validate_uploaded_files($uploadedFiles);
    if (!empty($fileValidation['errors'])) {
        return ['success' => false, 'errors' => $fileValidation['errors']];
    }

    $conn = db_get_conn();
    if ($conn === null) {
        return ['success' => false, 'message' => 'Koneksi database gagal.'];
    }

    try {
        $conn->begin_transaction();

        $ticketNumber = report_generate_ticket_number($conn);
        $data = $validation['data'];
        $status = 'pending_verification';

        $category = $data['category'];
        $title = $data['title'];
        $description = $data['description'];
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        $address = $data['address'];
        $reporterName = $data['reporter_name'];
        $reporterContact = $data['reporter_contact'];

        $stmt = $conn->prepare(
            'INSERT INTO reports (ticket_number, category, title, description, latitude, longitude, address, reporter_name, reporter_contact, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->bind_param(
            'ssssddssss',
            $ticketNumber,
            $category,
            $title,
            $description,
            $latitude,
            $longitude,
            $address,
            $reporterName,
            $reporterContact,
            $status
        );
        $stmt->execute();
        $reportId = (int) $stmt->insert_id;
        $stmt->close();

        $storedImages = report_store_images($fileValidation['files']);
        $imgStmt = $conn->prepare('INSERT INTO report_images (report_id, image_url, is_primary) VALUES (?, ?, ?)');
        foreach ($storedImages as $image) {
            $isPrimary = $image['is_primary'] ? 1 : 0;
            $imgStmt->bind_param('isi', $reportId, $image['path'], $isPrimary);
            $imgStmt->execute();
        }
        $imgStmt->close();

        $histStmt = $conn->prepare('INSERT INTO report_status_history (report_id, status, note) VALUES (?, ?, ?)');
        $note = 'Laporan diterima sistem.';
        $histStmt->bind_param('iss', $reportId, $status, $note);
        $histStmt->execute();
        $histStmt->close();

        $conn->commit();
        $conn->close();

        return [
            'success' => true,
            'ticket_number' => $ticketNumber,
            'status' => $status,
            'message' => 'Laporan berhasil dikirim dan akan diverifikasi dalam 1-2 hari kerja.',
        ];
    } catch (Throwable $e) {
        $conn->rollback();
        $conn->close();
        return ['success' => false, 'message' => 'Gagal menyimpan laporan. Silakan coba lagi.'];
    }
}

function report_haversine_sql(float $lat, float $lng, float $radiusKm): string
{
    return sprintf(
        '(6371 * acos(cos(radians(%F)) * cos(radians(latitude)) * cos(radians(longitude) - radians(%F)) + sin(radians(%F)) * sin(radians(latitude)))) <= %F',
        $lat,
        $lng,
        $lat,
        $radiusKm
    );
}

function report_list(array $filters = []): array
{
    $conn = db_get_conn();
    if ($conn === null) {
        return ['success' => false, 'message' => 'Koneksi database gagal.'];
    }

    $conditions = ['1=1'];
    $types = '';
    $params = [];

    if (!empty($filters['category']) && isset(REPORT_CATEGORIES[$filters['category']])) {
        $conditions[] = 'r.category = ?';
        $types .= 's';
        $params[] = $filters['category'];
    }

    if (!empty($filters['status']) && isset(REPORT_STATUSES[$filters['status']])) {
        $conditions[] = 'r.status = ?';
        $types .= 's';
        $params[] = $filters['status'];
    }

    $lat = isset($filters['lat']) ? filter_var($filters['lat'], FILTER_VALIDATE_FLOAT) : false;
    $lng = isset($filters['lng']) ? filter_var($filters['lng'], FILTER_VALIDATE_FLOAT) : false;
    $radius = isset($filters['radius']) ? (float) $filters['radius'] : 5.0;
    $radius = max(0.5, min(50.0, $radius));

    if ($lat !== false && $lng !== false) {
        $conditions[] = report_haversine_sql((float) $lat, (float) $lng, $radius);
    }

    $limit = isset($filters['limit']) ? (int) $filters['limit'] : 100;
    $limit = max(1, min(500, $limit));

    $sql = 'SELECT r.id, r.ticket_number, r.category, r.title, r.description, r.latitude, r.longitude,
                   r.address, r.status, r.created_at, r.likes_count,
                   (SELECT image_url FROM report_images WHERE report_id = r.id AND is_primary = 1 LIMIT 1) AS primary_image
            FROM reports r
            WHERE ' . implode(' AND ', $conditions) . '
            ORDER BY r.created_at DESC
            LIMIT ' . $limit;

    $stmt = $conn->prepare($sql);
    if ($types !== '') {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $items = [];

    while ($row = $result->fetch_assoc()) {
        $items[] = report_format_row($row);
    }

    $stmt->close();
    $conn->close();

    return ['success' => true, 'items' => $items, 'total' => count($items)];
}

function report_format_row(array $row): array
{
    $status = (string) ($row['status'] ?? 'pending_verification');
    $category = (string) ($row['category'] ?? '');

    return [
        'id' => (int) ($row['id'] ?? 0),
        'ticket_number' => (string) ($row['ticket_number'] ?? ''),
        'category' => $category,
        'category_label' => REPORT_CATEGORIES[$category] ?? $category,
        'title' => (string) ($row['title'] ?? ''),
        'description' => (string) ($row['description'] ?? ''),
        'latitude' => (float) ($row['latitude'] ?? 0),
        'longitude' => (float) ($row['longitude'] ?? 0),
        'address' => (string) ($row['address'] ?? ''),
        'status' => $status,
        'status_label' => REPORT_STATUSES[$status] ?? $status,
        'status_color' => REPORT_STATUS_COLORS[$status] ?? '#94a3b8',
        'primary_image' => (string) ($row['primary_image'] ?? ''),
        'likes_count' => (int) ($row['likes_count'] ?? 0),
        'created_at' => (string) ($row['created_at'] ?? ''),
    ];
}

function report_get_by_id(int $id): ?array
{
    $conn = db_get_conn();
    if ($conn === null || $id <= 0) {
        return null;
    }

    $stmt = $conn->prepare(
        'SELECT r.*, (SELECT image_url FROM report_images WHERE report_id = r.id AND is_primary = 1 LIMIT 1) AS primary_image
         FROM reports r WHERE r.id = ? LIMIT 1'
    );
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if (!$row) {
        $conn->close();
        return null;
    }

    $report = report_format_row($row);
    $report['reporter_name'] = $row['reporter_name'] ?? null;
    $report['reporter_contact'] = $row['reporter_contact'] ?? null;

    $imgStmt = $conn->prepare('SELECT image_url, is_primary FROM report_images WHERE report_id = ? ORDER BY is_primary DESC, id ASC');
    $imgStmt->bind_param('i', $id);
    $imgStmt->execute();
    $imgResult = $imgStmt->get_result();
    $images = [];
    while ($img = $imgResult->fetch_assoc()) {
        $images[] = [
            'url' => (string) ($img['image_url'] ?? ''),
            'is_primary' => (bool) ($img['is_primary'] ?? false),
        ];
    }
    $imgStmt->close();

    $histStmt = $conn->prepare('SELECT status, note, changed_at FROM report_status_history WHERE report_id = ? ORDER BY changed_at ASC');
    $histStmt->bind_param('i', $id);
    $histStmt->execute();
    $histResult = $histStmt->get_result();
    $history = [];
    while ($hist = $histResult->fetch_assoc()) {
        $histStatus = (string) ($hist['status'] ?? '');
        $history[] = [
            'status' => $histStatus,
            'status_label' => REPORT_STATUSES[$histStatus] ?? $histStatus,
            'note' => (string) ($hist['note'] ?? ''),
            'changed_at' => (string) ($hist['changed_at'] ?? ''),
        ];
    }
    $histStmt->close();
    $conn->close();

    $report['images'] = $images;
    $report['history'] = $history;

    return $report;
}

function report_get_by_ticket(string $ticketNumber): ?array
{
    $conn = db_get_conn();
    if ($conn === null) {
        return null;
    }

    $ticketNumber = trim($ticketNumber);
    $stmt = $conn->prepare('SELECT id FROM reports WHERE ticket_number = ? LIMIT 1');
    $stmt->bind_param('s', $ticketNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    if (!$row) {
        return null;
    }

    return report_get_by_id((int) $row['id']);
}

function report_json_response(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=UTF-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
