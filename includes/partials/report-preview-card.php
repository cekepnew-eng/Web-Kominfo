<div class="report-preview-card overflow-hidden rounded-2xl border border-brand-200/60 bg-[linear-gradient(160deg,#172c5e_0%,#234596_55%,rgba(49,107,218,0.15)_100%)] shadow-panel transition-all duration-300" data-preview-card>
    <div class="flex min-h-[280px]">
        <!-- Text summary (left) -->
        <div class="flex flex-1 flex-col justify-between p-5 sm:p-6">
            <div>
                <span class="inline-block rounded-full bg-white/15 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-white/90" data-preview-category>
                    Kategori
                </span>
                <h3 class="mt-3 line-clamp-2 text-lg font-extrabold leading-snug text-white sm:text-xl" data-preview-title>
                    Judul laporan Anda
                </h3>
                <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-brand-100/80" data-preview-description>
                    Deskripsi singkat akan muncul di sini saat Anda mengisi form.
                </p>
            </div>
            <div class="mt-4 border-t border-white/10 pt-4">
                <p class="flex items-start gap-2 text-xs text-brand-100/70">
                    <svg class="mt-0.5 h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s7-4.5 7-11a7 7 0 10-14 0c0 6.5 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                    <span data-preview-address>Pilih lokasi di peta</span>
                </p>
                <span class="mt-2 inline-flex items-center rounded-full bg-amber-400/20 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-amber-200" data-preview-status>
                    Menunggu Verifikasi
                </span>
            </div>
        </div>
        <!-- Photo (right) -->
        <div class="relative w-[42%] shrink-0 border-l border-white/10 bg-brand-900/30">
            <div class="absolute inset-0 grid place-items-center" data-preview-photo-placeholder>
                <div class="text-center text-white/40">
                    <svg class="mx-auto h-12 w-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="8.5" cy="10.5" r="1.5"/><path d="M21 16l-5-5L5 20"/>
                    </svg>
                    <p class="mt-2 text-[10px] font-medium uppercase tracking-wider">Foto Bukti</p>
                </div>
            </div>
            <img src="" alt="Preview foto laporan" class="hidden h-full w-full object-cover" data-preview-photo />
        </div>
    </div>
</div>
