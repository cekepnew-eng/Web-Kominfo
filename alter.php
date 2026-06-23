<?php
require_once __DIR__ . '/includes/db.php';
$conn = db_get_conn();
if ($conn->query("ALTER TABLE report_comments ADD COLUMN parent_id INT DEFAULT NULL")) {
    echo "Added parent_id\n";
    $conn->query("ALTER TABLE report_comments ADD FOREIGN KEY (parent_id) REFERENCES report_comments(id) ON DELETE CASCADE");
    echo "Added foreign key\n";
} else {
    echo "Failed or already exists: " . $conn->error . "\n";
}
