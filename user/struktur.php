<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/services.php';

$pageTitle = 'Struktur Organisasi';
$activePage = 'struktur';

$secretariat = [
    ['name' => 'Rike Ratina Ayuningsih, S.E., M.M.', 'position' => 'Sekretaris Dinas'],
    ['name' => 'Susilawaty Syariefah, S.Sos., M.A.', 'position' => 'Kasubag Umum dan Kepegawaian'],
];

$fields = [
    ['name' => 'Bidang Informasi Komunikasi Publik', 'position' => 'Pengelolaan komunikasi publik dan media pemerintah'],
    ['name' => 'Bidang Aplikasi Informatika', 'position' => 'Pengembangan aplikasi, infrastruktur, dan layanan digital'],
    ['name' => 'Bidang Statistik dan Persandian', 'position' => 'Penguatan data sektoral, persandian, dan keamanan informasi'],
];

require __DIR__ . '/../includes/header.php';
?>

<main>
    <section class="border-b border-slate-200/70 bg-[radial-gradient(circle_at_top_left,_rgba(49,107,218,0.08),_transparent_30%),linear-gradient(180deg,_#f8fbff_0%,_#ffffff_48%,_#f5f8fc_100%)]">
        <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">
            <div class="rounded-[1.9rem] border border-slate-200 bg-white p-7 shadow-soft sm:p-10">
                <p class="text-[11px] font-semibold uppercase tracking-[0.32em] text-brand-700">Profil Organisasi</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">Struktur Organisasi Diskominfo Kota Bogor</h2>
                <p class="mt-4 max-w-3xl text-sm leading-7 text-slate-600 sm:text-base">Susunan organisasi disajikan ringkas untuk memudahkan masyarakat mengenali struktur kepemimpinan dan unit kerja utama.</p>

                <article class="mt-8 rounded-[1.35rem] border border-slate-200 bg-white p-6 shadow-soft">
                    <p class="text-center text-xs font-semibold uppercase tracking-[0.22em] text-brand-700">Kepala Dinas</p>
                    <div class="mx-auto mt-4 max-w-xs rounded-[1.2rem] border border-slate-200 bg-slate-50 p-5 text-center">
                        <div class="mx-auto mb-4 h-24 w-24 rounded-full border-4 border-brand-100 bg-[linear-gradient(130deg,_#dbeafe_0%,_#f8fafc_55%,_#dceeff_100%)]"></div>
                        <h3 class="text-lg font-bold tracking-tight text-slate-950">Rudiyana, S.STP., M.Sc</h3>
                        <p class="mt-1 text-sm text-slate-600">Kepala Dinas Komunikasi dan Informatika</p>
                    </div>
                </article>

                <article class="mt-8 rounded-[1.35rem] border border-slate-200 bg-slate-50 p-6">
                    <p class="text-center text-xs font-semibold uppercase tracking-[0.22em] text-brand-700">Sekretariat</p>
                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <?php foreach ($secretariat as $item): ?>
                            <div class="rounded-[1.1rem] border border-slate-200 bg-white p-5 text-center shadow-soft">
                                <div class="mx-auto mb-3 h-20 w-20 rounded-full bg-[linear-gradient(130deg,_#e2ecff_0%,_#f8fbff_55%,_#dbe7ff_100%)]"></div>
                                <h4 class="text-base font-bold tracking-tight text-slate-950"><?= esc($item['name']) ?></h4>
                                <p class="mt-1 text-sm text-slate-600"><?= esc($item['position']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </article>

                <article class="mt-8 rounded-[1.35rem] border border-slate-200 bg-white p-6 shadow-soft">
                    <p class="text-center text-xs font-semibold uppercase tracking-[0.22em] text-brand-700">Bidang Utama</p>
                    <div class="mt-5 grid gap-4 lg:grid-cols-3">
                        <?php foreach ($fields as $item): ?>
                            <div class="rounded-[1.1rem] border border-slate-200 bg-slate-50 p-5">
                                <h4 class="text-base font-bold tracking-tight text-slate-950"><?= esc($item['name']) ?></h4>
                                <p class="mt-2 text-sm leading-7 text-slate-600"><?= esc($item['position']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </article>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . '/../includes/footer.php';
