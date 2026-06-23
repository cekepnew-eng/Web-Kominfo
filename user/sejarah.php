<?php
declare(strict_types=1);

$pageTitle = 'Sejarah - Dinas Komunikasi dan Informatika';
$activePage = 'sejarah';

require_once __DIR__ . '/../includes/header.php';
?>

<style>
    /* Modern UI/UX Resets & Tokens */
    :root {
        --primary: #0ea5e9;
        --primary-dark: #0284c7;
        --surface: #ffffff;
        --background: #f8fafc;
        --text-main: #0f172a;
        --text-muted: #64748b;
    }

    body {
        background-color: var(--background);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    /* ─── Modern Split Hero Section ─── */
    .hero-modern {
        padding: 140px 0 80px 0;
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
        position: relative;
        overflow: hidden;
    }

    /* Decorative background blobs */
    .hero-modern::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(14,165,233,0.1) 0%, rgba(14,165,233,0) 70%);
        border-radius: 50%;
        z-index: 0;
    }

    .hero-badge {
        display: inline-block;
        padding: 8px 16px;
        background-color: rgba(14, 165, 233, 0.1);
        color: var(--primary-dark);
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 24px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.2;
        margin-bottom: 24px;
        letter-spacing: -1px;
    }

    .hero-title span {
        color: var(--primary);
    }

    .hero-desc {
        font-size: 1.2rem;
        color: var(--text-muted);
        line-height: 1.7;
        margin-bottom: 30px;
        font-weight: 400;
    }

    /* Fully visible, uncovered image */
    .hero-image-wrapper {
        position: relative;
        z-index: 1;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        transform: perspective(1000px) rotateY(-5deg);
        transition: transform 0.5s ease;
    }

    .hero-image-wrapper:hover {
        transform: perspective(1000px) rotateY(0deg) translateY(-10px);
    }

    .hero-image-wrapper img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
    }

    /* ─── Premium Timeline UI ─── */
    .timeline-section {
        padding: 100px 0;
    }

    .timeline-container {
        position: relative;
        max-width: 800px;
        margin: 0 auto;
    }

    .timeline-container::after {
        content: '';
        position: absolute;
        width: 4px;
        background-color: #e2e8f0;
        top: 0;
        bottom: 0;
        left: 50%;
        margin-left: -2px;
        border-radius: 4px;
    }

    .timeline-node {
        padding: 10px 40px;
        position: relative;
        background-color: inherit;
        width: 50%;
    }

    .timeline-node.left {
        left: 0;
    }

    .timeline-node.right {
        left: 50%;
    }

    .timeline-node::after {
        content: '';
        position: absolute;
        width: 24px;
        height: 24px;
        right: -12px;
        background-color: var(--surface);
        border: 4px solid var(--primary);
        top: 30px;
        border-radius: 50%;
        z-index: 1;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.2);
    }

    .timeline-node.right::after {
        left: -12px;
    }

    .timeline-content {
        padding: 30px;
        background: var(--surface);
        position: relative;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.02);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .timeline-content:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    .timeline-year {
        display: inline-block;
        padding: 6px 16px;
        background: var(--primary);
        color: white;
        border-radius: 50px;
        font-weight: 700;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .timeline-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 15px;
    }

    .timeline-text {
        color: var(--text-muted);
        line-height: 1.7;
        margin: 0;
    }

    /* Responsive Timeline */
    @media screen and (max-width: 768px) {
        .hero-title { font-size: 2.5rem; }
        .timeline-container::after { left: 31px; }
        .timeline-node { width: 100%; padding-left: 70px; padding-right: 25px; }
        .timeline-node.right { left: 0%; }
        .timeline-node::after { left: 19px; right: auto; }
        .hero-image-wrapper { transform: none; margin-top: 40px; }
        .hero-image-wrapper:hover { transform: translateY(-5px); }
    }
</style>

<!-- 🚀 MODERN SPLIT HERO SECTION -->
<section class="hero-modern">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            
            <!-- Left: Text Content -->
            <div class="col-lg-6 pr-lg-5" data-aos="fade-right">
                <span class="hero-badge">Tentang Kami</span>
                <h1 class="hero-title">Sejarah Perjalanan <span>Diskominfo</span></h1>
                <p class="hero-desc">Menelusuri jejak langkah evolusi pelayanan informasi publik dan transformasi digital di lingkungan Pemerintah Kota Bogor dari masa ke masa.</p>
                <a href="#timeline" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm" style="font-weight: 600; padding: 12px 28px;">Lihat Perjalanan <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="ms-2"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg></a>
            </div>

            <!-- Right: Uncovered, Clear Image (poster5.jpeg) -->
            <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left">
                <div class="hero-image-wrapper">
                    <!-- Image is shown fully without any dark overlays! -->
                    <img src="../includes/image/poster5.jpeg" alt="Sejarah Diskominfo Kota Bogor">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 📜 MODERN TIMELINE SECTION -->
<section id="timeline" class="timeline-section">
    <div class="container">
        
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold" style="color: var(--text-main); font-size: 2.5rem; letter-spacing: -0.5px;">Garis Waktu Evolusi</h2>
            <p class="text-muted" style="font-size: 1.1rem;">Dari pengolahan data tradisional menuju ekosistem Smart City.</p>
        </div>

        <div class="timeline-container">
            
            <!-- Era Awal -->
            <div class="timeline-node left" data-aos="fade-right">
                <div class="timeline-content">
                    <div class="timeline-year">Era Awal</div>
                    <h3 class="timeline-title">Kantor Pengolahan Data Elektronik (KPDE)</h3>
                    <p class="timeline-text">
                        Pada mulanya, urusan komunikasi dan informatika di lingkungan Pemerintah Kota Bogor dikelola oleh Kantor Pengolahan Data Elektronik (KPDE) dan Bagian Humas Setda Kota Bogor. Fokus utama adalah pengolahan data dasar dan diseminasi informasi secara konvensional.
                    </p>
                </div>
            </div>

            <!-- Era Transformasi -->
            <div class="timeline-node right" data-aos="fade-left">
                <div class="timeline-content">
                    <div class="timeline-year">Transformasi</div>
                    <h3 class="timeline-title">Pembentukan Diskominfo</h3>
                    <p class="timeline-text">
                        Seiring perkembangan TIK dan kebutuhan pelayanan publik yang lebih cepat, dibentuklah Dinas Komunikasi dan Informatika berdasarkan Peraturan Daerah. Institusi ini resmi menggabungkan fungsi pengolahan data, kehumasan, dan infrastruktur jaringan.
                    </p>
                </div>
            </div>

            <!-- Era Modern -->
            <div class="timeline-node left" data-aos="fade-right">
                <div class="timeline-content">
                    <div class="timeline-year">Masa Kini</div>
                    <h3 class="timeline-title">Menuju Bogor Smart City</h3>
                    <p class="timeline-text">
                        Diskominfo terus berinovasi menjadi tulang punggung digitalisasi pemerintah. Melalui command center, aplikasi SiBadra, penyediaan Wi-Fi publik, dan literasi digital, Diskominfo berkomitmen mewujudkan ekosistem Smart City yang inklusif.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
