<?php
declare(strict_types=1);

$pageTitle = 'Kelola Komentar';
$activePage = 'komentar';
require_once __DIR__ . '/includes/header.php';

$conn = db_get_conn();

// Handle Delete Comment
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = (int) $_POST['id'];
    $conn->query("DELETE FROM report_comments WHERE id = $id");
    echo "<script>Swal.fire('Terhapus', 'Komentar berhasil dihapus', 'success').then(() => window.location.href='komentar.php');</script>";
}

// Handle Admin Reply
if (isset($_POST['action']) && $_POST['action'] === 'reply') {
    $report_id = (int) $_POST['report_id'];
    $parent_id = !empty($_POST['parent_id']) ? (int) $_POST['parent_id'] : 'NULL';
    $comment_text = $conn->real_escape_string($_POST['reply_text']);
    $conn->query("INSERT INTO report_comments (report_id, commenter_name, comment_text, is_admin, parent_id) VALUES ($report_id, 'Admin Diskominfo', '$comment_text', 1, $parent_id)");
    echo "<script>Swal.fire('Terkirim', 'Balasan berhasil dipublikasikan', 'success').then(() => window.location.href='komentar.php');</script>";
}

// Fetch all comments with report title
$sql = "
    SELECT c.*, r.title as report_title 
    FROM report_comments c
    JOIN reports r ON c.report_id = r.id
    ORDER BY c.created_at DESC
";
$res = $conn->query($sql);
$comments = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $comments[] = $row;
    }
}
$conn->close();
?>

<div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold m-0" style="color: #0f172a;">Komentar Warga & Diskusi</h5>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-borderless align-middle mb-0">
                <thead style="border-bottom: 2px solid #f1f5f9;">
                    <tr>
                        <th width="15%" class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">PENGIRIM</th>
                        <th width="35%" class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">KOMENTAR</th>
                        <th width="25%" class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">PADA LAPORAN</th>
                        <th width="15%" class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">WAKTU</th>
                        <th width="10%" class="text-end text-muted fw-semibold pb-3" style="font-size: 0.85rem;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($comments)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada komentar</td></tr>
                    <?php endif; ?>
                    <?php foreach ($comments as $c): ?>
                    <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <td class="py-3">
                            <?php if ($c['is_admin']): ?>
                                <span class="badge bg-primary-maroon px-2 py-1" style="border-radius: 6px;">Admin</span>
                            <?php else: ?>
                                <span class="fw-semibold text-dark"><?= esc($c['commenter_name']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3" style="color: #334155;"><?= nl2br(esc($c['comment_text'])) ?></td>
                        <td class="py-3"><small class="text-muted"><?= esc($c['report_title']) ?></small></td>
                        <td class="py-3"><small class="text-muted"><?= date('d M Y H:i', strtotime($c['created_at'])) ?></small></td>
                        <td class="text-end py-3">
                            <button class="btn btn-sm mb-1" style="background: rgba(14,165,233,0.1); color: #0ea5e9; font-weight: 600; border-radius: 8px;" onclick="showReplyModal(<?= $c['report_id'] ?>, '<?= esc($c['report_title']) ?>', <?= $c['id'] ?>, '<?= esc(addslashes($c['commenter_name'])) ?>', '<?= esc(addslashes($c['comment_text'])) ?>')" title="Balas Komentar Ini">
                                <i class="bi bi-reply-fill"></i>
                            </button>
                            <form method="POST" class="d-inline" onsubmit="return confirm('Hapus komentar ini?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                <button type="submit" class="btn btn-sm mb-1" style="background: rgba(239,68,68,0.1); color: #ef4444; font-weight: 600; border-radius: 8px;" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <input type="hidden" name="action" value="reply">
            <input type="hidden" name="report_id" id="replyReportId">
            <input type="hidden" name="parent_id" id="replyParentId">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Balas sebagai Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="small text-muted mb-3">Membalas di laporan: <strong id="replyReportTitle"></strong></p>
                
                <div class="bg-light p-3 rounded-3 mb-3 border">
                    <strong id="replyToName" class="text-dark d-block mb-1"></strong>
                    <div id="replyToText" class="text-muted small fst-italic"></div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="fw-semibold">Balasan Anda</label>
                    <button type="button" class="btn btn-sm btn-dark rounded-pill shadow-sm" id="btnBot" onclick="generateAiReply()">
                        ✨ Balas dengan Kinara
                    </button>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" name="reply_text" id="replyText" rows="5" placeholder="Tulis tanggapan Anda..." required></textarea>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary bg-maroon border-0 px-4">Kirim Balasan</button>
            </div>
        </form>
    </div>
</div>

<script>
let currentUserText = '';

function showReplyModal(reportId, reportTitle, commentId, userName, userText) {
    document.getElementById('replyReportId').value = reportId;
    document.getElementById('replyReportTitle').textContent = reportTitle;
    document.getElementById('replyParentId').value = commentId;
    document.getElementById('replyToName').textContent = "Membalas " + userName + ":";
    document.getElementById('replyToText').textContent = '"' + userText + '"';
    document.getElementById('replyText').value = '';
    currentUserText = userText;
    
    new bootstrap.Modal(document.getElementById('replyModal')).show();
}

async function generateAiReply() {
    const btn = document.getElementById('btnBot');
    const textArea = document.getElementById('replyText');
    
    if (!currentUserText) return;
    
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyusun...';
    btn.disabled = true;
    
    try {
        const formData = new FormData();
        formData.append('user_comment', currentUserText);
        
        const res = await fetch('/kominfov2/api/admin-reply-bot.php', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();
        
        textArea.value = data.reply;
        
    } catch (e) {
        alert('Gagal menghubungi AI.');
    } finally {
        btn.innerHTML = '✨ Balas dengan Kinara';
        btn.disabled = false;
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

