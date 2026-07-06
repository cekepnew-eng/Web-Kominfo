<?php
$apiKey = 'YOUR_API_KEY';
$options = [
    'http' => [
        'header'  => "Authorization: Bearer $apiKey\r\n",
        'method'  => 'GET',
        'ignore_errors' => true
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
];
$context  = stream_context_create($options);
$result = file_get_contents('https://api.x.ai/v1/models', false, $context);
echo "Models:\n$result\n";
