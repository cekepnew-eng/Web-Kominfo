<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$phone = $data['phone'] ?? '';

if(empty($phone)) {
    echo json_encode(['status' => 'error', 'message' => 'Phone is required']);
    exit;
}

$conn = db_get_conn();
if ($conn) {
    $stmt = $conn->prepare("UPDATE employee_tracking SET stop_status = 'requested' WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No database connection']);
}
