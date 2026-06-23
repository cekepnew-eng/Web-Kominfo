(function () {
    'use strict';

    const BOGOR_CENTER = [-6.5950, 106.8166];
    const DEFAULT_ZOOM = 13;
    const MAX_IMAGES = 5;
    const MAX_BYTES = 5 * 1024 * 1024;
    const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/webp'];

    const CATEGORY_LABELS = {
        jalan_rusak: 'Jalan Rusak',
        sampah: 'Sampah',
        penerangan_jalan: 'Penerangan Jalan',
        drainase_banjir: 'Drainase/Banjir',
        fasilitas_umum: 'Fasilitas Umum',
        lainnya: 'Lainnya',
    };

    const DUMMY_REPORTS = [
        {
            title: 'Jalan berlubang parah di Jl. Pajajaran',
            latitude: -6.5949,
            longitude: 106.8165,
            status_label: 'Sedang Diproses',
            status_color: '#2563eb',
        },
        {
            title: 'Sampah menumpuk di depan Pasar Anyar',
            latitude: -6.5868,
            longitude: 106.8227,
            status_label: 'Terverifikasi',
            status_color: '#316bda',
        },
        {
            title: 'Lampu jalan mati di kawasan Cibadak',
            latitude: -6.6012,
            longitude: 106.8149,
            status_label: 'Menunggu Verifikasi',
            status_color: '#eab308',
        },
    ];

    document.addEventListener('DOMContentLoaded', init);

    function init() {
        const page = document.querySelector('[data-laporan-page]');
        if (!page) return;

        const form = document.getElementById('report-form');
        const state = {
            files: [],
            latitude: null,
            longitude: null,
            address: '',
            map: null,
            marker: null,
            clusterLayer: null,
            geocoding: false,
        };

        const els = {
            submitBtn: page.querySelector('[data-submit-btn]'),
            submitText: page.querySelector('[data-submit-text]'),
            submitSpinner: page.querySelector('[data-submit-spinner]'),
            successModal: page.querySelector('[data-success-modal]'),
            successMessage: page.querySelector('[data-success-message]'),
            ticketNumber: page.querySelector('[data-ticket-number]'),
            trackLink: page.querySelector('[data-track-link]'),
            copyTicket: page.querySelector('[data-copy-ticket]'),
            closeModal: page.querySelector('[data-close-modal]'),
            errorToast: page.querySelector('[data-error-toast]'),
            toastMessage: page.querySelector('[data-toast-message]'),
            retrySubmit: page.querySelector('[data-retry-submit]'),
            dropzone: page.querySelector('[data-dropzone]'),
            fileInput: page.querySelector('[data-file-input]'),
            pickPhotos: page.querySelector('[data-pick-photos]'),
            imagePreviews: page.querySelector('[data-image-previews]'),
            mapLoading: page.querySelector('[data-map-loading]'),
            selectedAddress: page.querySelector('[data-selected-address]'),
            addressText: page.querySelector('[data-address-text]'),
            useMyLocation: page.querySelector('[data-use-my-location]'),
            previewCards: page.querySelectorAll('[data-preview-card]'),
        };

        initMap();
        bindFormEvents();
        bindUploadEvents();
        bindModalEvents();
        updatePreview();
        validateForm();

        function initMap() {
            const mapEl = document.getElementById('report-preview-map');
            if (!mapEl || typeof google === 'undefined' || typeof google.maps === 'undefined') {
                console.warn('Google Maps API tidak tersedia.');
                return;
            }

            state.map = new google.maps.Map(mapEl, {
                center: { lat: BOGOR_CENTER[0], lng: BOGOR_CENTER[1] },
                zoom: DEFAULT_ZOOM,
                streetViewControl: false,
                mapTypeControl: false,
            });

            state.infoWindow = new google.maps.InfoWindow();

            state.map.addListener('click', (e) => setLocation(e.latLng.lat(), e.latLng.lng()));
            loadExistingReports();
        }

        async function loadExistingReports() {
            try {
                const res = await fetch(`laporan-api.php?lat=${BOGOR_CENTER[0]}&lng=${BOGOR_CENTER[1]}&radius=10&limit=200`);
                if (!res.ok) {
                    throw new Error('Fetch error');
                }

                const data = await res.json();
                if (!data.success || !Array.isArray(data.items)) {
                    throw new Error('No report data');
                }

                if (data.items.length === 0) {
                    renderReportMarkers(DUMMY_REPORTS, true);
                    return;
                }

                renderReportMarkers(data.items);
            } catch (_) {
                renderReportMarkers(DUMMY_REPORTS, true);
            }
        }

        function renderReportMarkers(items, isDummy = false) {
            if (!state.map) return;

            if (Array.isArray(state.reportMarkers)) {
                state.reportMarkers.forEach((marker) => marker.setMap(null));
            }
            state.reportMarkers = [];

            const bounds = new google.maps.LatLngBounds();
            items.forEach((item) => {
                const marker = new google.maps.Marker({
                    position: { lat: Number(item.latitude), lng: Number(item.longitude) },
                    map: state.map,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 8,
                        fillColor: item.status_color || '#eab308',
                        fillOpacity: 1,
                        strokeColor: '#ffffff',
                        strokeWeight: 2,
                    },
                });

                marker.addListener('click', () => {
                    state.infoWindow.setContent(`
                        <div style="max-width:220px;font-size:13px;line-height:1.4;">
                            <strong>${escapeHtml(item.title)}</strong><br>
                            <span style="color:#555;">${escapeHtml(item.status_label || 'Menunggu Verifikasi')}</span>
                        </div>
                    `);
                    state.infoWindow.open(state.map, marker);
                });

                state.reportMarkers.push(marker);
                bounds.extend(marker.position);
            });

            if (items.length > 0) {
                state.map.fitBounds(bounds, 100);
            }
        }

        function setLocation(lat, lng) {
            state.latitude = lat;
            state.longitude = lng;
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            if (state.marker) {
                state.marker.setPosition({ lat, lng });
            } else if (state.map) {
                state.marker = new google.maps.Marker({
                    position: { lat, lng },
                    map: state.map,
                    draggable: true,
                });
                state.marker.addListener('dragend', () => {
                    const pos = state.marker.getPosition();
                    if (pos) {
                        setLocation(pos.lat(), pos.lng());
                    }
                });
            }

            if (state.map) {
                state.map.panTo({ lat, lng });
                state.map.setZoom(15);
            }

            reverseGeocode(lat, lng);
            clearError('location');
            updatePreview();
            validateForm();
        }

        async function reverseGeocode(lat, lng) {
            if (state.geocoding) return;
            state.geocoding = true;
            if (els.addressText) els.addressText.textContent = 'Mencari alamat...';

            try {
                const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;
                const res = await fetch(url, { headers: { 'Accept-Language': 'id' } });
                const data = await res.json();
                state.address = data.display_name || `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            } catch (_) {
                state.address = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            }

            document.getElementById('address').value = state.address;
            if (els.addressText) els.addressText.textContent = state.address;
            state.geocoding = false;
            updatePreview();
        }

        els.useMyLocation?.addEventListener('click', () => {
            if (!navigator.geolocation) {
                showError('Geolokasi tidak didukung browser Anda.');
                return;
            }
            els.useMyLocation.disabled = true;
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    const { latitude, longitude } = pos.coords;
                    if (state.map) {
                        state.map.panTo({ lat: latitude, lng: longitude });
                        state.map.setZoom(15);
                    }
                    setLocation(latitude, longitude);
                    els.useMyLocation.disabled = false;
                },
                () => {
                    showError('Tidak dapat mengakses lokasi. Izinkan akses GPS atau pilih manual di peta.');
                    els.useMyLocation.disabled = false;
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        });

        function bindFormEvents() {
            form.querySelectorAll('[data-report-field]').forEach((field) => {
                const event = field.type === 'checkbox' || field.tagName === 'SELECT' ? 'change' : 'input';
                field.addEventListener(event, () => {
                    updateCharCount(field);
                    clearError(field.dataset.reportField || field.id);
                    updatePreview();
                    validateForm();
                });
            });

            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                if (!validateForm(true)) return;
                await submitReport();
            });
        }

        function updateCharCount(field) {
            const name = field.id || field.name;
            const counter = page.querySelector(`[data-char-count="${name}"]`);
            if (counter) counter.textContent = (field.value || '').length;
        }

        function bindUploadEvents() {
            els.pickPhotos?.addEventListener('click', (e) => {
                e.stopPropagation();
                els.fileInput?.click();
            });

            els.dropzone?.addEventListener('click', () => els.fileInput?.click());
            els.dropzone?.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    els.fileInput?.click();
                }
            });

            els.dropzone?.addEventListener('dragover', (e) => {
                e.preventDefault();
                els.dropzone.classList.add('is-dragover');
            });
            els.dropzone?.addEventListener('dragleave', () => els.dropzone.classList.remove('is-dragover'));
            els.dropzone?.addEventListener('drop', (e) => {
                e.preventDefault();
                els.dropzone.classList.remove('is-dragover');
                handleFiles(e.dataTransfer?.files);
            });

            els.fileInput?.addEventListener('change', () => handleFiles(els.fileInput.files));
        }

        async function handleFiles(fileList) {
            if (!fileList) return;
            const incoming = Array.from(fileList);
            clearError('images');

            for (const file of incoming) {
                if (state.files.length >= MAX_IMAGES) {
                    setError('images', `Maksimal ${MAX_IMAGES} foto.`);
                    break;
                }
                if (!ALLOWED_TYPES.includes(file.type)) {
                    setError('images', 'Format harus JPG, PNG, atau WEBP.');
                    continue;
                }
                if (file.size > MAX_BYTES) {
                    setError('images', 'Ukuran maksimal 5MB per foto.');
                    continue;
                }

                let processed = file;
                if (typeof imageCompression !== 'undefined') {
                    try {
                        processed = await imageCompression(file, {
                            maxSizeMB: 1,
                            maxWidthOrHeight: 1920,
                            useWebWorker: true,
                        });
                    } catch (_) {
                        processed = file;
                    }
                }

                state.files.push(processed);
            }

            renderImagePreviews();
            updatePreview();
            validateForm();
            if (els.fileInput) els.fileInput.value = '';
        }

        function renderImagePreviews() {
            if (!els.imagePreviews) return;
            els.imagePreviews.innerHTML = '';

            state.files.forEach((file, index) => {
                const url = URL.createObjectURL(file);
                const wrap = document.createElement('div');
                wrap.className = 'group relative aspect-square overflow-hidden rounded-xl border border-slate-200 bg-slate-100';
                wrap.innerHTML = `
                    <img src="${url}" alt="Preview ${index + 1}" class="h-full w-full object-cover" />
                    ${index === 0 ? '<span class="absolute left-1 top-1 rounded bg-brand-700 px-1.5 py-0.5 text-[9px] font-bold text-white">UTAMA</span>' : ''}
                    <button type="button" data-remove-index="${index}" class="absolute right-1 top-1 grid h-6 w-6 place-items-center rounded-full bg-red-600 text-white opacity-0 transition group-hover:opacity-100" aria-label="Hapus foto">
                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M6 6l12 12M18 6L6 18"/></svg>
                    </button>`;
                wrap.querySelector('[data-remove-index]')?.addEventListener('click', () => {
                    state.files.splice(index, 1);
                    renderImagePreviews();
                    updatePreview();
                    validateForm();
                });
                els.imagePreviews.appendChild(wrap);
            });
        }

        function getFormData() {
            return {
                category: document.getElementById('category')?.value || '',
                title: document.getElementById('title')?.value.trim() || '',
                description: document.getElementById('description')?.value.trim() || '',
                reporter_name: document.getElementById('reporter_name')?.value.trim() || '',
                reporter_contact: document.getElementById('reporter_contact')?.value.trim() || '',
                declaration: document.getElementById('declaration')?.checked || false,
            };
        }

        function validateForm(showAll) {
            const data = getFormData();
            let valid = true;

            if (!data.category) { if (showAll) setError('category', 'Kategori wajib dipilih.'); valid = false; }
            if (!data.title) { if (showAll) setError('title', 'Judul wajib diisi.'); valid = false; }
            if (data.description.length < 20) { if (showAll) setError('description', 'Deskripsi minimal 20 karakter.'); valid = false; }
            if (state.latitude === null || state.longitude === null) { if (showAll) setError('location', 'Pilih lokasi di peta.'); valid = false; }
            if (state.files.length < 1) { if (showAll) setError('images', 'Minimal 1 foto wajib diunggah.'); valid = false; }
            if (!data.declaration) { if (showAll) setError('declaration', 'Anda harus menyetujui pernyataan.'); valid = false; }

            if (els.submitBtn) els.submitBtn.disabled = !valid;
            return valid;
        }

        function updatePreview() {
            const data = getFormData();
            els.previewCards.forEach((card) => {
                const catEl = card.querySelector('[data-preview-category]');
                const titleEl = card.querySelector('[data-preview-title]');
                const descEl = card.querySelector('[data-preview-description]');
                const addrEl = card.querySelector('[data-preview-address]');
                const photoEl = card.querySelector('[data-preview-photo]');
                const placeholderEl = card.querySelector('[data-preview-photo-placeholder]');

                if (catEl) catEl.textContent = CATEGORY_LABELS[data.category] || 'Kategori';
                if (titleEl) titleEl.textContent = data.title || 'Judul laporan Anda';
                if (descEl) descEl.textContent = data.description || 'Deskripsi singkat akan muncul di sini saat Anda mengisi form.';
                if (addrEl) addrEl.textContent = state.address || 'Pilih lokasi di peta';

                if (state.files.length > 0 && photoEl && placeholderEl) {
                    photoEl.src = URL.createObjectURL(state.files[0]);
                    photoEl.classList.remove('hidden');
                    placeholderEl.classList.add('hidden');
                } else if (photoEl && placeholderEl) {
                    photoEl.classList.add('hidden');
                    photoEl.src = '';
                    placeholderEl.classList.remove('hidden');
                }
            });
        }

        async function submitReport() {
            setSubmitting(true);
            hideError();

            const fd = new FormData();
            const data = getFormData();
            fd.append('category', data.category);
            fd.append('title', data.title);
            fd.append('description', data.description);
            fd.append('latitude', String(state.latitude));
            fd.append('longitude', String(state.longitude));
            fd.append('address', state.address);
            fd.append('reporter_name', data.reporter_name);
            fd.append('reporter_contact', data.reporter_contact);
            state.files.forEach((file) => fd.append('images[]', file, file.name));

            try {
                const res = await fetch('laporan-api.php', { method: 'POST', body: fd });
                const result = await res.json();

                if (!res.ok || !result.success) {
                    if (result.errors) {
                        Object.entries(result.errors).forEach(([k, v]) => setError(k, v));
                    }
                    throw new Error(result.message || 'Gagal mengirim laporan.');
                }

                showSuccess(result);
                form.reset();
                state.files = [];
                state.latitude = null;
                state.longitude = null;
                state.address = '';
                if (state.marker) { state.map.removeLayer(state.marker); state.marker = null; }
                renderImagePreviews();
                els.selectedAddress?.classList.add('hidden');
                updatePreview();
                validateForm();
            } catch (err) {
                showError(err.message || 'Terjadi kesalahan jaringan.');
            } finally {
                setSubmitting(false);
            }
        }

        function setSubmitting(on) {
            if (els.submitBtn) els.submitBtn.disabled = on;
            els.submitSpinner?.classList.toggle('hidden', !on);
            if (els.submitText) els.submitText.textContent = on ? 'Mengirim...' : 'Kirim Laporan';
        }

        function showSuccess(result) {
            if (els.ticketNumber) els.ticketNumber.textContent = result.ticket_number || '';
            if (els.successMessage) els.successMessage.textContent = result.message || '';
            if (els.trackLink) els.trackLink.href = `lacak-laporan.php?ticket=${encodeURIComponent(result.ticket_number || '')}`;
            els.successModal?.classList.remove('hidden');
            els.successModal?.classList.add('flex');
        }

        function bindModalEvents() {
            els.copyTicket?.addEventListener('click', () => {
                const ticket = els.ticketNumber?.textContent || '';
                navigator.clipboard?.writeText(ticket).then(() => {
                    els.copyTicket.textContent = 'Tersalin!';
                    setTimeout(() => { els.copyTicket.textContent = 'Salin'; }, 2000);
                });
            });

            els.closeModal?.addEventListener('click', () => {
                els.successModal?.classList.add('hidden');
                els.successModal?.classList.remove('flex');
            });

            els.retrySubmit?.addEventListener('click', () => {
                hideError();
                submitReport();
            });
        }

        function setError(field, msg) {
            const el = page.querySelector(`[data-error="${field}"]`);
            if (el) { el.textContent = msg; el.classList.remove('hidden'); }
        }

        function clearError(field) {
            const el = page.querySelector(`[data-error="${field}"]`);
            if (el) { el.textContent = ''; el.classList.add('hidden'); }
        }

        function showError(msg) {
            if (els.toastMessage) els.toastMessage.textContent = msg;
            els.errorToast?.classList.remove('hidden');
        }

        function hideError() {
            els.errorToast?.classList.add('hidden');
        }

        function escapeHtml(str) {
            const d = document.createElement('div');
            d.textContent = str;
            return d.innerHTML;
        }
    }
})();
