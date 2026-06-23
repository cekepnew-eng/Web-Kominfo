<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/services.php';

$pageTitle = 'Wowoembege AI — Diskominfo Kota Bogor';
$basePath  = '/kominfov2';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($pageTitle) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= $basePath ?>/assets/css/app.css">
</head>
<body>

<div class="ai-page">

  <!-- ─── Sidebar ─── -->
  <aside class="ai-sidebar">
    <div class="ai-sidebar-header">
      <div class="ai-logo" style="width: 100%; display: flex; justify-content: center;">
        <img src="<?= $basePath ?>/includes/image/chatbot3.jpeg" alt="Logo KINARA AI" style="border-radius: 8px; width: 100%; max-width: 160px; height: auto; object-fit: contain;">
      </div>
    </div>

    <button class="ai-new-chat" id="newChatBtn">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Percakapan Baru
    </button>

    <div class="ai-history-label">Percakapan Terakhir</div>
    <div class="ai-history-item">Cara lapor jalan rusak</div>
    <div class="ai-history-item">Jadwal layanan PPID</div>
    <div class="ai-history-item">Info Smart City Bogor</div>

    <div style="margin-top:auto; padding:1rem; border-top:1px solid var(--border);">
      <a href="index.php" style="display:flex; align-items:center; gap:.5rem; font-size:.8125rem; color:var(--slate-500); transition:color var(--transition);"
         onmouseover="this.style.color='var(--blue)'" onmouseout="this.style.color='var(--slate-500)'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Beranda
      </a>
    </div>
  </aside>

  <!-- ─── Main ─── -->
  <div class="ai-main" data-aos="fade-up">

    <!-- Top bar -->
    <div class="ai-topbar">
      <div class="ai-model-tag">
        <span class="ai-model-dot"></span>
        Wowoembege — Asisten AI Diskominfo
      </div>
      <a href="index.php" class="ai-back-link d-md-none">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Beranda
      </a>
    </div>

    <!-- Messages -->
    <div class="ai-messages" id="aiMessages">

      <!-- Welcome State -->
      <div id="welcomeState" style="max-width:600px; margin:4rem auto; text-align:center; padding:0 1rem;">
        <img src="<?= $basePath ?>/includes/image/chatbot2.jpeg" alt="Wowoembege Icon" style="width:100px; height:auto; margin:0 auto 1.5rem; display:block; mix-blend-mode: multiply;">
        <h1 style="font-size:1.75rem; font-weight:700; color:var(--slate-900); margin-bottom:.75rem;">Halo, saya Wowoembege</h1>
        <p style="color:var(--slate-500); font-size:1rem; line-height:1.65; margin-bottom:2rem;">
          Asisten AI resmi Diskominfo Kota Bogor. Saya siap membantu Anda menemukan informasi layanan publik, membuat laporan pengaduan, atau menjawab pertanyaan seputar Kota Bogor.
        </p>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:.75rem; text-align:left;">
          <?php
          $suggestions = [
            ['Bagaimana cara melaporkan jalan rusak?', 'Pengaduan'],
            ['Apa itu PPID Kota Bogor?', 'Informasi'],
            ['Jam operasional Diskominfo', 'Layanan'],
            ['Cara akses CCTV live Kota Bogor', 'CCTV'],
          ];
          foreach ($suggestions as $s): ?>
          <button class="suggestion-chip" onclick="sendSuggestion(this.dataset.msg)" data-msg="<?= esc($s[0]) ?>"
            style="background:var(--white); border:1px solid var(--border); border-radius:10px; padding:.875rem 1rem; cursor:pointer; text-align:left; font-family:inherit; transition:border-color .2s,box-shadow .2s;"
            onmouseover="this.style.borderColor='var(--blue)';this.style.boxShadow='0 0 0 3px rgba(37,99,235,.1)'"
            onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
            <div style="font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; color:var(--blue); margin-bottom:.3rem;"><?= esc($s[1]) ?></div>
            <div style="font-size:.875rem; color:var(--slate-700); line-height:1.4;"><?= esc($s[0]) ?></div>
          </button>
          <?php endforeach; ?>
        </div>
      </div>

    </div>

    <!-- Input Bar -->
    <div class="ai-input-bar">
      <div class="ai-input-inner">
        <textarea class="ai-textarea" id="aiInput" placeholder="Tanyakan sesuatu kepada Wowoembege..." rows="1"></textarea>
        <button class="ai-send-btn" id="aiSend" aria-label="Kirim">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
        </button>
      </div>
      <p class="ai-footer-note">Wowoembege dapat membuat kesalahan. Harap verifikasi informasi penting ke pihak terkait secara langsung.</p>
    </div>

  </div>
