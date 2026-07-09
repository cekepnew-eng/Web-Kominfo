<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/db.php';

$phone = $_GET['phone'] ?? '';

if(empty($phone)) {
    echo json_encode(['status' => 'error', 'message' => 'Phone is required']);
    exit;
}

$conn = db_get_conn();
if ($conn) {
    $stmt = $conn->prepare("SELECT stop_status FROM employee_tracking WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode(['status' => 'success', 'stop_status' => $row['stop_status']]);
        
        // Jika sudah di-approve, kita kembalikan statusnya ke 'none' 
        // agar kalau user mulai lagi, dia bisa stop request lagi nanti.
        if ($row['stop_status'] === 'approved') {
            $stmt2 = $conn->prepare("UPDATE employee_tracking SET stop_status = 'none' WHERE phone = ?");
            $stmt2->bind_param("s", $phone);
            $stmt2->execute();
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No database connection']);
}
