<?php
require 'includes/db.php';
$conn = db_get_conn();
$sql = "INSERT INTO report_comments (report_id, commenter_name, comment_text, is_admin, parent_id) VALUES (1, 'Test', 'Test comment', 0, NULL)";
if ($conn->query($sql)) {
    echo "Success\n";
} else {
    echo "Error: " . $conn->error . "\n";
}
