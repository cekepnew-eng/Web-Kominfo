<?php
declare(strict_types=1);

$pageTitle = 'Kelola Pengaduan Warga';
$activePage = 'pengaduan';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../includes/report-service.php';

$conn = db_get_conn();

// Handle Status Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $id = (int) $_POST['id'];
    $newStatus = $conn->real_escape_string($_POST['status']);
    
    // Validasi status
    if (isset(REPORT_STATUSES[$newStatus])) {
        $conn->query("UPDATE reports SET status='$newStatus' WHERE id=$id");
        $conn->query("INSERT INTO report_status_history (report_id, status, note) VALUES ($id, '$newStatus', 'Status diperbarui oleh Admin')");
        echo "<script>Swal.fire('Tersimpan', 'Status laporan berhasil diperbarui', 'success').then(() => window.location.href='pengaduan.php');</script>";
    }
}

// Ambil data laporan
$result = report_list(['limit' => 500]);
$reports = $result['items'] ?? [];
?>

<div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
        <h5 class="fw-bold m-0" style="color: #0f172a;">Semua Pengaduan Masuk</h5>
        <p class="text-muted small mt-1">Daftar laporan masyarakat dari SiBadra dan Web Portal.</p>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-borderless align-middle mb-0">
                <thead style="border-bottom: 2px solid #f1f5f9;">
                    <tr>
                        <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">TIKET</th>
                        <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">TANGGAL</th>
                        <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">KATEGORI</th>
                        <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">ISI LAPORAN</th>
                        <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">LOKASI</th>
                        <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">STATUS</th>
                        <th class="text-end text-muted fw-semibold pb-3" style="font-size: 0.85rem;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reports)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada laporan pengaduan masuk.</td>
                    </tr>
                    <?php endif; ?>
                    
                    <?php foreach($reports as $r): ?>
                    <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <td class="fw-bold py-3" style="color: #3b82f6;">#<?= esc($r['ticket_number']) ?></td>
                        <td class="py-3"><small class="text-muted"><?= date('d M Y H:i', strtotime($r['created_at'])) ?></small></td>
                        <td class="py-3"><span class="badge bg-light text-dark border px-2 py-1" style="border-radius: 6px;"><?= esc($r['category_label']) ?></span></td>
                        <td class="py-3">
                            <div class="fw-semibold text-dark"><?= esc($r['title']) ?></div>
                            <small class="text-muted" style="max-width:250px; display:inline-block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= esc($r['description']) ?></small>
                        </td>
                        <td class="py-3"><small class="text-muted"><i class="bi bi-geo-alt text-danger"></i> <?= esc($r['address']) ?></small></td>
                        <td class="py-3">
                            <span class="badge rounded-pill px-3 py-2" style="background-color: <?= $r['status_color'] ?>; font-weight: 500; font-size: 0.75rem; letter-spacing: 0.5px;">
                                <?= esc($r['status_label']) ?>
                            </span>
                        </td>
                        <td class="text-end py-3">
                            <!-- Tombol Update Status -->
                            <button type="button" class="btn btn-sm" style="background: rgba(14,165,233,0.1); color: #0ea5e9; font-weight: 600; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#statusModal<?= $r['id'] ?>">
                                Update
                            </button>
                            <!-- Tombol Detail Foto -->
                            <button type="button" class="btn btn-sm" style="background: rgba(100,116,139,0.1); color: #64748b; font-weight: 600; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#detailModal<?= $r['id'] ?>">
                                <i class="bi bi-image"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Update Status -->
                    <div class="modal fade" id="statusModal<?= $r['id'] ?>" tabindex="-1">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <form method="POST">
                              <div class="modal-header border-0">
                                <h6 class="modal-title fw-bold">Update Status #<?= esc($r['ticket_number']) ?></h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body py-0">
                                <input type="hidden" name="action" value="update_status">
                                <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                <select name="status" class="form-select">
                                    <?php foreach(REPORT_STATUSES as $val => $label): ?>
                                    <option value="<?= $val ?>" <?= $r['status'] === $val ? 'selected' : '' ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                              </div>
                              <div class="modal-footer border-0">
                                <button type="submit" class="btn btn-primary bg-maroon border-0 w-100">Simpan Status</button>
                              </div>
                          </form>
                        </div>
                      </div>
                    </div>

                    <!-- Modal Detail -->
                    <div class="modal fade" id="detailModal<?= $r['id'] ?>" tabindex="-1">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h6 class="modal-title fw-bold">Detail Laporan #<?= esc($r['ticket_number']) ?></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body text-center">
                            <?php if($r['primary_image']): ?>
                                <img src="../<?= esc($r['primary_image']) ?>" class="img-fluid rounded shadow-sm mb-3" style="max-height: 300px; object-fit: contain;">
                            <?php else: ?>
                                <div class="alert alert-secondary">Tidak ada foto terlampir.</div>
                            <?php endif; ?>
                            <p class="text-start"><strong>Detail:</strong><br><?= nl2br(esc($r['description'])) ?></p>
                            <p class="text-start mb-0"><strong>Kordinat GPS:</strong><br><a href="https://www.google.com/maps/search/?api=1&query=<?= $r['latitude'] ?>,<?= $r['longitude'] ?>" target="_blank" class="text-decoration-none"><i class="bi bi-map-fill"></i> Buka di Google Maps (<?= $r['latitude'] ?>, <?= $r['longitude'] ?>)</a></p>
                          </div>
                        </div>
                      </div>
                    </div>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
