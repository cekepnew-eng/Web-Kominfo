<?php
declare(strict_types=1);

$pageTitle = 'Dashboard Admin';
$activePage = 'dashboard';

require_once __DIR__ . '/includes/header.php';

// Fetch quick stats
$conn = db_get_conn();

// Stats Pengaduan
$res = $conn->query("SELECT COUNT(*) as total FROM reports");
$totalPengaduan = $res->fetch_assoc()['total'] ?? 0;

$res = $conn->query("SELECT COUNT(*) as total FROM reports WHERE status='pending_verification'");
$pendingPengaduan = $res->fetch_assoc()['total'] ?? 0;

// Stats CCTV
$res = $conn->query("SELECT COUNT(*) as total FROM cctv_streams");
$totalCCTV = $res->fetch_assoc()['total'] ?? 0;

// Stats Berita
$res = $conn->query("SELECT COUNT(*) as total FROM news_articles");
$totalBerita = $res->fetch_assoc()['total'] ?? 0;

// Stats Komentar
$res = $conn->query("SELECT COUNT(*) as total FROM report_comments");
$totalKomentar = $res->fetch_assoc()['total'] ?? 0;

// Fetch Recent Reports for Dashboard
$recentReports = [];
$res = $conn->query("SELECT id, title, status, created_at FROM reports ORDER BY created_at DESC LIMIT 5");
if ($res) {
    while ($r = $res->fetch_assoc()) {
        $recentReports[] = $r;
    }
}

$conn->close();
?>

