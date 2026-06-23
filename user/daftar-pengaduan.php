<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/services.php';

$pageTitle = 'Daftar Pengaduan Masyarakat - SiBadra';
$activePage = 'daftar-pengaduan';

require __DIR__ . '/../includes/header.php';
?>

<!-- Include Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    body {
        background-color: #f8f9fa;
    }
    .page-container {
        padding-top: calc(var(--nav-h) + 2rem);
        padding-bottom: 4rem;
    }
    #map {
        width: 100%;
        height: 300px;
        border-radius: var(--bs-border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--shadow-sm);
        z-index: 1;
    }
    
    /* Report Card Design (Image Left, Text Right) */
    .report-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        background: #fff;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .report-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: var(--blue-light);
    }
    .report-card .row {
        margin: 0;
    }
    .report-img-container {
        padding: 0;
        height: 250px;
    }
    @media (min-width: 768px) {
        .report-img-container {
            height: 100%;
            min-height: 220px;
        }
    }
    .report-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .report-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .report-title {
        font-weight: 800;
        font-size: 1.1rem;
        color: var(--slate-900);
        margin-bottom: 0.5rem;
        text-transform: uppercase;
    }
    .report-meta {
        font-size: 0.85rem;
        color: var(--slate-700);
        margin-bottom: 1rem;
    }
    .report-desc {
        color: var(--slate-700);
        font-size: 0.95rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    /* Action Icons (Like & Comment) */
    .action-icons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid var(--border);
        padding-top: 1rem;
    }
    .action-btn {
        background: none;
        border: none;
        font-size: 1.3rem;
        color: var(--slate-700);
        display: flex;
        align-items: center;
        gap: 0.4rem;
        cursor: pointer;
        transition: color 0.2s, transform 0.2s;
        padding: 0;
    }
    .action-btn span {
        font-size: 0.95rem;
        font-weight: 600;
    }
    .action-btn:hover {
        color: var(--blue);
        transform: scale(1.05);
    }
    .action-btn.liked {
        color: #e11d48; /* Merah untuk like */
    }
    .action-btn.liked i::before {
        content: "\F415"; /* bi-heart-fill */
    }

    /* Offcanvas Comment Style (TikTok/IG Drawer) */
    .offcanvas-end {
        width: 100%;
        max-width: 400px;
        border-left: none;
        box-shadow: var(--shadow-lg);
    }
    @media (max-width: 576px) {
        .offcanvas {
            height: 85vh !important;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }
        .offcanvas.offcanvas-end {
            /* Make it slide from bottom on mobile */
            top: auto;
            bottom: 0;
            right: 0;
            left: 0;
            transform: translateY(100%);
        }
        .offcanvas.offcanvas-end.show {
            transform: translateY(0);
        }
    }
    .comment-bubble {
        background: var(--slate-100);
        border-radius: 18px;
        padding: 0.75rem 1rem;
        display: inline-block;
        max-width: 90%;
    }
</style>

<div class="container page-container" data-aos="fade-in">
    <div class="row">
        <!-- Main Feed -->
        <div class="col-lg-8 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0 text-dark">Daftar Pengaduan</h3>
                <button class="btn btn-outline-primary btn-sm rounded-pill" type="button" data-bs-toggle="collapse" data-bs-target="#mapCollapse" aria-expanded="false" aria-controls="mapCollapse">
                    <i class="bi bi-map-fill"></i> Tampilkan Peta
                </button>
            </div>

            <div class="collapse mb-4" id="mapCollapse">
                <div id="map"></div>
            </div>

            <div id="loadingSpinner" class="text-center my-4 text-muted small">
                Memuat data pengaduan...
            </div>

            <div id="cardsContainer"></div>
        </div>
    </div>
</div>

