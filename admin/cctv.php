<?php
declare(strict_types=1);

$pageTitle = 'Kelola CCTV';
$activePage = 'cctv';
require_once __DIR__ . '/includes/header.php';

$conn = db_get_conn();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $name = $conn->real_escape_string($_POST['name']);
        $stream = $conn->real_escape_string($_POST['stream_url']);
        $detail = $conn->real_escape_string($_POST['detail_url'] ?? '');
        $conn->query("INSERT INTO cctv_streams (name, stream_url, detail_url) VALUES ('$name', '$stream', '$detail')");
        echo "<script>Swal.fire('Sukses', 'CCTV berhasil ditambahkan', 'success').then(() => window.location.href='cctv.php');</script>";
    } elseif (isset($_POST['action']) && $_POST['action'] === 'edit') {
        $id = (int) $_POST['id'];
        $name = $conn->real_escape_string($_POST['name']);
        $stream = $conn->real_escape_string($_POST['stream_url']);
        $detail = $conn->real_escape_string($_POST['detail_url'] ?? '');
        $status = isset($_POST['is_active']) ? 1 : 0;
        $conn->query("UPDATE cctv_streams SET name='$name', stream_url='$stream', detail_url='$detail', is_active=$status WHERE id=$id");
        echo "<script>Swal.fire('Tersimpan', 'CCTV berhasil diperbarui', 'success').then(() => window.location.href='cctv.php');</script>";
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = (int) $_POST['id'];
        $conn->query("DELETE FROM cctv_streams WHERE id=$id");
        echo "<script>Swal.fire('Terhapus', 'CCTV berhasil dihapus', 'success').then(() => window.location.href='cctv.php');</script>";
    }
}

// Fetch data
$res = $conn->query("SELECT * FROM cctv_streams ORDER BY id DESC");
$cctvs = $res->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold m-0" style="color: #0f172a;">Daftar Titik CCTV</h5>
        <button class="btn btn-sm px-3" style="background: linear-gradient(135deg, #0ea5e9, #3b82f6); color: white; font-weight: 600; border-radius: 8px; border: none;" data-bs-toggle="modal" data-bs-target="#addCctvModal">
            <i class="bi bi-plus-lg"></i> Tambah CCTV
        </button>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-borderless align-middle mb-0">
                <thead style="border-bottom: 2px solid #f1f5f9;">
                    <tr>
                        <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">ID</th>
                        <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">NAMA / LOKASI</th>
                        <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">STREAM URL</th>
                        <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">STATUS</th>
                        <th class="text-end text-muted fw-semibold pb-3" style="font-size: 0.85rem;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($cctvs as $c): ?>
                    <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <td class="fw-bold py-3" style="color: #3b82f6;"><?= $c['id'] ?></td>
                        <td class="fw-semibold text-dark py-3"><?= esc($c['name']) ?></td>
                        <td class="py-3"><small class="text-muted" style="max-width:300px; display:inline-block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= esc($c['stream_url']) ?></small></td>
                        <td class="py-3">
                            <?php if($c['is_active']): ?>
                                <span class="badge px-3 py-2" style="background: rgba(16,185,129,0.1); color: #10b981; border-radius: 6px; font-weight: 600;">Aktif</span>
                            <?php else: ?>
                                <span class="badge px-3 py-2" style="background: rgba(100,116,139,0.1); color: #64748b; border-radius: 6px; font-weight: 600;">Tidak Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end py-3">
                            <button type="button" class="btn btn-sm" style="background: rgba(14,165,233,0.1); color: #0ea5e9; font-weight: 600; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#editCctvModal<?= $c['id'] ?>"><i class="bi bi-pencil"></i></button>
                            <form method="POST" class="d-inline" onsubmit="return confirm('Hapus CCTV ini?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                <button type="submit" class="btn btn-sm" style="background: rgba(239,68,68,0.1); color: #ef4444; font-weight: 600; border-radius: 8px;"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Edit CCTV -->
                    <div class="modal fade" id="editCctvModal<?= $c['id'] ?>" tabindex="-1">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form method="POST">
                              <div class="modal-header">
                                <h5 class="modal-title fw-bold">Edit Titik CCTV</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                <div class="mb-3 text-start">
                                    <label class="form-label fw-semibold">Nama Titik Lokasi</label>
                                    <input type="text" class="form-control" name="name" value="<?= esc($c['name']) ?>" required>
                                </div>
                                <div class="mb-3 text-start">
                                    <label class="form-label fw-semibold">URL Stream (HLS/m3u8)</label>
                                    <input type="url" class="form-control" name="stream_url" value="<?= esc($c['stream_url']) ?>" required>
                                </div>
                                <div class="mb-3 text-start">
                                    <label class="form-label fw-semibold">URL Detail (Opsional)</label>
                                    <input type="url" class="form-control" name="detail_url" value="<?= esc($c['detail_url'] ?? '') ?>">
                                </div>
                                <div class="form-check form-switch text-start">
                                    <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="flexSwitchCheck<?= $c['id'] ?>" <?= $c['is_active'] ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="flexSwitchCheck<?= $c['id'] ?>">CCTV Aktif</label>
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

<!-- Modal Tambah CCTV -->
<div class="modal fade" id="addCctvModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
          <div class="modal-header">
            <h5 class="modal-title fw-bold">Tambah Titik CCTV</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="action" value="add">
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Titik Lokasi</label>
                <input type="text" class="form-control" name="name" required placeholder="Contoh: Simpang Tugu Kujang">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">URL Stream (HLS/m3u8)</label>
                <input type="url" class="form-control" name="stream_url" required placeholder="https://...">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">URL Detail (Opsional)</label>
                <input type="url" class="form-control" name="detail_url" placeholder="https://...">
            </div>
          </div>
          <div class="modal-footer border-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary bg-maroon border-0">Simpan CCTV</button>
          </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
