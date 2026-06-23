<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';

$conn = db_get_conn();
if ($conn === null) {
    die("Database connection failed.\n");
}

// Drop old tables from previous plan
$conn->query("DROP TABLE IF EXISTS report_comments");
$conn->query("DROP TABLE IF EXISTS users");

// Create new report_comments table
$sqlComments = "
CREATE TABLE IF NOT EXISTS report_comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    report_id INT NOT NULL,
    commenter_name VARCHAR(150) NOT NULL,
    comment_text TEXT NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (report_id) REFERENCES reports(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

if (!$conn->query($sqlComments)) {
    die("Failed to create report_comments table: " . $conn->error);
}
echo "Table 'report_comments' created successfully.\n";

echo "Database updated successfully!\n";
