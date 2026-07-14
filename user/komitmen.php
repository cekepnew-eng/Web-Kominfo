<?php
declare(strict_types=1);

$pageTitle  = 'Daftar Komitmen — Diskominfo Kota Bogor';
$activePage = 'komitmen';

require_once __DIR__ . '/../includes/header.php';
?>

<style>
  /* Override default body background */
  body {
    background: transparent !important;
  }

  .page-background {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(135deg, #6366f1 0%, #3b82f6 100%);
    z-index: -1;
  }

  .main-container {
    max-width: 1200px;
    margin: 120px auto 60px auto;
    background: #f8fafc;
    border-radius: 32px;
    padding: 3rem 4rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    position: relative;
    z-index: 1;
  }

  /* Responsive Main Container */
  @media (max-width: 768px) {
    .main-container {
      margin: 100px 15px 40px 15px;
      padding: 2rem 1.5rem;
      border-radius: 20px;
    }
  }

  .banner-box {
    background: #213269;
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    border-radius: 8px;
    margin-bottom: 2.5rem;
    position: relative;
    border: 2px solid #ceb076;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
  }
  .banner-box::before {
    content: '';
    position: absolute;
    top: 6px; left: 6px; right: 6px; bottom: 6px;
    border: 1px solid #ceb076;
    pointer-events: none;
  }
  .banner-logo {
    width: 80px;
    height: auto;
    position: relative;
    z-index: 2;
  }
  .banner-text {
    color: #ffffff;
    font-weight: 700;
    font-size: 1.6rem;
    margin: 0;
    text-align: center;
    flex: 1;
    letter-spacing: 0.5px;
    position: relative;
    z-index: 2;
    padding-right: 80px; /* Offset the logo width to ensure true center */
  }
  @media (max-width: 768px) {
    .banner-box { flex-direction: column; text-align: center; padding: 1.5rem; }
    .banner-text { font-size: 1.1rem; }
  }

  .pakta-title {
    text-align: center;
    color: #1e3a8a;
    font-weight: 900;
    font-size: 2.2rem;
    margin-bottom: 2rem;
    letter-spacing: -0.5px;
  }

  .pakta-box {
    background: #ffffff;
    border-left: 8px solid #1e3a8a;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    margin-bottom: 3rem;
  }
  .pakta-box p {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1.2rem;
    font-size: 1.1rem;
  }
  .pakta-box ol {
    margin: 0;
    padding-left: 1.5rem;
    color: #334155;
    line-height: 1.8;
    font-size: 1.05rem;
  }
  .pakta-box ol li {
    margin-bottom: 0.8rem;
    padding-left: 0.5rem;
  }

  .grid-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
  }

  .employee-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 2.5rem 1.5rem 2rem 1.5rem;
    position: relative;
    overflow: hidden;
    text-align: center;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .employee-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  }

  .ribbon {
    position: absolute;
    top: 24px;
    right: -38px;
    background: #16a34a;
    color: white;
    padding: 6px 45px;
    font-size: 0.8rem;
    font-weight: 800;
    transform: rotate(45deg);
    box-shadow: 0 2px 4px rgba(0,0,0,0.15);
    letter-spacing: 0.5px;
  }

  .emp-name {
    font-weight: 800;
    color: #0f172a;
    font-size: 1.15rem;
    margin-bottom: 0.4rem;
  }
  .emp-pos {
    color: #64748b;
    font-size: 0.9rem;
    margin-bottom: 1.8rem;
    line-height: 1.4;
    min-height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .badge-date {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #dcfce7;
    color: #16a34a;
    border: 1px solid #bbf7d0;
    padding: 8px 18px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 700;
  }
  .badge-date svg {
    width: 16px; height: 16px;
  }

</style>

<div class="page-background"></div>

<div class="main-container" data-aos="fade-up">
  
  <div class="banner-box">
    <img src="../includes/image/pemkot1.png" alt="Logo Pemkot Bogor" class="banner-logo">
    <h2 class="banner-text">
      <span style="font-size: 1.2rem; font-weight: 500;">KOMITMEN</span><br>
      DINAS KOMUNIKASI DAN INFORMATIKA KOTA BOGOR
    </h2>
  </div>

  <h1 class="pakta-title">PAKTA INTEGRITAS</h1>

  <div class="pakta-box">
    <p>Kami, Pegawai Dinas Komunikasi dan Informatika Kota Bogor menyatakan sebagai berikut:</p>
    <ol>
      <li>Berperan secara proaktif dalam upaya pencegahan dan pemberantasan Korupsi, Kolusi, dan Nepotisme serta tidak melibatkan diri dalam perbuatan tercela;</li>
      <li>Tidak meminta atau menerima pemberian secara langsung atau tidak langsung berupa suap, hadiah, bantuan, atau bentuk lainnya yang tidak sesuai dengan ketentuan yang berlaku;</li>
      <li>Bersikap transparan, jujur, objektif, dan akuntabel dalam melaksanakan tugas;</li>
      <li>Menghindari pertentangan kepentingan (conflict of interest) dalam pelaksanaan tugas;</li>
      <li>Memberi contoh dalam kepatuhan terhadap peraturan perundang-undangan dalam melaksanakan tugas, terutama kepada karyawan yang berada di bawah pengawasan saya dan sesama pegawai di lingkungan kerja saya secara konsisten;</li>
      <li>Akan menyampaikan informasi penyimpangan integritas di instansi saya serta turut menjaga kerahasiaan saksi atas pelanggaran peraturan yang dilaporkannya;</li>
      <li>Bila saya melanggar hal-hal tersebut di atas, saya siap menghadapi konsekuensinya.</li>
    </ol>
  </div>

  <div class="grid-cards">
    
    <?php
    // Dummy Data Pegawai
    $employees = [
        ["name" => "Iceu Pujiati, SH., MM", "position" => "Plt.Kepala Dinas Komunikasi dan Informatika Kota Bogor", "date" => "15-01-2026"],
        ["name" => "Asep Zaenal, S.Kom, M.Si", "position" => "Sekretaris Dinas Komunikasi dan Informatika", "date" => "16-01-2026"],
        ["name" => "Dr. Rina Purnamasari, ST., MT", "position" => "Kepala Bidang E-Government", "date" => "16-01-2026"],
        ["name" => "Budi Santoso, S.Sos", "position" => "Kepala Bidang Informasi dan Komunikasi Publik", "date" => "17-01-2026"],
        ["name" => "Rudi Hermawan, S.Kom", "position" => "Kepala Bidang Persandian dan Statistik", "date" => "17-01-2026"],
        ["name" => "Siti Nurbaya, SE., Ak", "position" => "Kasubag Umum dan Kepegawaian", "date" => "18-01-2026"],
        ["name" => "Dewi Sartika, S.Si", "position" => "Pranata Komputer Ahli Muda", "date" => "18-01-2026"],
        ["name" => "Agus Setiawan, ST", "position" => "Sandiman Ahli Muda", "date" => "19-01-2026"]
    ];

    foreach ($employees as $emp):
    ?>
    <div class="employee-card" data-aos="zoom-in">
      <div class="ribbon">Sudah TTD</div>
      <h3 class="emp-name"><?= $emp['name'] ?></h3>
      <div class="emp-pos"><?= $emp['position'] ?></div>
      <div class="badge-date">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        Ditandatangani pada: <?= $emp['date'] ?>
      </div>
    </div>
    <?php endforeach; ?>

  </div>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