</div>

<script>
const msgsEl    = document.getElementById('aiMessages');
const welcomeEl = document.getElementById('welcomeState');
const inputEl   = document.getElementById('aiInput');
const sendBtn   = document.getElementById('aiSend');
const basePath  = '<?= $basePath ?>';

// Auto-resize textarea
inputEl.addEventListener('input', () => {
  inputEl.style.height = 'auto';
  inputEl.style.height = Math.min(inputEl.scrollHeight, 200) + 'px';
});

function escHTML(s) {
  return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function appendMessage(content, isUser) {
  if (welcomeEl) welcomeEl.remove();

  const row = document.createElement('div');
  row.className = 'ai-message-row';

  const avatarHTML = isUser
    ? `<div class="ai-avatar user"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>`
    : `<div class="ai-avatar bot" style="background:transparent; border:none; padding:0; overflow:hidden;"><img src="${basePath}/includes/image/chatbot2.jpeg" alt="Bot" style="width:100%; height:100%; object-fit:cover; mix-blend-mode: multiply;"></div>`;

  row.innerHTML = `
    ${avatarHTML}
    <div class="ai-message-content">${content}</div>
  `;
  msgsEl.appendChild(row);
  msgsEl.scrollTo({ top: msgsEl.scrollHeight, behavior: 'smooth' });
  return row;
}

function showTyping() {
  return appendMessage('<div class="typing-dots"><span></span><span></span><span></span></div>', false);
}

async function sendMessage(text) {
  if (!text.trim()) return;
  sendBtn.disabled = true;

  appendMessage(`<p>${escHTML(text).replace(/\n/g,'<br>')}</p>`, true);
  inputEl.value = '';
  inputEl.style.height = 'auto';

  const typingRow = showTyping();

  try {
    const fd = new FormData();
    fd.append('message', text);
    const res = await fetch(basePath + '/api/chat.php', { method: 'POST', body: fd });
    const data = await res.json();

    typingRow.remove();

    let html = `<p>${escHTML(data.reply || 'Maaf, terjadi kesalahan.').replace(/\n/g,'<br>')}</p>`;
    if (data.category && data.category !== 'UNKNOWN') {
      html += `
        <div style="margin-top:1rem; padding:1rem; background:var(--blue-light); border:1px solid #bfdbfe; border-radius:10px;">
          <p style="margin:0 0 .6rem; font-size:.875rem; color:var(--slate-700);">
            Sistem mendeteksi kategori: <strong style="color:var(--blue);">${escHTML(data.category)}</strong>
          </p>
          <a href="${basePath}/user/laporan.php?cat=${encodeURIComponent(data.category)}&desc=${encodeURIComponent(text)}"
             style="display:inline-flex; align-items:center; gap:.4rem; padding:.625rem 1.25rem; background:var(--blue); color:white; border-radius:8px; font-size:.875rem; font-weight:600; text-decoration:none;">
            Buat Laporan
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>`;
    }
    appendMessage(html, false);

  } catch (e) {
    typingRow.remove();
    appendMessage(`<p style="color:#ef4444;">Koneksi gagal. Pastikan server berjalan dan coba lagi.</p>`, false);
  }

  sendBtn.disabled = false;
}

function sendSuggestion(msg) { sendMessage(msg); }

sendBtn.addEventListener('click', () => sendMessage(inputEl.value));
inputEl.addEventListener('keydown', e => {
  if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(inputEl.value); }
});

document.getElementById('newChatBtn').addEventListener('click', () => {
  msgsEl.innerHTML = '';
  // Rebuild welcome
  msgsEl.innerHTML = `
    <div style="max-width:600px; margin:4rem auto; text-align:center; padding:0 1rem;">
      <img src="${basePath}/includes/image/chatbot2.jpeg" alt="Wowoembege Icon" style="width:100px; height:auto; margin:0 auto 1.5rem; display:block; mix-blend-mode: multiply;">
      <h1 style="font-size:1.75rem;font-weight:700;color:var(--slate-900);margin-bottom:.75rem;">Halo, saya Wowoembege</h1>
      <p style="color:var(--slate-500);font-size:1rem;line-height:1.65;">Percakapan baru telah dimulai. Ada yang bisa saya bantu?</p>
    </div>`;
});
</script>
</body>
</html>
