<?php

function get_request_header(string $header)
{
    static $headers;

    $header = strtolower($header);

    if ($headers === null) {
        $headers = getallheaders();
    }

    if ($headers === false) {
        return null;
    }

    foreach ($headers as $name => $value) {
        if ($header == strtolower($name)) {
            return $value;
        }
    }

    return null;
}
