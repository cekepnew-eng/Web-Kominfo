<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/report-service.php';

$pageTitle = 'Lacak Laporan';
$activePage = 'laporan';
$extraScripts = ['../assets/js/lacak-laporan.js'];

require __DIR__ . '/../includes/header.php';

$ticketPrefill = trim((string) ($_GET['ticket'] ?? ''));
?>

<main>
    <section class="border-b border-slate-200/70 bg-[radial-gradient(circle_at_top_left,_rgba(49,107,218,0.08),_transparent_30%),linear-gradient(180deg,_#f8fbff_0%,_#ffffff_46%,_#f5f8fc_100%)]">
        <div class="mx-auto max-w-3xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">
            <div class="text-center">
                <p class="text-[11px] font-semibold uppercase tracking-[0.32em] text-brand-700">Status Pengaduan</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">Lacak Status Laporan</h1>
                <p class="mx-auto mt-3 max-w-lg text-sm leading-7 text-slate-600">Masukkan nomor tiket laporan Anda untuk melihat status verifikasi dan progres penanganan.</p>
            </div>

            <div class="mt-10 rounded-[1.4rem] border border-slate-200 bg-white p-6 shadow-soft sm:p-8">
                <form id="track-form" class="flex flex-col gap-3 sm:flex-row">
                    <div class="flex-1">
                        <label for="ticket" class="sr-only">Nomor tiket</label>
                        <input type="text" id="ticket" name="ticket" value="<?= esc($ticketPrefill) ?>"
                            placeholder="Contoh: LP-20260617-0001"
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm font-mono text-slate-700 outline-none transition focus:border-brand-300 focus:ring-2 focus:ring-brand-100" />
                    </div>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-brand-700 px-6 py-3 text-sm font-semibold text-white shadow-soft transition hover:bg-brand-800">
                        <span data-track-btn-text>Cek Status</span>
                        <svg data-track-spinner class="hidden h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                    </button>
                </form>
                <p class="mt-3 hidden text-sm text-red-600" data-track-error></p>
            </div>

            <div class="mt-8 hidden" data-track-result>
                <article class="overflow-hidden rounded-[1.4rem] border border-slate-200 bg-white shadow-soft">
                    <div class="border-b border-slate-100 bg-gradient-to-r from-brand-900 to-brand-700 px-6 py-5 text-white sm:px-8">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-brand-200">Nomor Tiket</p>
                                <p class="mt-1 font-mono text-xl font-bold" data-result-ticket></p>
                            </div>
                            <span class="rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wider" data-result-status-badge></span>
                        </div>
                    </div>
                    <div class="p-6 sm:p-8">
                        <div class="grid gap-6 md:grid-cols-[1fr_auto]">
                            <div>
                                <span class="inline-block rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700" data-result-category></span>
                                <h2 class="mt-3 text-xl font-bold text-slate-950" data-result-title></h2>
                                <p class="mt-3 text-sm leading-7 text-slate-600" data-result-description></p>
                                <p class="mt-4 flex items-start gap-2 text-sm text-slate-500">
                                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s7-4.5 7-11a7 7 0 10-14 0c0 6.5 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                                    <span data-result-address></span>
                                </p>
                                <p class="mt-2 text-xs text-slate-400">Dikirim: <span data-result-date></span></p>
                            </div>
                            <img src="" alt="Foto laporan" class="hidden h-32 w-32 rounded-2xl border border-slate-200 object-cover shadow-soft md:h-40 md:w-40" data-result-photo />
                        </div>

                        <div class="mt-8">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">Riwayat Status</h3>
                            <ol class="mt-4 space-y-4" data-result-history></ol>
                        </div>
                    </div>
                </article>
            </div>

            <p class="mt-6 text-center text-sm text-slate-500">
                Belum punya tiket? <a href="laporan.php" class="font-semibold text-brand-700 hover:underline">Kirim laporan baru</a>
            </p>
        </div>
    </section>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
