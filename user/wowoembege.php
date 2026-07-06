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
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= $basePath ?>/assets/css/app.css">
  
  <!-- Highlight.js CSS for Syntax Highlighting (Dark Theme) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/atom-one-dark.min.css">
  
  <style>
    /* ─── CHATGPT LIKE TYPOGRAPHY & UI ─── */
    .ai-page {
      font-family: 'Inter', sans-serif;
      background-color: #ffffff;
    }

    .ai-messages {
      padding: 0;
      display: flex;
      flex-direction: column;
      padding-bottom: 2rem;
    }

    .ai-message-row {
      width: 100%;
      padding: 12px 16px;
    }

    .ai-message-inner {
      max-width: 800px;
      margin: 0 auto;
      display: flex;
      gap: 16px;
    }

    /* Bubble Styles */
    .ai-message-content {
      font-size: 15px;
      line-height: 1.75;
      color: #202123;
      padding: 16px 20px;
      border-radius: 12px;
      display: inline-block;
      max-width: 90%;
      overflow-wrap: break-word;
    }

    .ai-message-user .ai-message-content {
      background-color: #f4f4f5;
    }
    
    .ai-message-user .ai-message-inner {
      flex-direction: row-reverse;
    }

    .ai-message-ai .ai-message-content {
      background-color: #ffffff;
      border: 1px solid #e5e7eb;
    }

    .ai-avatar {
      width: 32px;
      height: 32px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-size: 14px;
      flex-shrink: 0;
      border: none;
    }

    .ai-avatar.user {
      background-color: #3b82f6;
      color: white;
    }

    .ai-avatar.bot {
      background-color: #10a37f;
      color: white;
      overflow: hidden;
    }
    .ai-avatar.bot img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* Markdown Rendering Styles */
    .markdown-body p { margin-bottom: 16px; }
    .markdown-body p:last-child { margin-bottom: 0; }
    .markdown-body h1, .markdown-body h2, .markdown-body h3 {
      font-weight: 600; margin-top: 24px; margin-bottom: 16px; color: #202123;
    }
    .markdown-body h1 { font-size: 24px; }
    .markdown-body h2 { font-size: 20px; }
    .markdown-body h3 { font-size: 18px; }
    .markdown-body ul, .markdown-body ol { margin-top: 0; margin-bottom: 16px; padding-left: 24px; }
    .markdown-body li { margin-bottom: 8px; }
    .markdown-body pre {
      background-color: #282c34;
      color: #abb2bf;
      padding: 16px;
      border-radius: 8px;
      overflow-x: auto;
      margin-bottom: 16px;
      font-size: 14px;
      font-family: Consolas, Monaco, 'Courier New', monospace;
    }
    .markdown-body code {
      font-family: Consolas, Monaco, 'Courier New', monospace;
      background-color: rgba(0,0,0,0.05);
      padding: 2px 4px;
      border-radius: 4px;
      font-size: 0.9em;
      color: #e01e5a;
    }
    .markdown-body pre code { background-color: transparent; padding: 0; color: inherit; }
    .markdown-body table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
    .markdown-body th, .markdown-body td { border: 1px solid #d1d5db; padding: 8px 12px; text-align: left; }
    .markdown-body th { background-color: #f3f4f6; }
    .markdown-body blockquote {
      border-left: 4px solid #d1d5db; padding-left: 16px; color: #4b5563; margin-left: 0; margin-bottom: 16px;
    }
    .markdown-body a { color: #10a37f; text-decoration: underline; }

    /* Input Bar */
    .ai-input-bar {
      border-top: none;
      background: linear-gradient(180deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 20%);
      padding: 24px 16px;
      padding-top: 32px;
    }

    .ai-input-inner {
      max-width: 800px;
      margin: 0 auto;
      border: 1px solid rgba(0,0,0,0.1);
      box-shadow: 0 0 15px rgba(0,0,0,0.05);
      border-radius: 16px;
      padding: 12px 16px;
      background-color: #ffffff;
      align-items: center;
    }

    .ai-input-inner:focus-within {
      border-color: rgba(0,0,0,0.2);
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    .ai-textarea {
      font-size: 15px; line-height: 1.5; padding: 4px 0;
    }

    .ai-send-btn {
      background: #10a37f;
      border-radius: 8px;
    }
    .ai-send-btn:hover { background: #0d8a6a; }

    /* Welcome Screen */
    .welcome-screen { max-width: 800px; margin: 10vh auto; text-align: center; padding: 0 16px; }
    .welcome-screen h1 { font-weight: 600; color: #202123; font-size: 28px; margin-bottom: 24px; }
    .welcome-suggestions { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; text-align: left; }
    .suggestion-btn {
      background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 12px 16px;
      cursor: pointer; transition: background 0.2s; text-align: left;
    }
    .suggestion-btn:hover { background: #f9fafb; }
    .suggestion-title { font-weight: 600; margin-bottom: 4px; font-size: 14px; color: #10a37f; }
    .suggestion-desc { color: #4b5563; font-size: 13px; line-height: 1.4; }

  </style>
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
  <div class="ai-main">

    <!-- Top bar -->
    <div class="ai-topbar">
      <div class="ai-model-tag">
        <span class="ai-model-dot"></span>
        Wowoembege AI
      </div>
      <a href="index.php" class="ai-back-link d-md-none">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Beranda
      </a>
    </div>

    <!-- Messages -->
    <div class="ai-messages" id="aiMessages">

      <!-- Welcome State -->
      <div id="welcomeState" class="welcome-screen">
        <img src="<?= $basePath ?>/includes/image/chatbot2.jpeg" alt="Wowoembege Icon" style="width:72px; height:auto; margin:0 auto 1rem; border-radius:12px;">
        <h1>Bagaimana saya bisa membantu?</h1>
        <div class="welcome-suggestions">
          <?php
          $suggestions = [
            ['Bagaimana cara melaporkan jalan rusak?', 'Pengaduan'],
            ['Apa itu PPID Kota Bogor?', 'Informasi'],
            ['Jam operasional Diskominfo', 'Layanan'],
            ['Cara akses CCTV live Kota Bogor', 'CCTV'],
          ];
          foreach ($suggestions as $s): ?>
          <button class="suggestion-btn" onclick="sendSuggestion(this.dataset.msg)" data-msg="<?= esc($s[0]) ?>">
            <div class="suggestion-title"><?= esc($s[1]) ?></div>
            <div class="suggestion-desc"><?= esc($s[0]) ?></div>
          </button>
          <?php endforeach; ?>
        </div>
      </div>

    </div>

    <!-- Input Bar -->
    <div class="ai-input-bar">
      <div class="ai-input-inner">
        <textarea class="ai-textarea" id="aiInput" placeholder="Kirim pesan ke Wowoembege..." rows="1"></textarea>
        <button class="ai-send-btn" id="aiSend" aria-label="Kirim">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
        </button>
      </div>
      <p class="ai-footer-note">Wowoembege dapat membuat kesalahan. Harap verifikasi informasi penting.</p>
    </div>

  </div>
</div>

<!-- Libraries for Markdown and Highlight -->
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.0.5/purify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>

<script>
// Configure marked.js to use highlight.js
marked.setOptions({
  highlight: function(code, lang) {
    if (lang && hljs.getLanguage(lang)) {
      return hljs.highlight(code, { language: lang }).value;
    }
    return hljs.highlightAuto(code).value;
  },
  breaks: true
});

const msgsEl    = document.getElementById('aiMessages');
const welcomeEl = document.getElementById('welcomeState');
const inputEl   = document.getElementById('aiInput');
const sendBtn   = document.getElementById('aiSend');
const basePath  = '<?= $basePath ?>';

inputEl.addEventListener('input', () => {
  inputEl.style.height = 'auto';
  inputEl.style.height = Math.min(inputEl.scrollHeight, 200) + 'px';
});

function escHTML(s) {
  return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function appendMessage(rawContent, isUser) {
  if (welcomeEl) welcomeEl.remove();

  const row = document.createElement('div');
  row.className = 'ai-message-row ' + (isUser ? 'ai-message-user' : 'ai-message-ai');

  const avatarHTML = isUser
    ? `<div class="ai-avatar user">U</div>`
    : `<div class="ai-avatar bot"><img src="${basePath}/includes/image/chatbot2.jpeg" alt="Bot"></div>`;

  // Render Markdown safely
  let finalHtml = '';
  if (isUser) {
    finalHtml = `<div class="markdown-body"><p>${escHTML(rawContent).replace(/\n/g,'<br>')}</p></div>`;
  } else {
    // Parse markdown and sanitize
    const parsed = marked.parse(rawContent);
    finalHtml = `<div class="markdown-body">${DOMPurify.sanitize(parsed)}</div>`;
  }

  row.innerHTML = `
    <div class="ai-message-inner">
      ${avatarHTML}
      <div class="ai-message-content">${finalHtml}</div>
    </div>
  `;
  msgsEl.appendChild(row);
  msgsEl.scrollTo({ top: msgsEl.scrollHeight, behavior: 'smooth' });
  return row;
}

function showTyping() {
  const row = document.createElement('div');
  row.className = 'ai-message-row ai-message-ai';
  row.innerHTML = `
    <div class="ai-message-inner">
      <div class="ai-avatar bot"><img src="${basePath}/includes/image/chatbot2.jpeg" alt="Bot"></div>
      <div class="ai-message-content">
        <div class="typing-dots"><span></span><span></span><span></span></div>
      </div>
    </div>
  `;
  msgsEl.appendChild(row);
  msgsEl.scrollTo({ top: msgsEl.scrollHeight, behavior: 'smooth' });
  return row;
}

async function sendMessage(text) {
  if (!text.trim()) return;
  sendBtn.disabled = true;

  appendMessage(text, true);
  inputEl.value = '';
  inputEl.style.height = 'auto';

  const typingRow = showTyping();

  try {
    const fd = new FormData();
    fd.append('message', text);
    const res = await fetch(basePath + '/api/chat.php', { method: 'POST', body: fd });
    const data = await res.json();

    typingRow.remove();

    if (data.reply) {
      const msgRow = appendMessage(data.reply, false);
      
      if (data.category && data.category !== 'UNKNOWN') {
        const catBox = document.createElement('div');
        catBox.innerHTML = `
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
        msgRow.querySelector('.ai-message-content').appendChild(catBox);
      }
    } else {
      appendMessage('Maaf, terjadi kesalahan.', false);
    }
  } catch (e) {
    typingRow.remove();
    appendMessage(`**Error:** Koneksi gagal. Pastikan server berjalan dan coba lagi.`, false);
  }

  sendBtn.disabled = false;
}

function sendSuggestion(msg) { sendMessage(msg); }

sendBtn.addEventListener('click', () => sendMessage(inputEl.value));
inputEl.addEventListener('keydown', e => {
  if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(inputEl.value); }
});

document.getElementById('newChatBtn').addEventListener('click', () => {
  window.location.reload();
});
</script>
</body>
</html>
