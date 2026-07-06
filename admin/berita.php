<?php
declare(strict_types=1);

$pageTitle = 'Kelola Berita';
$activePage = 'berita';
require_once __DIR__ . '/includes/header.php';

$conn = db_get_conn();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $title = $conn->real_escape_string($_POST['title']);
        $excerpt = $conn->real_escape_string($_POST['excerpt']);
        $url = $conn->real_escape_string($_POST['url'] ?? '#');
        $image = $conn->real_escape_string($_POST['image'] ?? 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=600&q=80');
        
        $conn->query("INSERT INTO news_articles (title, excerpt, url, source, published, image) VALUES ('$title', '$excerpt', '$url', 'Admin Diskominfo', 'Update terbaru', '$image')");
        echo "<script>Swal.fire('Sukses', 'Berita berhasil diterbitkan', 'success').then(() => window.location.href='berita.php');</script>";
    } elseif (isset($_POST['action']) && $_POST['action'] === 'edit') {
        $id = (int) $_POST['id'];
        $title = $conn->real_escape_string($_POST['title']);
        $excerpt = $conn->real_escape_string($_POST['excerpt']);
        $url = $conn->real_escape_string($_POST['url'] ?? '#');
        $image = $conn->real_escape_string($_POST['image'] ?? 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=600&q=80');
        
        $conn->query("UPDATE news_articles SET title='$title', excerpt='$excerpt', url='$url', image='$image' WHERE id=$id");
        echo "<script>Swal.fire('Tersimpan', 'Berita berhasil diperbarui', 'success').then(() => window.location.href='berita.php');</script>";
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = (int) $_POST['id'];
        $conn->query("DELETE FROM news_articles WHERE id=$id");
        echo "<script>Swal.fire('Terhapus', 'Berita berhasil dihapus', 'success').then(() => window.location.href='berita.php');</script>";
    }
}

// Auto-sync scraped news to DB so they appear in admin and can be managed
// We directly call the scraper functions here to bypass the DB short-circuit in get_realtime_news_feed()
require_once __DIR__ . '/../includes/services.php';
$scraped_news = array_merge(
    get_kotabogor_news(15),
    get_detik_bogor_news(15)
);

foreach ($scraped_news as $n) {
    if (empty($n['url'])) continue;
    $s_title = $conn->real_escape_string($n['title']);
    $s_url = $conn->real_escape_string($n['url']);
    $s_source = $conn->real_escape_string($n['source']);
    $s_published = $conn->real_escape_string($n['published']);
    $s_excerpt = $conn->real_escape_string($n['excerpt']);
    $s_image = $conn->real_escape_string($n['image']);
    
    // Check if it already exists
    $check = $conn->query("SELECT id FROM news_articles WHERE url='$s_url'");
    if ($check && $check->num_rows === 0) {
        $conn->query("INSERT INTO news_articles (title, excerpt, url, source, published, image) VALUES ('$s_title', '$s_excerpt', '$s_url', '$s_source', '$s_published', '$s_image')");
    }
}

// Fetch data
$res = $conn->query("SELECT * FROM news_articles ORDER BY id DESC");
$news = $res->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold m-0" style="color: #0f172a;">Daftar Rilis Berita</h5>
        <button class="btn btn-sm px-3" style="background: linear-gradient(135deg, #0ea5e9, #3b82f6); color: white; font-weight: 600; border-radius: 8px; border: none;" data-bs-toggle="modal" data-bs-target="#addNewsModal">
            <i class="bi bi-pencil-square"></i> Tulis Berita
        </button>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-borderless align-middle mb-0">
                <thead style="border-bottom: 2px solid #f1f5f9;">
                    <tr>
                        <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">ID</th>
                        <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">JUDUL BERITA</th>
                        <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">KUTIPAN (EXCERPT)</th>
                        <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">TANGGAL RILIS</th>
                        <th class="text-end text-muted fw-semibold pb-3" style="font-size: 0.85rem;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($news as $n): ?>
                    <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <td class="fw-bold py-3" style="color: #3b82f6;"><?= $n['id'] ?></td>
                        <td class="fw-semibold text-dark py-3">
                            <img src="<?= esc($n['image']) ?>" alt="img" class="rounded-3 me-2 shadow-sm" style="width:45px;height:45px;object-fit:cover;">
                            <?= esc($n['title']) ?>
                        </td>
                        <td class="py-3"><small class="text-muted" style="max-width:250px; display:inline-block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= esc($n['excerpt']) ?></small></td>
                        <td class="py-3"><small class="text-muted"><?= date('d M Y', strtotime($n['created_at'])) ?></small></td>
                        <td class="text-end py-3">
                            <a href="<?= esc($n['url']) ?>" target="_blank" class="btn btn-sm" style="background: rgba(16,185,129,0.1); color: #10b981; font-weight: 600; border-radius: 8px;"><i class="bi bi-eye"></i></a>
                            <button type="button" class="btn btn-sm" style="background: rgba(14,165,233,0.1); color: #0ea5e9; font-weight: 600; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#editNewsModal<?= $n['id'] ?>"><i class="bi bi-pencil"></i></button>
                            <form method="POST" class="d-inline" onsubmit="return confirm('Hapus berita ini?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $n['id'] ?>">
                                <button type="submit" class="btn btn-sm" style="background: rgba(239,68,68,0.1); color: #ef4444; font-weight: 600; border-radius: 8px;"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Edit Berita -->
                    <div class="modal fade" id="editNewsModal<?= $n['id'] ?>" tabindex="-1">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <form method="POST">
                              <div class="modal-header">
                                <h5 class="modal-title fw-bold">Edit Berita</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body text-start">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="id" value="<?= $n['id'] ?>">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Judul Berita</label>
                                    <input type="text" class="form-control" name="title" value="<?= esc($n['title']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">URL Berita Lengkap</label>
                                    <input type="url" class="form-control" name="url" value="<?= esc($n['url']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">URL Gambar Thumbnail</label>
                                    <input type="url" class="form-control" name="image" value="<?= esc($n['image'] ?? '') ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Kutipan Ringkas (Excerpt)</label>
                                    <textarea class="form-control" name="excerpt" rows="3" required><?= esc($n['excerpt']) ?></textarea>
                                </div>
                              </div>
                              <div class="modal-footer border-0">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary bg-maroon border-0">Simpan Perubahan</button>
                              </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Berita -->
<div class="modal fade" id="addNewsModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST">
          <div class="modal-header">
            <h5 class="modal-title fw-bold">Tulis Rilis Berita Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="action" value="add">
            <div class="mb-3">
                <label class="form-label fw-semibold">Judul Berita</label>
                <input type="text" class="form-control" name="title" required placeholder="Tulis judul yang menarik...">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">URL Berita Lengkap</label>
                <input type="url" class="form-control" name="url" required placeholder="https://kotabogor.go.id/berita-detail/...">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">URL Gambar Thumbnail (Opsional)</label>
                <input type="url" class="form-control" name="image" placeholder="https://...">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Kutipan Ringkas (Excerpt)</label>
                <textarea class="form-control" name="excerpt" rows="3" required placeholder="Tuliskan 1-2 kalimat ringkasan berita untuk ditampilkan di halaman depan..."></textarea>
            </div>
          </div>
          <div class="modal-footer border-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary bg-maroon border-0">Terbitkan Berita</button>
          </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
