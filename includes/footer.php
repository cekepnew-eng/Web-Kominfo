  <!-- ═══════════ FOOTER ═══════════ -->
  <footer class="site-footer">
    <div class="container">
      <div class="row g-5">

        <!-- Brand -->
        <div class="col-lg-4">
          <div class="footer-brand d-flex align-items-center gap-2 mb-3">
            <img src="<?= $basePath ?>/includes/image/kominfo.jpg" alt="Logo" class="rounded-2">
            <strong>Diskominfo Kota Bogor</strong>
          </div>
          <p class="footer-desc">Membangun ekosistem digital yang inovatif dan transparan untuk pelayanan publik Kota Bogor yang lebih baik.</p>
        </div>

        <!-- Navigasi -->
        <div class="col-sm-6 col-lg-2">
          <p class="footer-heading">Navigasi</p>
          <div class="footer-links">
            <a href="<?= $basePath ?>/user/index.php">Beranda</a>
            <a href="<?= $basePath ?>/user/sejarah.php">Sejarah</a>
            <a href="<?= $basePath ?>/user/visi-misi.php">Visi &amp; Misi</a>
            <a href="<?= $basePath ?>/user/laporan.php">Pengaduan</a>
            <a href="<?= $basePath ?>/user/berita.php">Berita</a>
            <a href="<?= $basePath ?>/user/cctv.php">CCTV</a>
          </div>
        </div>

        <!-- Layanan -->
        <div class="col-sm-6 col-lg-2">
          <p class="footer-heading">Layanan</p>
          <div class="footer-links">
            <a href="https://ppid.kotabogor.go.id" target="_blank">PPID</a>
            <a href="https://smartcity.kotabogor.go.id" target="_blank">Smart City</a>
            <a href="<?= $basePath ?>/user/kinara.php">Kinara AI</a>
          </div>
        </div>

        <!-- Kontak -->
        <div class="col-lg-4">
          <p class="footer-heading">Kontak</p>
          <div class="footer-contact">
            <div class="footer-contact-item">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              <span>Jl. Ir. H. Juanda No.10, Kota Bogor, Jawa Barat</span>
            </div>
            <div class="footer-contact-item">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              <span>kominfo@kotabogor.go.id</span>
            </div>
            <div class="footer-contact-item">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12.7 19.79 19.79 0 0 1 1.62 4.07 2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              <span>(0251) 8321075</span>
            </div>
          </div>
        </div>

      </div>

      <div class="footer-bottom">
        &copy; <?= date('Y') ?> Diskominfo Kota Bogor. Hak Cipta Dilindungi.
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <script src="<?= $basePath ?>/assets/js/main.js"></script>
  <script>
    AOS.init({ once: true, duration: 560, offset: 30, easing: 'ease-out-cubic' });

    // Navbar scroll state
    const nav = document.getElementById('siteNav');
    window.addEventListener('scroll', () => {
      nav.classList.toggle('scrolled', window.scrollY > 20);
    }, { passive: true });

    // Mobile menu
    const burger = document.getElementById('hamburger');
    const menu   = document.getElementById('navMenu');
    if (burger && menu) {
      burger.addEventListener('click', () => {
        menu.classList.toggle('open');
        burger.classList.toggle('open');
      });
    }
  </script>
</body>
</html>

