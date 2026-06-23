<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$GEMINI_API_KEY = 'AQ.Ab8RN6KW8c4OpaKka0suJQYoqKRaH5vdJrmpuxuSqQVj2bQiYg';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['reply' => 'Method not allowed.']);
    exit;
}

$userComment = trim((string) ($_POST['user_comment'] ?? ''));
if ($userComment === '') {
    echo json_encode(['reply' => 'Pesan komentar tidak valid.']);
    exit;
}

$systemInstruction = <<<PROMPT
Kamu adalah Admin Diskominfo Kota Bogor (dibantu oleh AI Wowoembege).
Tugasmu:
Buatlah draft balasan resmi namun tetap ramah (tidak kaku) untuk komentar/keluhan warga yang dikirimkan ini.
ATURAN:
1. Awali dengan sapaan sopan (misal: "Halo Bapak/Ibu," atau "Halo Akang/Teteh,").
2. Tunjukkan empati dan bahwa laporan/komentar mereka telah dibaca.
3. Berikan jawaban solutif, ringkas, dan jelas.
4. Jika keluhan bersifat teknis (jalan rusak, lampu mati), sampaikan bahwa laporan sedang/akan dikoordinasikan dengan dinas terkait (seperti DPUPR atau Disperumkim).
5. Jangan gunakan bahasa yang terlalu panjang. Maksimal 3 paragraf pendek.
6. Akhiri dengan "Terima kasih. - Admin Diskominfo".
PROMPT;

$payload = [
    'systemInstruction' => [
        'parts' => [
            ['text' => $systemInstruction]
        ]
    ],
    'contents' => [
        [
            'role' => 'user',
            'parts' => [
                ['text' => $userComment]
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.4,
        'maxOutputTokens' => 500,
    ]
];

$ch = curl_init('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $GEMINI_API_KEY);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200 || !$response) {
    echo json_encode(['reply' => "Maaf, sistem AI Admin sedang sibuk. Silakan ketik manual."]);
    exit;
}

$data = json_decode($response, true);
$reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

if ($reply === '') {
    $reply = "Gagal menyusun draft balasan.";
}

echo json_encode(['reply' => trim($reply)]);
