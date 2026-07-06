<?php
$apiKey = 'YOUR_API_KEY';
$data = json_encode(['model'=>'grok-beta','messages'=>[['role'=>'user','content'=>'hai']]]);
$options = [
    'http' => [
        'header'  => "Content-Type: application/json\r\nAuthorization: Bearer $apiKey\r\n",
        'method'  => 'POST',
        'content' => $data,
        'ignore_errors' => true // so we can read the response body even if 4xx/5xx
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
];
$context  = stream_context_create($options);
$result = file_get_contents('https://api.x.ai/v1/chat/completions', false, $context);
echo "Result: " . $result . "\n";
echo "Headers: ";
print_r($http_response_header);
