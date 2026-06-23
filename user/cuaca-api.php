<?php
declare(strict_types=1);
// Return the latest weather snapshot payload saved by admin (if any)
require_once __DIR__ . '/../includes/db.php';
header('Content-Type: application/json; charset=UTF-8');
$m = db_get_conn();
if (!$m) {
    http_response_code(404);
    echo json_encode(['error' => 'no-db']);
    exit;
}
$res = $m->query('SELECT payload FROM weather_snapshots ORDER BY id DESC LIMIT 1');
if (!$res) { http_response_code(404); echo json_encode(['error'=>'no-snapshot']); $m->close(); exit; }
$row = $res->fetch_assoc();
$res->free();
$m->close();
$payload = $row['payload'] ?? null;
if (!$payload) { http_response_code(404); echo json_encode(['error'=>'empty']); exit; }
// Validate JSON
$decoded = json_decode($payload, true);
if ($decoded === null) { http_response_code(500); echo json_encode(['error'=>'invalid-json']); exit; }
echo json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
