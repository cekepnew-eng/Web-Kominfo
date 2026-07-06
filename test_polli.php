<?php
$payload = [
    'model' => 'openai',
    'messages' => [
        ['role' => 'user', 'content' => 'hello']
    ]
];
$options = [
    'http' => [
        'header'  => "Content-Type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($payload),
        'ignore_errors' => true
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
];
$context  = stream_context_create($options);
$result = file_get_contents('https://text.pollinations.ai/openai', false, $context);
echo "Result: " . $result . "\n";
