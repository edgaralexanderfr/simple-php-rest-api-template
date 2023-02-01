<?php

function send_response($body, int $http_code = 200, array $headers = [])
{
    if (!$headers) {
        $headers = [
            'Content-Type' => 'application/json',
        ];
    }

    foreach ($headers as $name => $value) {
        header("$name: $value");
    }

    http_response_code($http_code);

    echo json_encode($body);

    die();
}