<style>
/* Modern Dashboard Styling */
.card-stat {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    transition: all 0.3s ease;
    background: #fff;
    overflow: hidden;
    position: relative;
}
.card-stat:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}
.card-stat.stat-1::before { background: linear-gradient(90deg, #ef4444, #b91c1c); }
.card-stat.stat-2::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
.card-stat.stat-3::before { background: linear-gradient(90deg, #3b82f6, #1d4ed8); }
.card-stat.stat-4::before { background: linear-gradient(90deg, #10b981, #047857); }
.card-stat::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; height: 4px;
    opacity: 0;
    transition: opacity 0.3s;
}
.card-stat:hover::before {
    opacity: 1;
}
.icon-box {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}
.icon-maroon { background: rgba(128,0,0,0.1); color: #800000; }
.icon-warning { background: rgba(245,158,11,0.1); color: #f59e0b; }
.icon-primary { background: rgba(59,130,246,0.1); color: #3b82f6; }
.icon-success { background: rgba(16,185,129,0.1); color: #10b981; }

.welcome-banner {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border-radius: 16px;
    color: white;
    padding: 2.5rem 2rem;
    position: relative;
    overflow: hidden;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}
.welcome-banner::after {
    content: '';
    position: absolute;
    top: -50%; right: -5%;
    width: 300px; height: 300px;
    background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0) 100%);
    border-radius: 50%;
}
.welcome-banner::before {
    content: '';
    position: absolute;
    bottom: -50%; right: 15%;
    width: 200px; height: 200px;
    background: linear-gradient(135deg, rgba(14,165,233,0.15) 0%, rgba(14,165,233,0) 100%);
    border-radius: 50%;
}
</style>

<div class="welcome-banner">
    <div style="position: relative; z-index: 1;">
        <h2 class="fw-bold mb-2">Selamat Datang, Admin! 👋</h2>
        <p class="mb-0 text-light" style="opacity: 0.8; font-size: 1.1rem;">Pantau dan kelola layanan portal cerdas Kota Bogor dengan mudah.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Stat Card 1 -->
    <div class="col-md-3">
        <div class="card card-stat stat-1 h-100 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted fw-semibold mb-2" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Total Laporan</h6>
                    <h3 class="fw-bold mb-0" style="color: #1e293b; font-size: 2rem;"><?= $totalPengaduan ?></h3>
                </div>
                <div class="icon-box icon-maroon">
                    <i class="bi bi-inbox-fill"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Stat Card 2 -->
    <div class="col-md-3">
        <div class="card card-stat stat-2 h-100 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted fw-semibold mb-2" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Menunggu Verifikasi</h6>
                    <h3 class="fw-bold mb-0" style="color: #1e293b; font-size: 2rem;"><?= $pendingPengaduan ?></h3>
                </div>
                <div class="icon-box icon-warning">
                    <i class="bi bi-hourglass-split"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Stat Card 3 -->
    <div class="col-md-3">
        <div class="card card-stat stat-3 h-100 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted fw-semibold mb-2" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">CCTV Aktif</h6>
                    <h3 class="fw-bold mb-0" style="color: #1e293b; font-size: 2rem;"><?= $totalCCTV ?></h3>
                </div>
                <div class="icon-box icon-primary">
                    <i class="bi bi-camera-video-fill"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Stat Card 4 -->
    <div class="col-md-3">
        <div class="card card-stat stat-4 h-100 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted fw-semibold mb-2" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Interaksi Warga</h6>
                    <h3 class="fw-bold mb-0" style="color: #1e293b; font-size: 2rem;"><?= $totalKomentar ?></h3>
                </div>
                <div class="icon-box icon-success">
                    <i class="bi bi-chat-left-text-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold m-0" style="color: #0f172a;">Laporan Warga Terbaru</h5>
                <a href="pengaduan.php" class="btn btn-sm px-3" style="background: rgba(14,165,233,0.1); color: #0ea5e9; font-weight: 600; border-radius: 8px;">Lihat Semua</a>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <thead style="border-bottom: 2px solid #f1f5f9;">
                            <tr>
                                <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">TANGGAL</th>
                                <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">JUDUL LAPORAN</th>
                                <th class="text-muted fw-semibold pb-3" style="font-size: 0.85rem;">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recentReports)): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-5">
                                    <div class="p-4 bg-light rounded-4 d-inline-block mb-3"><i class="bi bi-inbox fs-2 text-secondary"></i></div>
                                    <p class="mb-0">Belum ada laporan warga.</p>
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($recentReports as $rep): 
                                    $bg = 'bg-secondary';
                                    if ($rep['status'] === 'pending_verification') $bg = 'bg-warning text-dark';
                                    if ($rep['status'] === 'in_progress') $bg = 'bg-primary';
                                    if ($rep['status'] === 'resolved') $bg = 'bg-success';
                                ?>
                                <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                                    <td class="text-muted small py-3"><?= date('d M Y, H:i', strtotime($rep['created_at'])) ?></td>
                                    <td class="fw-semibold text-dark text-truncate py-3" style="max-width: 250px;"><?= esc($rep['title']) ?></td>
                                    <td class="py-3"><span class="badge <?= $bg ?> px-3 py-2" style="border-radius: 6px; font-weight: 500; font-size: 0.75rem; letter-spacing: 0.5px;"><?= str_replace('_', ' ', strtoupper($rep['status'])) ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4" style="color: #0f172a;">Aktivitas Sistem</h5>
                
                <div class="d-flex align-items-start gap-3 mb-4 p-3" style="background: #f8fafc; border-radius: 12px; transition: transform 0.2s;" onmouseover="this.style.transform='translateX(5px)'" onmouseout="this.style.transform='translateX(0)'">
                    <div class="icon-box" style="background: rgba(59,130,246,0.1); color: #3b82f6; width: 48px; height: 48px; border-radius: 10px;">
                        <i class="bi bi-camera-video-fill fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1" style="color: #1e293b; font-size: 0.95rem;">Integrasi CCTV Aktif</h6>
                        <p class="text-muted small mb-0" style="line-height: 1.4;">Terdapat <?= $totalCCTV ?> titik termonitor real-time.</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-start gap-3 p-3" style="background: #f8fafc; border-radius: 12px; transition: transform 0.2s;" onmouseover="this.style.transform='translateX(5px)'" onmouseout="this.style.transform='translateX(0)'">
                    <div class="icon-box" style="background: rgba(16,185,129,0.1); color: #10b981; width: 48px; height: 48px; border-radius: 10px;">
                        <i class="bi bi-newspaper fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1" style="color: #1e293b; font-size: 0.95rem;">Berita & Informasi</h6>
                        <p class="text-muted small mb-0" style="line-height: 1.4;">Sebanyak <?= $totalBerita ?> artikel terpublikasi.</p>
                    </div>
                </div>
                
                <!-- Quick AI access -->
                <div class="mt-4 pt-3" style="border-top: 1px dashed #e2e8f0;">
                    <a href="<?= $publicPath ?? '' ?>/user/wowoembege.php" class="btn w-100 d-flex justify-content-center align-items-center gap-2 py-2" target="_blank" style="background: linear-gradient(135deg, #0ea5e9, #3b82f6); color: white; border-radius: 10px; font-weight: 500; transition: transform 0.2s; border: none;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="bi bi-robot fs-5"></i>
                        <span>Tanya Asisten AI</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
