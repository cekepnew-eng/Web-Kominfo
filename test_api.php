<?php
$apiKey = 'YOUR_API_KEY';
$ch = curl_init('https://api.x.ai/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['model'=>'grok-2-latest','messages'=>[['role'=>'user','content'=>'hai']]]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: Bearer ' . $apiKey]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$res = curl_exec($ch);
echo "HTTP: " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";
echo "Error: " . curl_error($ch) . "\n";
echo "Response: " . $res . "\n";
