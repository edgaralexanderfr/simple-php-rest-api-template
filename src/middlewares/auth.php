<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/http.inc.php';

function auth()
{
    $authorization = get_request_header('Authorization');

    if (!$authorization) {
        send_response((object) [
            'code' => 1,
            'message' => 'You have no permissions to perform this action',
        ], 401, [
            'Content-Type' => 'application/json',
            'WWW-Authenticate' => 'Basic',
        ]);
    }

    $auth_config = require_once $_SERVER['DOCUMENT_ROOT'] . '/config/auth.inc.php';
    $token = base64_decode(explode(' ', $authorization)[1] ?? '');
    $credentials = explode(':', $token);

    $username = $credentials[0] ?? '';
    $password = $credentials[1] ?? '';

    if ($username != $auth_config->username || $password != $auth_config->password) {
        send_response((object) [
            'code' => 2,
            'message' => 'Invalid credentials',
        ], 401, [
            'Content-Type' => 'application/json',
            'WWW-Authenticate' => 'Basic',
        ]);
    }
}
