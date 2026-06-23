<?php
require_once __DIR__ . '/includes/db.php';
$conn = db_get_conn();
if ($conn->query("ALTER TABLE reports ADD COLUMN likes_count INT DEFAULT 0")) {
    echo "likes_count added successfully\n";
} else {
    echo "Error or already exists: " . $conn->error . "\n";
}