<!-- Offcanvas / Drawer untuk Komentar -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="commentsDrawer" aria-labelledby="commentsDrawerLabel">
  <div class="offcanvas-header border-bottom py-3">
    <h6 class="offcanvas-title fw-bold m-0" id="commentsDrawerLabel">
        Komentar <span class="badge bg-secondary rounded-pill ms-2" id="commentCountBadge">0</span>
    </h6>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  
  <div class="offcanvas-body d-flex flex-column p-0">
    <!-- List Komentar -->
    <div id="commentsList" class="flex-grow-1 p-3 overflow-auto" style="background: #fff;">
        <div class="text-center text-muted mt-5 small">Memuat komentar...</div>
    </div>
    
    <!-- Input Form Fixed di Bawah -->
    <div class="p-3 bg-white border-top mt-auto shadow-sm">
        <form id="commentForm">
            <input type="hidden" id="reportId" value="">
            <div class="mb-2">
                <input type="text" id="commentName" class="form-control form-control-sm rounded-pill px-3 bg-light border-0" placeholder="Nama Anda (Opsional)" required>
            </div>
            <div class="input-group">
                <input type="text" id="commentText" class="form-control form-control-sm rounded-start-pill ps-3 bg-light border-0" placeholder="Tambahkan komentar..." required>
                <button class="btn btn-sm btn-primary rounded-end-pill px-3" type="submit" id="btnSendComment">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </form>
    </div>
  </div>
</div>

<!-- Include Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<script>
let map;
let markers = [];
let offcanvasElement;
let bsOffcanvas;
let pollInterval;

