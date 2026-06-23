<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/db.php';
header('Content-Type: application/json; charset=utf-8');

$conn = db_get_conn();
if ($conn === null) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// GET COMMENTS
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'get') {
    $report_id = (int)($_GET['report_id'] ?? 0);
    
    if ($report_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid report ID.']);
        exit;
    }

    $sql = "SELECT c.*, p.commenter_name as parent_name, p.comment_text as parent_text 
            FROM report_comments c 
            LEFT JOIN report_comments p ON c.parent_id = p.id 
            WHERE c.report_id = $report_id 
            ORDER BY c.created_at ASC";
    $res = $conn->query($sql);
    $comments = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $comments[] = [
                'id' => $row['id'],
                'commenter_name' => $row['commenter_name'],
                'comment_text' => $row['comment_text'],
                'is_admin' => (bool)$row['is_admin'],
                'parent_id' => $row['parent_id'],
                'parent_name' => $row['parent_name'],
                'parent_text' => $row['parent_text'],
                'created_at' => $row['created_at']
            ];
        }
    }
    
    echo json_encode(['success' => true, 'comments' => $comments]);
    exit;
}

// POST COMMENT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'post') {
    $report_id = (int)($_POST['report_id'] ?? 0);
    $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : 'NULL';
    $name = trim((string)($_POST['name'] ?? ''));
    $text = trim((string)($_POST['comment'] ?? ''));
    $is_admin = (int)($_POST['is_admin'] ?? 0);

    if ($report_id <= 0 || $name === '' || $text === '') {
        echo json_encode(['success' => false, 'message' => 'Semua kolom wajib diisi.']);
        exit;
    }

    $nameSafe = $conn->real_escape_string(htmlspecialchars($name, ENT_QUOTES));
    $textSafe = $conn->real_escape_string(htmlspecialchars($text, ENT_QUOTES));

    $sql = "INSERT INTO report_comments (report_id, commenter_name, comment_text, is_admin, parent_id) VALUES ($report_id, '$nameSafe', '$textSafe', $is_admin, $parent_id)";
    if ($conn->query($sql)) {
        echo json_encode(['success' => true, 'message' => 'Komentar terkirim.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal mengirim komentar.']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid action.']);
