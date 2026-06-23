<?php
declare(strict_types=1);

$pageTitle = 'Visi & Misi - Dinas Komunikasi dan Informatika';
$activePage = 'visi-misi';

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
        background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
        position: relative;
        overflow: hidden;
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

    /* Fully visible image wrapper for poster5.jpeg */
    .hero-image-wrapper {
        position: relative;
        z-index: 1;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        transform: perspective(1000px) rotateY(5deg);
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

    /* ─── Premium Visi Section ─── */
    .visi-section {
        padding: 80px 0 40px 0;
    }

    .visi-card {
        background: var(--surface);
        border-radius: 30px;
        padding: 60px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.06);
        text-align: center;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.02);
    }

    .visi-card::before {
        content: '"';
        position: absolute;
        top: -20px;
        left: 20px;
        font-size: 150px;
        color: rgba(14, 165, 233, 0.05);
        font-family: serif;
        line-height: 1;
    }

    .visi-text {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.4;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
        letter-spacing: -0.5px;
    }

    .visi-desc {
        font-size: 1.15rem;
        color: var(--text-muted);
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.7;
    }

    /* ─── Premium Misi Grid ─── */
    .misi-section {
        padding: 40px 0 100px 0;
    }

    .misi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    .misi-card {
        background: var(--surface);
        padding: 40px 30px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .misi-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(14, 165, 233, 0.1);
        border-color: rgba(14, 165, 233, 0.2);
    }

    .misi-number {
        font-size: 4rem;
        font-weight: 900;
        color: rgba(14, 165, 233, 0.08);
        position: absolute;
        top: 10px;
        right: 20px;
        line-height: 1;
        transition: color 0.3s ease;
    }

    .misi-card:hover .misi-number {
        color: rgba(14, 165, 233, 0.15);
    }

    .misi-icon {
        width: 60px;
        height: 60px;
        background: rgba(14, 165, 233, 0.1);
        color: var(--primary);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
    }

    .misi-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 15px;
        position: relative;
        z-index: 1;
    }

    .misi-text {
        color: var(--text-muted);
        line-height: 1.7;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    @media screen and (max-width: 768px) {
        .hero-title { font-size: 2.5rem; }
        .hero-image-wrapper { transform: none; margin-bottom: 40px; }
        .visi-text { font-size: 1.6rem; }
        .visi-card { padding: 40px 20px; }
    }
</style>

<!-- 🚀 MODERN SPLIT HERO SECTION (Image on Left for variation) -->
<section class="hero-modern">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center flex-column-reverse flex-lg-row">
            
            <!-- Left: Uncovered Image -->
            <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-right">
                <div class="hero-image-wrapper">
                    <!-- Fully visible image so "Alun-Alun Kota Bogor" text is readable -->
                    <img src="../includes/image/poster5.jpeg" alt="Visi Misi Diskominfo">
                </div>
            </div>

            <!-- Right: Text Content -->
            <div class="col-lg-6 pl-lg-5" data-aos="fade-left">
                <span class="hero-badge">Arah Strategis</span>
                <h1 class="hero-title">Visi & Misi <span>Diskominfo</span></h1>
                <p class="hero-desc">Menjadi pelopor digitalisasi pelayanan publik dan keterbukaan informasi untuk mewujudkan Kota Bogor sebagai Smart City yang inovatif dan ramah keluarga.</p>
                <a href="#visi" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm" style="font-weight: 600; padding: 12px 28px;">Kenali Arah Kami <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="ms-2"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg></a>
            </div>

        </div>
    </div>
</section>

<!-- 🌟 VISI SECTION -->
<section id="visi" class="visi-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10" data-aos="zoom-in">
                <div class="visi-card">
                    <h3 class="text-uppercase text-primary fw-bold mb-3" style="font-size: 1rem; letter-spacing: 2px;">Visi Utama</h3>
                    <h2 class="visi-text">"Mewujudkan Kota Bogor sebagai Kota Cerdas (Smart City) yang Ramah Keluarga dan Inovatif"</h2>
                    <p class="visi-desc">Menjadi kota yang memanfaatkan teknologi informasi secara optimal untuk meningkatkan kualitas hidup, efisiensi pelayanan, dan daya saing ekonomi secara berkelanjutan demi kesejahteraan seluruh masyarakat.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 🎯 MISI SECTION -->
<section class="misi-section">
    <div class="container">
        
        <div class="text-center" data-aos="fade-up">
            <h2 class="fw-bold" style="color: var(--text-main); font-size: 2.5rem; letter-spacing: -0.5px;">Misi Strategis Kami</h2>
            <p class="text-muted" style="font-size: 1.1rem;">Empat pilar utama dalam menjalankan mandat pelayanan kepada publik.</p>
        </div>

        <div class="misi-grid">
            
            <!-- Misi 1 -->
            <div class="misi-card" data-aos="fade-up" data-aos-delay="100">
                <div class="misi-number">01</div>
                <div class="misi-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"></path></svg>
                </div>
                <h4 class="misi-title">Infrastruktur Digital</h4>
                <p class="misi-text">Menyelenggarakan dan mengembangkan infrastruktur jaringan telekomunikasi dan sistem informasi yang andal, aman, dan terintegrasi penuh.</p>
            </div>

            <!-- Misi 2 -->
            <div class="misi-card" data-aos="fade-up" data-aos-delay="200">
                <div class="misi-number">02</div>
                <div class="misi-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                </div>
                <h4 class="misi-title">Pelayanan Publik TIK</h4>
                <p class="misi-text">Meningkatkan kualitas pelayanan publik melalui penyediaan aplikasi dan portal layanan digital yang responsif, cerdas, dan transparan.</p>
            </div>

            <!-- Misi 3 -->
            <div class="misi-card" data-aos="fade-up" data-aos-delay="300">
                <div class="misi-number">03</div>
                <div class="misi-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                </div>
                <h4 class="misi-title">Keterbukaan Informasi</h4>
                <p class="misi-text">Mewujudkan keterbukaan informasi publik dan tata kelola kehumasan yang baik untuk membangun komunikasi positif dua arah.</p>
            </div>

            <!-- Misi 4 -->
            <div class="misi-card" data-aos="fade-up" data-aos-delay="400">
                <div class="misi-number">04</div>
                <div class="misi-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                </div>
                <h4 class="misi-title">Keamanan Siber & Data</h4>
                <p class="misi-text">Meningkatkan tata kelola persandian untuk keamanan informasi pemerintah serta memastikan data sektoral yang akurat dan terpadu.</p>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
