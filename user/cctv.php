<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/services.php';

$pageTitle = 'CCTV Kota Bogor';
$activePage = 'cctv';

// Paginasi
$limit = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$totalCctv = count_cctv_streams();
$totalPages = ceil($totalCctv / $limit);

$cameras = get_bogor_cctv_streams($limit, $offset);

require __DIR__ . '/../includes/header.php';
?>

<div class="py-5 mt-5 bg-light min-vh-100">
    <div class="container py-5">
        
        <!-- Header -->
        <div class="row mb-5 align-items-end" data-aos="fade-up">
            <div class="col-lg-8">
                <h6 class="text-primary-maroon fw-bold text-uppercase">Monitoring Saat Ini</h6>
                <h2 class="display-6 fw-bold">CCTV Kota Bogor Live</h2>
                <p class="text-muted mb-0">Feed video diambil dari stream m3u8 Bogor Single Window. Klik kartu kamera untuk membuka halaman detail sumber resmi.</p>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                <form action="#" class="position-relative">
                    <input type="text" class="form-control form-control-lg rounded-pill ps-4 pe-5 border-0 shadow-sm" placeholder="Cari CCTV...">
                    <button type="submit" class="btn position-absolute top-50 end-0 translate-middle-y me-2 text-muted border-0 bg-transparent">
                        🔍
                    </button>
                </form>
            </div>
        </div>

        <?php if (empty($cameras)): ?>
            <div class="alert alert-warning border-0 shadow-sm rounded-4" role="alert" data-aos="fade-in">
                Data CCTV sedang tidak tersedia. Silakan coba beberapa saat lagi.
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($cameras as $idx => $camera): ?>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= ($idx % 3) * 100 ?>">
                        <article class="bg-white h-100 d-flex flex-column rounded-4 border-0 shadow-sm overflow-hidden" style="transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 10px 20px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='none';this.style.boxShadow='0 2px 5px rgba(0,0,0,0.05)';">
                            <div class="position-relative w-100 bg-dark" style="height:220px;">
                                <video
                                    class="w-100 h-100"
                                    style="object-fit: cover;"
                                    muted
                                    playsinline
                                    controls
                                    preload="metadata"
                                    data-hls-video
                                    data-stream-src="<?= esc($camera['stream']) ?>"
                                ></video>
                                <span class="badge bg-success position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill shadow-sm">
                                    <span class="spinner-grow spinner-grow-sm me-1" style="width: 8px; height: 8px;" role="status" aria-hidden="true"></span>
                                    LIVE
                                </span>
                            </div>
                            <div class="p-4 flex-grow-1 d-flex flex-column">
                                <h5 class="fw-bold mb-2" style="font-size:1.1rem; line-height:1.4;">
                                    <?= esc($camera['name']) ?>
                                </h5>
                                <p class="text-muted small mb-0 line-clamp-3 flex-grow-1">
                                    Streaming langsung area <?= esc($camera['name']) ?> untuk pemantauan kondisi lalu lintas dan area publik Kota Bogor.
                                </p>
                                <a href="<?= esc($camera['detail']) ?>" target="_blank" rel="noopener noreferrer" class="mt-4 text-primary-maroon fw-bold text-decoration-none d-flex align-items-center">
                                    Buka sumber resmi <span class="ms-1">&rarr;</span>
                                </a>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
            <nav aria-label="Navigasi Halaman CCTV" class="mt-5" data-aos="fade-up">
                <ul class="pagination justify-content-center mb-0">
                    <!-- Tombol Sebelumnya -->
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link border-0 shadow-sm rounded-start-pill px-4" href="?page=<?= $page - 1 ?>" <?= ($page <= 1) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                            &laquo; Sebelumnya
                        </a>
                    </li>
                    
                    <!-- Nomor Halaman (Tampilkan sebagian agar rapi) -->
                    <?php
                    $startPage = max(1, $page - 2);
                    $endPage = min($totalPages, $page + 2);
                    
                    if ($startPage > 1) {
                        echo '<li class="page-item"><a class="page-link border-0 shadow-sm mx-1" href="?page=1">1</a></li>';
                        if ($startPage > 2) {
                            echo '<li class="page-item disabled"><span class="page-link border-0 shadow-sm mx-1">...</span></li>';
                        }
                    }

                    for ($i = $startPage; $i <= $endPage; $i++) {
                        $active = ($i === $page) ? 'active bg-primary-maroon border-primary-maroon text-white' : '';
                        echo "<li class=\"page-item\"><a class=\"page-link border-0 shadow-sm mx-1 rounded-circle $active\" href=\"?page=$i\">$i</a></li>";
                    }

                    if ($endPage < $totalPages) {
                        if ($endPage < $totalPages - 1) {
                            echo '<li class="page-item disabled"><span class="page-link border-0 shadow-sm mx-1">...</span></li>';
                        }
                        echo "<li class=\"page-item\"><a class=\"page-link border-0 shadow-sm mx-1\" href=\"?page=$totalPages\">$totalPages</a></li>";
                    }
                    ?>
                    
                    <!-- Tombol Selanjutnya -->
                    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                        <a class="page-link border-0 shadow-sm rounded-end-pill px-4" href="?page=<?= $page + 1 ?>" <?= ($page >= $totalPages) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                            Selanjutnya &raquo;
                        </a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
            
        <?php endif; ?>

    </div>
</div>

<style>
.page-link {
    color: var(--primary-maroon);
    transition: all 0.2s ease;
}
.page-link:hover:not(.disabled) {
    background-color: #f8d7da;
    color: var(--primary-maroon);
}
.page-item.active .page-link {
    background-color: var(--primary-maroon) !important;
    border-color: var(--primary-maroon) !important;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const videos = document.querySelectorAll('video[data-hls-video]');
    
    videos.forEach(video => {
        const src = video.getAttribute('data-stream-src');
        if (!src) return;

        // Auto play on hover / manual play
        video.addEventListener('mouseenter', () => video.play().catch(()=>{}));
        video.addEventListener('mouseleave', () => video.pause());

        if (Hls.isSupported()) {
            const hls = new Hls({
                enableWorker: true,
                lowLatencyMode: true,
            });
            hls.loadSource(src);
            hls.attachMedia(video);
        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            // Safari / Native support
            video.src = src;
        }
    });
});
</script>

<?php require __DIR__ . '/../includes/footer.php';
