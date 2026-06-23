(function () {
    'use strict';

    const STATUS_COLORS = {
        pending_verification: 'bg-amber-100 text-amber-800',
        verified: 'bg-blue-100 text-blue-800',
        in_progress: 'bg-brand-100 text-brand-800',
        resolved: 'bg-emerald-100 text-emerald-800',
        rejected: 'bg-slate-100 text-slate-600',
    };

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('track-form');
        if (!form) return;

        const ticketInput = document.getElementById('ticket');
        const errorEl = document.querySelector('[data-track-error]');
        const resultWrap = document.querySelector('[data-track-result]');
        const btnText = document.querySelector('[data-track-btn-text]');
        const spinner = document.querySelector('[data-track-spinner]');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const ticket = (ticketInput?.value || '').trim();
            if (!ticket) {
                showError('Masukkan nomor tiket laporan.');
                return;
            }
            await fetchTicket(ticket);
        });

        const prefill = (ticketInput?.value || '').trim();
        if (prefill) fetchTicket(prefill);

        async function fetchTicket(ticket) {
            setLoading(true);
            hideError();
            resultWrap?.classList.add('hidden');

            try {
                const res = await fetch(`laporan-api.php?ticket=${encodeURIComponent(ticket)}`);
                const data = await res.json();

                if (!res.ok || !data.success || !data.report) {
                    throw new Error(data.message || 'Nomor tiket tidak ditemukan.');
                }

                renderResult(data.report);
                resultWrap?.classList.remove('hidden');
            } catch (err) {
                showError(err.message || 'Gagal memuat data.');
            } finally {
                setLoading(false);
            }
        }

        function renderResult(report) {
            setText('[data-result-ticket]', report.ticket_number);
            setText('[data-result-category]', report.category_label);
            setText('[data-result-title]', report.title);
            setText('[data-result-description]', report.description);
            setText('[data-result-address]', report.address || '—');

            const dateEl = document.querySelector('[data-result-date]');
            if (dateEl && report.created_at) {
                dateEl.textContent = new Date(report.created_at).toLocaleString('id-ID', {
                    day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit',
                });
            }

            const badge = document.querySelector('[data-result-status-badge]');
            if (badge) {
                badge.textContent = report.status_label || report.status;
                badge.className = 'rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wider ' +
                    (STATUS_COLORS[report.status] || STATUS_COLORS.pending_verification);
            }

            const photo = document.querySelector('[data-result-photo]');
            const imgUrl = report.primary_image || (report.images?.[0]?.url);
            if (photo && imgUrl) {
                photo.src = '../' + imgUrl;
                photo.classList.remove('hidden');
            } else if (photo) {
                photo.classList.add('hidden');
            }

            const historyEl = document.querySelector('[data-result-history]');
            if (historyEl && Array.isArray(report.history)) {
                historyEl.innerHTML = report.history.map((item, i) => {
                    const isLast = i === report.history.length - 1;
                    const date = item.changed_at
                        ? new Date(item.changed_at).toLocaleString('id-ID', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' })
                        : '';
                    return `<li class="flex gap-4 ${isLast ? '' : 'opacity-80'}">
                        <div class="flex flex-col items-center">
                            <span class="grid h-3 w-3 rounded-full ${isLast ? 'bg-brand-600' : 'bg-slate-300'}"></span>
                            ${!isLast ? '<span class="w-px flex-1 bg-slate-200"></span>' : ''}
                        </div>
                        <div class="pb-4">
                            <p class="text-sm font-semibold text-slate-800">${escapeHtml(item.status_label || item.status)}</p>
                            ${item.note ? `<p class="mt-0.5 text-xs text-slate-500">${escapeHtml(item.note)}</p>` : ''}
                            <p class="mt-1 text-[11px] text-slate-400">${date}</p>
                        </div>
                    </li>`;
                }).join('');
            }
        }

        function setText(sel, val) {
            const el = document.querySelector(sel);
            if (el) el.textContent = val || '';
        }

        function setLoading(on) {
            if (btnText) btnText.textContent = on ? 'Memuat...' : 'Cek Status';
            spinner?.classList.toggle('hidden', !on);
        }

        function showError(msg) {
            if (errorEl) { errorEl.textContent = msg; errorEl.classList.remove('hidden'); }
        }

        function hideError() {
            errorEl?.classList.add('hidden');
        }

        function escapeHtml(str) {
            const d = document.createElement('div');
            d.textContent = str;
            return d.innerHTML;
        }
    });
})();