document.addEventListener('DOMContentLoaded', async function() {
    offcanvasElement = document.getElementById('commentsDrawer');
    bsOffcanvas = new bootstrap.Offcanvas(offcanvasElement);

    // Inisialisasi Peta
    map = L.map('map').setView([-6.5971, 106.7932], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    // Fix peta ketika di-expand dari collapse
    const mapCollapse = document.getElementById('mapCollapse');
    mapCollapse.addEventListener('shown.bs.collapse', function () {
        map.invalidateSize();
    });

    const container = document.getElementById('cardsContainer');
    const spinner = document.getElementById('loadingSpinner');

    try {
        const response = await fetch('laporan-api.php');
        const data = await response.json();

        spinner.style.display = 'none';

        if(data.success && data.items.length > 0) {
            data.items.forEach((item, index) => {
                // Marker Peta
                if (item.latitude && item.longitude) {
                    const marker = L.marker([item.latitude, item.longitude]).addTo(map);
                    marker.bindPopup(`<b>${item.category_label}</b><br>${item.title}`);
                    
                    // Zoom ke marker saat diklik
                    marker.on('click', function(e) {
                        map.flyTo(e.latlng, 17, {
                            animate: true,
                            duration: 1.5
                        });
                    });
                    
                    markers.push({ id: item.id, marker: marker });
                }

                // Data Card
                const imgUrl = item.primary_image ? (item.primary_image.startsWith('http') ? item.primary_image : `../${item.primary_image}`) : 'https://picsum.photos/seed/'+item.id+'/600/400';
                let author = item.reporter_name ? item.reporter_name : 'Anonim';
                let dateStr = item.created_at.substring(0, 16).replace('T', ' '); // simple format
                let likes = item.likes_count || 0;
                
                // Cek localstorage apakah user sudah like
                let isLiked = localStorage.getItem('liked_' + item.id) === 'true';
                let likeClass = isLiked ? 'liked' : '';
                let likeIcon = isLiked ? 'bi-heart-fill' : 'bi-heart';

                const card = document.createElement('div');
                card.className = 'report-card';
                card.innerHTML = `
                    <div class="row g-0 h-100">
                        <div class="col-md-4 report-img-container">
                            <img src="${imgUrl}" class="report-img" alt="Foto Laporan" onerror="this.src='https://placehold.co/600x400?text=No+Image'">
                        </div>
                        <div class="col-md-8">
                            <div class="report-body h-100">
                                <div>
                                    <h5 class="report-title">${item.title}</h5>
                                    <div class="report-meta d-flex align-items-center flex-wrap gap-2">
                                        <span class="badge rounded-pill" style="background-color: var(--blue); color: #fff;">${item.category_label}</span>
                                        <span>-</span>
                                        <span class="fw-semibold">${author}</span>
                                        <span>-</span>
                                        <span>${dateStr}</span>
                                    </div>
                                    <div class="report-desc">
                                        ${item.description}
                                    </div>
                                </div>
                                
                                <div class="action-icons mt-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="d-flex align-items-center gap-1">
                                            <div class="rounded-circle" style="width:12px;height:12px;background-color:${item.status_color};"></div>
                                            <span class="small fw-semibold text-muted">${item.status_label}</span>
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center gap-4">
                                        <!-- Like Button -->
                                        <button class="action-btn btn-like ${likeClass}" data-id="${item.id}" title="Suka">
                                            <i class="bi ${likeIcon}"></i>
                                            <span class="like-count">${likes}</span>
                                        </button>
                                        <!-- Comment Button -->
                                        <button class="action-btn btn-comment" data-id="${item.id}" title="Komentar">
                                            <i class="bi bi-chat"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Event Listener Like
                const btnLike = card.querySelector('.btn-like');
                btnLike.addEventListener('click', async function() {
                    const rId = this.dataset.id;
                    if (localStorage.getItem('liked_' + rId) === 'true') return; // Cegah spam klik
                    
                    try {
                        const fd = new FormData();
                        fd.append('report_id', rId);
                        const res = await fetch('../api/like-api.php', { method: 'POST', body: fd });
                        const resData = await res.json();
                        
                        if (resData.success) {
                            this.classList.add('liked');
                            this.querySelector('i').classList.replace('bi-heart', 'bi-heart-fill');
                            this.querySelector('.like-count').textContent = resData.likes_count;
                            localStorage.setItem('liked_' + rId, 'true');
                        }
                    } catch(e) { console.error(e); }
                });

                // Event Listener Comment
                const btnComment = card.querySelector('.btn-comment');
                btnComment.addEventListener('click', function() {
                    openCommentsDrawer(item);
                });

                container.appendChild(card);
            });

            // Fit map bounds
            if (markers.length > 0) {
                const group = new L.featureGroup(markers.map(m => m.marker));
                map.fitBounds(group.getBounds().pad(0.1));
            }

        } else {
            container.innerHTML = '<div class="alert alert-info border-0 shadow-sm rounded-4 text-center p-5"><i class="bi bi-inbox fs-1 d-block mb-3 text-muted"></i>Belum ada pengaduan masyarakat yang terdaftar.</div>';
        }

    } catch (error) {
        spinner.style.display = 'none';
        container.innerHTML = '<div class="alert alert-danger">Gagal memuat data pengaduan.</div>';
    }
});


/* ─── KOMENTAR LOGIC (Drawer) ────────────────────────────────── */

function openCommentsDrawer(item) {
    document.getElementById('reportId').value = item.id;
    document.getElementById('commentsList').innerHTML = '<div class="text-center text-muted mt-5 small"><div class="spinner-border spinner-border-sm text-primary mb-2"></div><br>Memuat komentar...</div>';
    
    bsOffcanvas.show();
    
    fetchComments(item.id);
    clearInterval(pollInterval);
    pollInterval = setInterval(() => fetchComments(item.id), 3000);
}

// Stop polling when offcanvas is hidden
offcanvasElement.addEventListener('hidden.bs.offcanvas', function () {
    clearInterval(pollInterval);
});

async function fetchComments(reportId) {
    // Only fetch if offcanvas is actually open
    if (!offcanvasElement.classList.contains('show')) return;
    
    try {
        const res = await fetch(`../api/komentar-api.php?action=get&report_id=${reportId}`);
        const data = await res.json();
        if(data.success) {
            renderComments(data.comments);
        }
    } catch(e) { console.error('Fetch comments error', e); }
}

function renderComments(comments) {
    const list = document.getElementById('commentsList');
    document.getElementById('commentCountBadge').textContent = comments.length;
    
    if(comments.length === 0) {
        list.innerHTML = '<div class="text-center text-muted mt-5 pt-4"><i class="bi bi-chat-dots mb-3 fs-1 d-block text-light"></i><p class="small">Belum ada komentar.<br>Jadilah yang pertama mengulas!</p></div>';
        return;
    }
    
    const getAvatarColor = (name) => {
        let hash = 0;
        for (let i = 0; i < name.length; i++) hash = name.charCodeAt(i) + ((hash << 5) - hash);
        return `hsl(${hash % 360}, 65%, 45%)`;
    };

    // Build comment tree (simple)
    const map = {};
    const roots = [];
    comments.forEach(c => { c.children = []; map[c.id] = c; });
    comments.forEach(c => {
        if (c.parent_id && map[c.parent_id]) map[c.parent_id].children.push(c);
        else roots.push(c);
    });

    let html = '';

    const renderNode = (c, depth) => {
        const isAdmin = c.is_admin;
        const initial = c.commenter_name.charAt(0).toUpperCase();
        const avatarColor = isAdmin ? 'var(--blue)' : getAvatarColor(c.commenter_name);
        const dateObj = new Date(c.created_at);
        const timeStr = dateObj.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});
        const dateStr = dateObj.toLocaleDateString('id-ID', {day:'numeric', month:'short'});
        
        let containerMargin = depth > 0 ? 'ms-4 mt-2' : 'mt-3';
        let badge = isAdmin ? '<i class="bi bi-patch-check-fill text-primary ms-1"></i>' : '';
        let parentInfo = (depth > 0 && c.parent_name) ? `<span class="small text-muted me-1">Membalas ${c.parent_name}</span><br>` : '';

        html += `
        <div class="d-flex align-items-start ${containerMargin}">
            <div class="flex-shrink-0 me-2 mt-1">
                <div class="d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 32px; height: 32px; border-radius: 50%; background-color: ${avatarColor}; font-size: 0.85rem;">
                    ${initial}
                </div>
            </div>
            <div class="flex-grow-1">
                <div class="comment-bubble shadow-sm">
                    <div class="fw-bold" style="font-size: 0.85rem; color: var(--slate-900);">
                        ${c.commenter_name} ${badge}
                    </div>
                    <div class="text-dark" style="font-size: 0.9rem; line-height: 1.4; word-break: break-word;">
                        ${parentInfo}
                        ${c.comment_text.replace(/\n/g, '<br>')}
                    </div>
                </div>
                <div class="ps-2 pt-1 text-muted" style="font-size: 0.75rem;">
                    ${dateStr} ${timeStr}
                </div>
            </div>
        </div>`;
        
        c.children.forEach((child) => renderNode(child, depth + 1));
    };

    roots.forEach(r => renderNode(r, 0));
    
    const isScrolledToBottom = list.scrollHeight - list.clientHeight <= list.scrollTop + 60;
    list.innerHTML = html;
    if(isScrolledToBottom) list.scrollTop = list.scrollHeight;
}

document.getElementById('commentForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = document.getElementById('btnSendComment');
    const rId = document.getElementById('reportId').value;
    const nameInput = document.getElementById('commentName');
    const txtInput = document.getElementById('commentText');
    
    let name = nameInput.value.trim();
    if (!name) name = 'Anonim';
    
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    
    const fd = new FormData();
    fd.append('action', 'post');
    fd.append('report_id', rId);
    fd.append('name', name);
    fd.append('comment', txtInput.value);
    
    try {
        await fetch('../api/komentar-api.php', { method: 'POST', body: fd });
        txtInput.value = '';
        fetchComments(rId);
        
        // Simpan nama di localstorage agar user tidak perlu ngetik ulang
        localStorage.setItem('comment_author_name', name);
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-send-fill"></i>';
    }
});

// Load saved name
document.addEventListener('DOMContentLoaded', () => {
    const savedName = localStorage.getItem('comment_author_name');
    if(savedName && savedName !== 'Anonim') {
        document.getElementById('commentName').value = savedName;
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
