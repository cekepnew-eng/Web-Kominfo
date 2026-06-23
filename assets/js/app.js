document.addEventListener('DOMContentLoaded', () => {
    const mobileToggle = document.querySelector('[data-mobile-toggle]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');
    const siteHeader = document.querySelector('[data-site-header]');
    const serviceToggle = document.querySelector('[data-service-toggle]');
    const serviceMenu = document.querySelector('[data-service-menu]');
    const serviceWrapper = document.querySelector('[data-service-wrapper]');
    const profileToggle = document.querySelector('[data-profile-toggle]');
    const profileMenu = document.querySelector('[data-profile-menu]');
    const profileWrapper = document.querySelector('[data-profile-wrapper]');
    const navLinks = Array.from(document.querySelectorAll('[data-nav-link]'));
    const sections = Array.from(document.querySelectorAll('main section[id]'));
    const hlsVideos = Array.from(document.querySelectorAll('[data-hls-video]'));
    const heroCarousel = document.querySelector('[data-hero-carousel]');
    const heroSlides = Array.from(document.querySelectorAll('[data-hero-slide]'));
    const heroDots = Array.from(document.querySelectorAll('[data-hero-dot]'));
    const heroPrev = document.querySelector('[data-hero-prev]');
    const heroNext = document.querySelector('[data-hero-next]');
    const newsSearchInput = document.querySelector('[data-news-search]');
    const newsGrid = document.querySelector('[data-news-grid]');
    const newsEmpty = document.querySelector('[data-news-empty]');
    const newsPagination = document.querySelector('[data-news-pagination]');
    const newsPaginationInfo = document.querySelector('[data-news-pagination-info]');
    const newsUpdated = document.querySelector('[data-news-updated]');
    const newsRefreshButton = document.querySelector('[data-news-refresh]');

    mobileToggle?.addEventListener('click', () => {
        mobileMenu?.classList.toggle('is-open');
    });

    serviceToggle?.addEventListener('click', (event) => {
        event.stopPropagation();
        serviceMenu?.classList.toggle('hidden');
    });

    profileToggle?.addEventListener('click', (event) => {
        event.stopPropagation();
        profileMenu?.classList.toggle('is-open');
    });

    document.addEventListener('click', (event) => {
        if (serviceWrapper && !serviceWrapper.contains(event.target)) {
            serviceMenu?.classList.add('hidden');
        }
        if (profileWrapper && !profileWrapper.contains(event.target)) {
            profileMenu?.classList.remove('is-open');
        }
    });

    navLinks.forEach((link) => {
        link.addEventListener('click', () => {
            mobileMenu?.classList.remove('is-open');
        });
    });

    const toggleHeaderScrolledState = () => {
        if (!siteHeader) {
            return;
        }
        const scrolled = window.scrollY > 24;
        siteHeader.classList.toggle('is-scrolled', scrolled);
    };

    window.addEventListener('scroll', toggleHeaderScrolledState, { passive: true });
    toggleHeaderScrolledState();

    const activateNav = (id) => {
        navLinks.forEach((link) => {
            const target = link.getAttribute('href')?.replace('#', '');
            link.classList.toggle('is-active', target === id);
        });
    };

    if ('IntersectionObserver' in window && navLinks.length > 0 && sections.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            const visible = entries.filter((entry) => entry.isIntersecting).sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];
            if (visible?.target?.id) {
                activateNav(visible.target.id);
            }
        }, {
            rootMargin: '-35% 0px -52% 0px',
            threshold: [0.12, 0.2, 0.3],
        });

        sections.forEach((section) => observer.observe(section));
    }

    const weatherTemp = document.querySelector('[data-weather-temp]');
    const weatherCondition = document.querySelector('[data-weather-condition]');
    const weatherHumidity = document.querySelector('[data-weather-humidity]');
    const weatherWind = document.querySelector('[data-weather-wind]');
    const weatherUpdated = document.querySelector('[data-weather-updated]');
    const weatherIcon = document.querySelector('[data-weather-icon]');
    const forecastTable = document.querySelector('[data-forecast-table]');
    const forecastHeaders = Array.from(document.querySelectorAll('[data-forecast-day]'));
    const forecastRows = Array.from(document.querySelectorAll('[data-forecast-row]'));

    const weatherDescriptions = {
        0: 'Cerah',
        1: 'Cerah berawan',
        2: 'Berawan sebagian',
        3: 'Berawan',
        45: 'Berkabut',
        48: 'Kabut beku',
        51: 'Gerimis ringan',
        53: 'Gerimis sedang',
        55: 'Gerimis lebat',
        61: 'Hujan ringan',
        63: 'Hujan sedang',
        65: 'Hujan lebat',
        71: 'Salju ringan',
        80: 'Hujan lokal',
        95: 'Badai petir',
    };

    const weatherIcons = {
        sun: `
            <svg class="h-12 w-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3v2" />
                <path d="M12 19v2" />
                <path d="M5.5 5.5l1.4 1.4" />
                <path d="M17.1 17.1l1.4 1.4" />
                <path d="M3 12h2" />
                <path d="M19 12h2" />
                <path d="M5.5 18.5l1.4-1.4" />
                <path d="M17.1 6.9l1.4-1.4" />
                <circle cx="12" cy="12" r="4" />
            </svg>
        `,
        cloud: `
            <svg class="h-12 w-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 18h11a4 4 0 0 0 0-8 5.5 5.5 0 0 0-10.6-1.7A3.5 3.5 0 0 0 6 18Z" />
            </svg>
        `,
        rain: `
            <svg class="h-12 w-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 14h11a4 4 0 0 0 0-8 5.5 5.5 0 0 0-10.6-1.7A3.5 3.5 0 0 0 6 14Z" />
                <path d="M8 18v2" />
                <path d="M12 17v2" />
                <path d="M16 18v2" />
            </svg>
        `,
        storm: `
            <svg class="h-12 w-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 14h11a4 4 0 0 0 0-8 5.5 5.5 0 0 0-10.6-1.7A3.5 3.5 0 0 0 6 14Z" />
                <path d="M12 14l-2 4h3l-1 4" />
            </svg>
        `,
        mist: `
            <svg class="h-12 w-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                <path d="M4 8h16" />
                <path d="M6 12h12" />
                <path d="M5 16h14" />
            </svg>
        `,
    };

    const pickWeatherIcon = (code) => {
        if (code === 0) return weatherIcons.sun;
        if ([1, 2, 3].includes(code)) return weatherIcons.cloud;
        if ([45, 48].includes(code)) return weatherIcons.mist;
        if ([51, 53, 55, 61, 63, 65, 80].includes(code)) return weatherIcons.rain;
        if ([71, 73, 75, 77].includes(code)) return weatherIcons.cloud;
        if ([95, 96, 99].includes(code)) return weatherIcons.storm;
        return weatherIcons.cloud;
    };

    const pickWeatherIconSmall = (code) => {
        if (code === 0) {
            return '<svg class="h-8 w-8 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v2" /><path d="M12 19v2" /><path d="M5.5 5.5l1.4 1.4" /><path d="M17.1 17.1l1.4 1.4" /><path d="M3 12h2" /><path d="M19 12h2" /><path d="M5.5 18.5l1.4-1.4" /><path d="M17.1 6.9l1.4-1.4" /><circle cx="12" cy="12" r="4" /></svg>';
        }

        if ([1, 2, 3].includes(code)) {
            return '<svg class="h-8 w-8 text-sky-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18h11a4 4 0 0 0 0-8 5.5 5.5 0 0 0-10.6-1.7A3.5 3.5 0 0 0 6 18Z" /></svg>';
        }

        if ([45, 48].includes(code)) {
            return '<svg class="h-8 w-8 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M4 8h16" /><path d="M6 12h12" /><path d="M5 16h14" /></svg>';
        }

        if ([95, 96, 99].includes(code)) {
            return '<svg class="h-8 w-8 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 14h11a4 4 0 0 0 0-8 5.5 5.5 0 0 0-10.6-1.7A3.5 3.5 0 0 0 6 14Z" /><path d="M12 14l-2 4h3l-1 4" /></svg>';
        }

        if ([51, 53, 55, 56, 57, 61, 63, 65, 66, 67, 80, 81, 82].includes(code)) {
            return '<svg class="h-8 w-8 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 14h11a4 4 0 0 0 0-8 5.5 5.5 0 0 0-10.6-1.7A3.5 3.5 0 0 0 6 14Z" /><path d="M8 18v2" /><path d="M12 17v2" /><path d="M16 18v2" /></svg>';
        }

        return '<svg class="h-8 w-8 text-sky-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18h11a4 4 0 0 0 0-8 5.5 5.5 0 0 0-10.6-1.7A3.5 3.5 0 0 0 6 18Z" /></svg>';
    };

    const updateWeatherFallback = () => {
        if (weatherTemp) weatherTemp.textContent = '24°C';
        if (weatherCondition) weatherCondition.textContent = 'Berawan';
        if (weatherHumidity) weatherHumidity.textContent = '78%';
        if (weatherWind) weatherWind.textContent = '12 km/jam';
        if (weatherUpdated) weatherUpdated.textContent = 'Data lokal';
        if (weatherIcon) weatherIcon.innerHTML = weatherIcons.cloud;
    };

    const loadWeather = async () => {
        if (!weatherTemp) {
            return;
        }

        // Try local admin-managed snapshot first, else fallback to Open-Meteo
        const localEndpoint = 'cuaca-api.php';
        const endpoint = localEndpoint;

        try {
            let response = await fetch(endpoint, { cache: 'no-store' });
            let data;
            if (!response.ok) {
                // fallback to external
                response = await fetch('https://api.open-meteo.com/v1/forecast?latitude=-6.5971&longitude=106.8060&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m&timezone=auto', { cache: 'no-store' });
            }
            if (!response.ok) throw new Error('Weather request failed');
            data = await response.json();
            const current = data.current || {};
            const temp = Math.round(Number(current.temperature_2m ?? 24));
            const humidity = Math.round(Number(current.relative_humidity_2m ?? 78));
            const wind = Math.round(Number(current.wind_speed_10m ?? 12));
            const code = Number(current.weather_code ?? 3);
            const condition = weatherDescriptions[code] || 'Berawan';
            const timeStamp = current.time ? new Date(current.time).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) : 'Baru saja';

            if (weatherTemp) weatherTemp.textContent = `${temp}°C`;
            if (weatherCondition) weatherCondition.textContent = condition;
            if (weatherHumidity) weatherHumidity.textContent = `${humidity}%`;
            if (weatherWind) weatherWind.textContent = `${wind} km/jam`;
            if (weatherUpdated) weatherUpdated.textContent = `${timeStamp} WIB`;
            if (weatherIcon) weatherIcon.innerHTML = pickWeatherIcon(code);
        } catch (error) {
            updateWeatherFallback();
        }
    };

    loadWeather();

    const initBmkgStyleForecast = async () => {
        if (!forecastTable || forecastRows.length === 0 || forecastHeaders.length === 0) {
            return;
        }

        const dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

        const formatDayHeader = (dateText) => {
            const date = new Date(dateText);
            if (Number.isNaN(date.getTime())) {
                return 'Hari';
            }
            const day = dayNames[date.getDay()] || 'Hari';
            const dayNum = date.getDate();
            const month = date.toLocaleString('id-ID', { month: 'short' });
            return `${day}, ${dayNum} ${month}`;
        };

        const clamp = (value, min, max) => Math.max(min, Math.min(max, value));

        try {
            // Try local snapshot first
            let response = await fetch('cuaca-api.php', { cache: 'no-store' });
            let payload;
            if (!response.ok) {
                response = await fetch('https://api.open-meteo.com/v1/forecast?latitude=-6.5971&longitude=106.8060&daily=weather_code,temperature_2m_max,temperature_2m_min,relative_humidity_2m_max,relative_humidity_2m_min&timezone=Asia%2FBangkok&forecast_days=6', { cache: 'no-store' });
            }
            if (!response.ok) throw new Error('Forecast request failed');
            payload = await response.json();
            const daily = payload.daily || {};

            const dates = daily.time || [];
            const codes = daily.weather_code || [];
            const maxTemps = daily.temperature_2m_max || [];
            const minTemps = daily.temperature_2m_min || [];
            const maxHumidity = daily.relative_humidity_2m_max || [];
            const minHumidity = daily.relative_humidity_2m_min || [];

            forecastHeaders.forEach((header, index) => {
                const dateText = dates[index] || '';
                header.textContent = dateText ? formatDayHeader(dateText) : `Hari ${index + 1}`;
            });

            forecastRows.forEach((row) => {
                const minOffset = Number(row.getAttribute('data-min-offset') || 0);
                const maxOffset = Number(row.getAttribute('data-max-offset') || 0);
                const humOffset = Number(row.getAttribute('data-hum-offset') || 0);
                const cells = Array.from(row.querySelectorAll('[data-forecast-cell]'));

                cells.forEach((cell, index) => {
                    const code = Number(codes[index] ?? 3);
                    const weatherLabel = weatherDescriptions[code] || 'Berawan';

                    const baseMin = Math.round(Number(minTemps[index] ?? 22));
                    const baseMax = Math.round(Number(maxTemps[index] ?? 28));
                    const tempMin = baseMin + minOffset;
                    const tempMax = Math.max(tempMin + 1, baseMax + maxOffset);

                    const humMinRaw = Math.round(Number(minHumidity[index] ?? 70)) + humOffset;
                    const humMaxRaw = Math.round(Number(maxHumidity[index] ?? 95)) + humOffset;
                    const humMin = clamp(Math.min(humMinRaw, humMaxRaw - 1), 35, 99);
                    const humMax = clamp(Math.max(humMaxRaw, humMin + 1), 36, 100);

                    cell.innerHTML = `
                        <div class="mb-2">${pickWeatherIconSmall(code)}</div>
                        <p class="text-sm font-medium text-slate-700">${weatherLabel}</p>
                        <p class="mt-2 text-[1.65rem] font-bold leading-none tracking-tight text-slate-900">${tempMin}-${tempMax}°C</p>
                        <p class="mt-2 text-sm text-slate-500">${humMin}-${humMax}%</p>
                    `;
                });
            });
        } catch (error) {
            const fallbackDays = ['Min, 24 Mei', 'Sen, 25 Mei', 'Sel, 26 Mei', 'Rab, 27 Mei', 'Kam, 28 Mei', 'Jum, 29 Mei'];
            forecastHeaders.forEach((header, index) => {
                header.textContent = fallbackDays[index] || `Hari ${index + 1}`;
            });

            forecastRows.forEach((row, rowIndex) => {
                const cells = Array.from(row.querySelectorAll('[data-forecast-cell]'));
                cells.forEach((cell, dayIndex) => {
                    const mockCodes = [3, 63, 0, 2, 2, 0];
                    const code = mockCodes[dayIndex] ?? 3;
                    const weatherLabel = weatherDescriptions[code] || 'Berawan';
                    const min = 20 + rowIndex + (dayIndex % 2);
                    const max = min + 6 + (dayIndex % 3);
                    const humMin = 60 - rowIndex + dayIndex;
                    const humMax = 92 + (dayIndex % 5);

                    cell.innerHTML = `
                        <div class="mb-2">${pickWeatherIconSmall(code)}</div>
                        <p class="text-sm font-medium text-slate-700">${weatherLabel}</p>
                        <p class="mt-2 text-[1.65rem] font-bold leading-none tracking-tight text-slate-900">${min}-${max}°C</p>
                        <p class="mt-2 text-sm text-slate-500">${humMin}-${humMax}%</p>
                    `;
                });
            });
        }
    };

    initBmkgStyleForecast();

    const initCctvStreams = () => {
        if (hlsVideos.length === 0) {
            return;
        }

        hlsVideos.forEach((video) => {
            const src = video.getAttribute('data-stream-src');
            if (!src) {
                return;
            }

            if (video.canPlayType('application/vnd.apple.mpegurl')) {
                video.src = src;
                return;
            }

            if (window.Hls && window.Hls.isSupported()) {
                const hls = new window.Hls({
                    enableWorker: true,
                    lowLatencyMode: true,
                });
                hls.loadSource(src);
                hls.attachMedia(video);
            }
        });
    };

    initCctvStreams();

    const initHeroCarousel = () => {
        if (!heroCarousel || heroSlides.length === 0) {
            return;
        }

        let activeIndex = 0;
        let timerId = null;
        const cycleMs = 4000;

        const render = (index) => {
            activeIndex = (index + heroSlides.length) % heroSlides.length;

            heroSlides.forEach((slide, idx) => {
                slide.classList.toggle('is-active', idx === activeIndex);
            });

            heroDots.forEach((dot, idx) => {
                dot.classList.toggle('is-active', idx === activeIndex);
            });
        };

        const next = () => render(activeIndex + 1);
        const prev = () => render(activeIndex - 1);

        const start = () => {
            if (timerId) {
                return;
            }
            timerId = window.setInterval(next, cycleMs);
        };

        const stop = () => {
            if (!timerId) {
                return;
            }
            window.clearInterval(timerId);
            timerId = null;
        };

        heroNext?.addEventListener('click', () => {
            next();
            stop();
            start();
        });

        heroPrev?.addEventListener('click', () => {
            prev();
            stop();
            start();
        });

        heroDots.forEach((dot, idx) => {
            dot.addEventListener('click', () => {
                render(idx);
                stop();
                start();
            });
        });

        heroCarousel.addEventListener('mouseenter', stop);
        heroCarousel.addEventListener('mouseleave', start);

        render(0);
        start();
    };

    initHeroCarousel();

    const initRealtimeNews = () => {
        if (!newsGrid) {
            return;
        }

        const requestedLimit = Number(newsGrid.getAttribute('data-news-limit') || '9');
        const perPage = Number.isFinite(requestedLimit)
            ? Math.max(1, Math.min(24, Math.floor(requestedLimit)))
            : 9;

        const hasSearch = Boolean(newsSearchInput);
        const hasPagination = Boolean(newsPagination && newsPaginationInfo);

        const state = {
            page: 1,
            perPage,
            query: '',
            totalPages: 1,
            totalItems: 0,
            loading: false,
            refreshTimer: null,
        };

        const escapeHtml = (value) => String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');

        const formatDateLabel = (rawDate, rawIso) => {
            if (rawDate && rawDate !== 'Update terbaru') {
                return rawDate;
            }

            if (!rawIso) {
                return 'Update terbaru';
            }

            const parsed = new Date(rawIso);
            if (Number.isNaN(parsed.getTime())) {
                return 'Update terbaru';
            }

            return parsed.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric',
            });
        };

        const cardTemplate = (item, index) => {
            const image = item.image && item.image.trim() !== ''
                ? item.image
                : `https://picsum.photos/seed/realtime-bogor-${index}/900/560`;

            const title = escapeHtml(item.title || 'Berita terbaru');
            const source = escapeHtml(item.source || 'Sumber resmi');
            const excerpt = escapeHtml(item.excerpt || 'Ringkasan berita tidak tersedia.');
            const published = escapeHtml(formatDateLabel(item.published, item.published_iso));
            const url = escapeHtml(item.url || '#');

            return `
                <article class="news-card overflow-hidden rounded-[1.1rem] border border-slate-200 bg-white shadow-soft transition hover:-translate-y-0.5 hover:border-brand-200" data-news-card>
                    <img src="${image}" alt="${title}" class="h-48 w-full object-cover" loading="lazy" referrerpolicy="no-referrer" />
                    <div class="p-5">
                        <div class="flex items-center justify-between gap-3">
                            <span class="rounded-full bg-brand-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.22em] text-brand-700">${source}</span>
                            <span class="text-xs font-medium text-slate-400">${published}</span>
                        </div>
                        <h3 class="mt-4 line-clamp-2 text-lg font-bold tracking-tight text-slate-950">${title}</h3>
                        <p class="mt-3 line-clamp-3 text-sm leading-7 text-slate-600">${excerpt}</p>
                        <a href="${url}" target="_blank" rel="noopener noreferrer" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-brand-700 transition hover:gap-3">
                            Baca selengkapnya
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </article>
            `;
        };

        const renderPagination = () => {
            if (!newsPagination) {
                return;
            }

            newsPagination.innerHTML = '';

            const makeButton = (label, page, options = {}) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.textContent = label;
                button.className = `inline-flex h-10 min-w-10 items-center justify-center rounded-full border px-3 text-sm font-semibold transition ${options.active ? 'border-brand-600 bg-brand-700 text-white' : 'border-slate-200 bg-white text-slate-700 hover:border-brand-200 hover:text-brand-700'}`;
                button.disabled = Boolean(options.disabled);
                if (button.disabled) {
                    button.classList.add('cursor-not-allowed', 'opacity-45');
                }

                button.addEventListener('click', () => {
                    if (!button.disabled && page !== state.page) {
                        loadNews({ page });
                    }
                });

                newsPagination.appendChild(button);
            };

            makeButton('Prev', Math.max(1, state.page - 1), { disabled: state.page <= 1 });

            const total = state.totalPages;
            const pages = new Set([1, total, state.page - 1, state.page, state.page + 1]);
            const sortedPages = Array.from(pages).filter((page) => page >= 1 && page <= total).sort((a, b) => a - b);

            sortedPages.forEach((page, idx) => {
                const prevPage = sortedPages[idx - 1];
                if (idx > 0 && prevPage && page - prevPage > 1) {
                    const dots = document.createElement('span');
                    dots.className = 'px-1 text-sm text-slate-400';
                    dots.textContent = '...';
                    newsPagination.appendChild(dots);
                }
                makeButton(String(page), page, { active: page === state.page });
            });

            makeButton('Next', Math.min(state.totalPages, state.page + 1), { disabled: state.page >= state.totalPages });
        };

        const setUpdatedLabel = (isoDate) => {
            if (!newsUpdated) {
                return;
            }
            const date = isoDate ? new Date(isoDate) : new Date();
            if (Number.isNaN(date.getTime())) {
                newsUpdated.textContent = 'baru saja';
                return;
            }

            newsUpdated.textContent = date.toLocaleString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
            });
        };

        const renderNews = (items) => {
            if (!Array.isArray(items) || items.length === 0) {
                newsGrid.innerHTML = '';
                if (newsEmpty) {
                    newsEmpty.classList.remove('hidden');
                }
                return;
            }

            if (newsEmpty) {
                newsEmpty.classList.add('hidden');
            }

            newsGrid.innerHTML = items.map((item, index) => cardTemplate(item, index)).join('');
        };

        const loadNews = async ({ page = state.page, force = false } = {}) => {
            if (state.loading) {
                return;
            }

            state.loading = true;
            state.page = page;
            if (newsPaginationInfo) {
                newsPaginationInfo.textContent = 'Memuat berita realtime...';
            }

            try {
                const params = new URLSearchParams({
                    page: String(page),
                    per_page: String(state.perPage),
                    q: state.query,
                });

                if (force) {
                    params.set('force', '1');
                }

                const response = await fetch(`berita-api.php?${params.toString()}`, { cache: 'no-store' });
                if (!response.ok) {
                    throw new Error('Gagal memuat berita');
                }

                const payload = await response.json();
                const meta = payload.meta || {};
                const items = Array.isArray(payload.items) ? payload.items : [];

                state.totalPages = Number(meta.total_pages || 1);
                state.totalItems = Number(meta.total_items || 0);
                state.page = Number(meta.page || page);

                renderNews(items);
                renderPagination();
                setUpdatedLabel(meta.updated_at || '');

                if (newsPaginationInfo) {
                    newsPaginationInfo.textContent = state.totalItems > 0
                        ? `Menampilkan ${items.length} dari ${state.totalItems} berita (halaman ${state.page}/${state.totalPages})`
                        : 'Tidak ada berita yang cocok dengan pencarian.';
                }
            } catch (error) {
                newsGrid.innerHTML = '';
                if (newsEmpty) {
                    newsEmpty.classList.remove('hidden');
                    newsEmpty.textContent = 'Gagal memuat berita realtime. Coba beberapa saat lagi.';
                }
                if (newsPagination) {
                    newsPagination.innerHTML = '';
                }
                if (newsPaginationInfo) {
                    newsPaginationInfo.textContent = 'Terjadi kendala saat mengambil data berita.';
                }
            } finally {
                state.loading = false;
            }
        };

        if (hasSearch) {
            let searchDebounce = null;
            newsSearchInput.addEventListener('input', () => {
                window.clearTimeout(searchDebounce);
                searchDebounce = window.setTimeout(() => {
                    state.query = newsSearchInput.value.trim();
                    loadNews({ page: 1 });
                }, 350);
            });

            newsRefreshButton?.addEventListener('click', () => {
                loadNews({ page: 1, force: true });
            });
        }

        if (!hasPagination && newsEmpty) {
            newsEmpty.textContent = 'Berita tidak tersedia saat ini.';
        }

        state.refreshTimer = window.setInterval(() => {
            loadNews({ page: hasPagination ? state.page : 1 });
        }, 120000);

        loadNews({ page: 1 });
    };

    initRealtimeNews();

    const initRevealAnimations = () => {
        const targets = Array.from(document.querySelectorAll('main section, [data-news-card], .shadow-soft'));
        if (targets.length === 0) {
            return;
        }

        targets.forEach((el) => el.classList.add('reveal-init'));

        if (!('IntersectionObserver' in window)) {
            targets.forEach((el) => el.classList.add('is-visible'));
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -8% 0px',
        });

        targets.forEach((el) => observer.observe(el));
    };

    initRevealAnimations();
});