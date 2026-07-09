<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/db.php';

$conn = db_get_conn();
if ($conn) {
    $tracking_data = [];
    $result = $conn->query("SELECT * FROM employee_tracking ORDER BY id DESC");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $tracking_data[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'phone' => $row['phone'],
                'lat' => (float)$row['lat'],
                'lng' => (float)$row['lng'],
                'locationName' => $row['location_name'],
                'status' => $row['status'],
                'stop_status' => $row['stop_status'] ?? 'none'
            ];
        }
    }
    echo json_encode(['status' => 'success', 'data' => $tracking_data]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No database connection']);
}
