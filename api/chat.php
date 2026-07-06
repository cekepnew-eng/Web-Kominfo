<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// ── Validasi Request ────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['reply' => 'Method not allowed.', 'category' => 'UNKNOWN']);
    exit;
}

$message = trim((string) ($_POST['message'] ?? ''));
if ($message === '') {
    echo json_encode(['reply' => 'Pesan tidak boleh kosong.', 'category' => 'UNKNOWN']);
    exit;
}

// ── System Instruction (Persona Wowoembege) ──────────────────────
$systemInstruction = <<<PROMPT
Kamu adalah Wowoembege, asisten AI resmi Dinas Komunikasi dan Informatika (Diskominfo) Kota Bogor.

ATURAN UTAMA:
1. Jawab pertanyaan seputar layanan Diskominfo, SiBadra, CCTV, pengaduan, Smart City, dan info Pemkot Bogor dengan jelas dan ramah.
2. Kamu boleh merespons sapaan ramah (seperti "Halo", "Selamat pagi", "Apa kabar") dengan hangat layaknya asisten publik yang baik hati.
3. Jika pengguna meminta sesuatu yang sepenuhnya di luar wewenangmu (misal: minta coding, resep masakan, soal matematika rumit, atau candaan tidak pantas), tolaklah dengan bahasa yang amat sopan, halus, dan menyenangkan (misal: "Aduh, punten banget ya... Wowoembege cuma ngerti seputar info Kota Bogor nih!").
4. Gunakan bahasa Indonesia yang santai tapi tetap sopan (bisa sesekali disisipi logat Sunda akrab seperti "Kang/Teh", "Punten", atau "Muhun").
5. Jika ditanya siapa kamu, jawab: "Saya Wowoembege, asisten AI resmi Diskominfo Kota Bogor yang siap bantu Akang dan Teteh!"
6. Berikan informasi yang akurat. Jika tidak tahu, arahkan warga menghubungi (0251) 8321075 atau email kominfo@kotabogor.go.id.

INFORMASI DISKOMINFO KOTA BOGOR:
- Alamat: Jl. Ir. H. Juanda No.10, Kota Bogor, Jawa Barat
- Telp: (0251) 8321075
- Email: kominfo@kotabogor.go.id
- Kepala Dinas: Rudiyana, S.STP., M.Sc
- Website PPID: https://ppid.kotabogor.go.id
- Smart City: https://smartcity.kotabogor.go.id
- Pengaduan SiBadra: melalui portal resmi Diskominfo
- CCTV Live: tersedia di halaman CCTV portal ini
- Tugas utama: komunikasi publik, pengelolaan TIK, statistik daerah, persandian & keamanan siber.

DETEKSI KATEGORI PENGADUAN:
Setelah menjawab, jika pesan mengandung keluhan/pengaduan masyarakat, tambahkan tag di baris paling akhir:
[CATEGORY: Nama Kategori]

Kategori yang tersedia (pilih satu yang paling cocok):
- Jalan Rusak
- Lampu Mati
- Sampah
- Banjir
- Infrastruktur
- Layanan Publik

Jika bukan pengaduan atau tidak ada kategori yang cocok, tulis: [CATEGORY: UNKNOWN]
PROMPT;

// ── Payload API Gratis (OpenAI Format) ───────────────────────────
$payload = [
    'model' => 'openai',
    'messages' => [
        [
            'role' => 'system',
            'content' => $systemInstruction
        ],
        [
            'role' => 'user',
            'content' => $message
        ]
    ],
    'temperature' => 0.5
];

$apiUrl = 'https://text.pollinations.ai/openai';

// ── cURL Request ─────────────────────────────────────────────────
$ch = curl_init($apiUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json'
    ],
    CURLOPT_TIMEOUT        => 20,
    CURLOPT_SSL_VERIFYPEER => false,  // aman untuk localhost Laragon
]);

$rawResponse = curl_exec($ch);
$httpCode    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError   = curl_error($ch);
curl_close($ch);

// ── Penanganan Error cURL ────────────────────────────────────────
if ($rawResponse === false || $curlError !== '') {
    echo json_encode([
        'reply'    => 'Koneksi ke server AI gagal. Pastikan koneksi internet tersedia.',
        'category' => 'UNKNOWN'
    ]);
    exit;
}

// ── Penanganan Error HTTP ────────────────────────────────────────
if ($httpCode !== 200) {
    $errData = json_decode($rawResponse, true);
    $errMsg = $errData['error'] ?? 'Error tidak diketahui dari server AI.';
    if (is_array($errMsg)) {
        $errMsg = $errData['error']['message'] ?? json_encode($errMsg);
    }
    
    echo json_encode([
        'reply'    => 'Layanan AI gagal: ' . $errMsg,
        'category' => 'UNKNOWN'
    ]);
    exit;
}

// ── Parse Response ───────────────────────────────────────────────
$result = json_decode($rawResponse, true);
$aiText = trim((string) ($result['choices'][0]['message']['content'] ?? ''));

if ($aiText === '') {
    echo json_encode([
        'reply'    => 'Maaf, saya tidak dapat memproses pertanyaan Anda saat ini. Silakan coba lagi.',
        'category' => 'UNKNOWN'
    ]);
    exit;
}

// ── Ekstrak & Normalisasi Kategori ──────────────────────────────
$category = 'UNKNOWN';
if (preg_match('/\[CATEGORY:\s*(.+?)\]/i', $aiText, $matches)) {
    $raw = strtoupper(trim($matches[1]));
    $aiText = trim((string) preg_replace('/\[CATEGORY:\s*.+?\]/i', '', $aiText));

    $validCategories = ['JALAN RUSAK', 'LAMPU MATI', 'SAMPAH', 'BANJIR', 'INFRASTRUKTUR', 'LAYANAN PUBLIK'];
    if (in_array($raw, $validCategories, true)) {
        $category = ucwords(strtolower($raw));
    }
}

// ── Output Final ─────────────────────────────────────────────────
echo json_encode([
    'reply'    => $aiText,
    'category' => $category
], JSON_UNESCAPED_UNICODE);

