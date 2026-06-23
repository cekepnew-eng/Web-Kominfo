<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/report-service.php';

$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

if ($method === 'POST') {
    $payload = [
        'category' => $_POST['category'] ?? '',
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'latitude' => $_POST['latitude'] ?? '',
        'longitude' => $_POST['longitude'] ?? '',
        'address' => $_POST['address'] ?? '',
        'reporter_name' => $_POST['reporter_name'] ?? '',
        'reporter_contact' => $_POST['reporter_contact'] ?? '',
    ];

    $files = $_FILES['images'] ?? [];
    $result = report_create($payload, $files);

    if (!$result['success']) {
        report_json_response($result, 422);
        exit;
    }

    report_json_response($result, 201);
    exit;
}

if ($method !== 'GET') {
    report_json_response(['success' => false, 'message' => 'Method not allowed.'], 405);
    exit;
}

$ticket = trim((string) ($_GET['ticket'] ?? ''));
if ($ticket !== '') {
    $report = report_get_by_ticket($ticket);
    if ($report === null) {
        report_json_response(['success' => false, 'message' => 'Nomor tiket tidak ditemukan.'], 404);
        exit;
    }
    report_json_response(['success' => true, 'report' => $report]);
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id > 0) {
    $report = report_get_by_id($id);
    if ($report === null) {
        report_json_response(['success' => false, 'message' => 'Laporan tidak ditemukan.'], 404);
        exit;
    }
    report_json_response(['success' => true, 'report' => $report]);
    exit;
}

$filters = [
    'category' => trim((string) ($_GET['category'] ?? '')),
    'status' => trim((string) ($_GET['status'] ?? '')),
    'lat' => $_GET['lat'] ?? null,
    'lng' => $_GET['lng'] ?? null,
    'radius' => $_GET['radius'] ?? null,
    'limit' => $_GET['limit'] ?? null,
];

$result = report_list($filters);
report_json_response($result);
