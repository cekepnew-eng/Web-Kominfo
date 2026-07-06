<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

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
    'model' => 'openai',
    'messages' => [
        [
            'role' => 'system',
            'content' => $systemInstruction
        ],
        [
            'role' => 'user',
            'content' => $userComment
        ]
    ],
    'temperature' => 0.5
];

$ch = curl_init('https://text.pollinations.ai/openai');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200 || !$response) {
    $errData = json_decode((string)$response, true);
    $errMsg = $errData['error'] ?? 'Maaf, sistem AI Admin sedang sibuk.';
    if (is_array($errMsg)) {
        $errMsg = $errData['error']['message'] ?? json_encode($errMsg);
    }
    echo json_encode(['reply' => 'Layanan AI gagal: ' . $errMsg]);
    exit;
}

$data = json_decode($response, true);
$reply = $data['choices'][0]['message']['content'] ?? '';

if ($reply === '') {
    $reply = "Gagal menyusun draft balasan.";
}

echo json_encode(['reply' => trim($reply)]);
