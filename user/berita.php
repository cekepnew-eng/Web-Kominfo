<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/services.php';

$pageTitle = 'Berita Terkini - Kominfo Bogor';
$activePage = 'berita';

require __DIR__ . '/../includes/header.php';
?>

<div class="py-5 mt-5 bg-light min-vh-100">
    <div class="container py-5">
        
        <!-- Header -->
        <div class="row mb-5 align-items-end" data-aos="fade-up">
            <div class="col-lg-8">
                <h6 class="text-primary-maroon fw-bold text-uppercase">Informasi Publik</h6>
                <h2 class="display-6 fw-bold">Berita Terkini Kota Bogor</h2>
                <p class="text-muted mb-0">Dapatkan informasi resmi dan terpercaya seputar pembangunan, layanan publik, dan kegiatan Pemerintah Kota Bogor.</p>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                <form action="#" class="position-relative">
                    <input type="text" class="form-control form-control-lg rounded-pill ps-4 pe-5 border-0 shadow-sm" placeholder="Cari berita...">
                    <button type="submit" class="btn position-absolute top-50 end-0 translate-middle-y me-2 text-muted border-0 bg-transparent">
                        🔍
                    </button>
                </form>
            </div>
        </div>

        <!-- News Grid -->
        <div class="row g-4">
            <?php
            // Memanggil fungsi yang sudah ada untuk mengambil feed berita
            $newsFeed = get_realtime_news_feed(9);
            
            foreach ($newsFeed as $idx => $item):
                $image = !empty($item['image']) ? $item['image'] : "https://picsum.photos/seed/bgornews{$idx}/600/400";
            ?>
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= ($idx % 3) * 100 ?>">
                <article class="berita-card bg-white h-100 d-flex flex-column rounded-4 border-0 shadow-sm overflow-hidden" style="transition: transform 0.3s, box-shadow 0.3s;">
                    <div class="position-relative w-100" style="height:220px;">
                        <img src="<?= esc($image) ?>" alt="<?= esc($item['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                        <span class="badge bg-primary-maroon position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill shadow-sm">
                            <?= esc($item['source']) ?>
                        </span>
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column">
                        <p class="text-muted small mb-2 fw-semibold">📅 <?= esc($item['published']) ?></p>
                        <h5 class="fw-bold mb-3" style="font-size:1.1rem; line-height:1.4;">
                            <a href="<?= esc($item['url']) ?>" target="_blank" class="text-dark text-decoration-none">
                                <?= esc($item['title']) ?>
                            </a>
                        </h5>
                        <p class="text-muted small mb-0 line-clamp-3 flex-grow-1"><?= esc($item['excerpt']) ?></p>
                        <a href="<?= esc($item['url']) ?>" target="_blank" class="mt-4 text-primary-maroon fw-bold text-decoration-none d-flex align-items-center">
                            Baca Selengkapnya <span class="ms-1">&rarr;</span>
                        </a>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <nav aria-label="Navigasi Halaman Berita" class="mt-5" data-aos="fade-up">
            <ul class="pagination justify-content-center mb-0">
                <li class="page-item disabled">
                    <a class="page-link border-0 shadow-sm rounded-start-pill px-4" href="#" tabindex="-1" aria-disabled="true">
                        &laquo; Sebelumnya
                    </a>
                </li>
                
                <li class="page-item"><a class="page-link border-0 shadow-sm mx-1 rounded-circle active bg-primary-maroon border-primary-maroon text-white" href="#">1</a></li>
                <li class="page-item"><a class="page-link border-0 shadow-sm mx-1 rounded-circle" href="#">2</a></li>
                <li class="page-item"><a class="page-link border-0 shadow-sm mx-1 rounded-circle" href="#">3</a></li>
                <li class="page-item disabled"><span class="page-link border-0 shadow-sm mx-1 rounded-circle">...</span></li>
                <li class="page-item"><a class="page-link border-0 shadow-sm mx-1 rounded-circle" href="#">8</a></li>
                
                <li class="page-item">
                    <a class="page-link border-0 shadow-sm rounded-end-pill px-4" href="#">
                        Selanjutnya &raquo;
                    </a>
                </li>
            </ul>
        </nav>

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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
