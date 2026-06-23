<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/db.php';

$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$reportId = isset($_POST['report_id']) ? (int) $_POST['report_id'] : 0;
if ($reportId <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid report ID']);
    exit;
}

$conn = db_get_conn();
if ($conn) {
    $conn->query("UPDATE reports SET likes_count = likes_count + 1 WHERE id = $reportId");
    
    $res = $conn->query("SELECT likes_count FROM reports WHERE id = $reportId");
    $likes = 0;
    if ($row = $res->fetch_assoc()) {
        $likes = (int) $row['likes_count'];
    }
    $conn->close();
    
    echo json_encode(['success' => true, 'likes_count' => $likes]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'DB error']);
}
