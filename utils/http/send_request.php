<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/exceptions/HTTPResponseException.php';

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

    $response = json_decode(curl_exec($curl));
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    if ($http_code >= 400) {
        throw new \Exception\HTTPResponseException($http_code, $response);
    }

    return $response;
}
