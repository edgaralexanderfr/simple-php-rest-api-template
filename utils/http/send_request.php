<?php

function send_request(string $url, string $method = 'GET', mixed $data = null, array $headers = []): stdClass|array|null
{
    if (!$headers) {
        $headers = [
            'Content-Type' => 'application/json',
        ];
    }

    $curl_headers = [];

    foreach ($headers as $name => $value) {
        $curl_headers[] = "$name: $value";
    }

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $curl_headers);

    if ($data) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($curl);

    curl_close($curl);

    return json_decode($response);
}
