<?php

function get_request_param(string $param): string|null
{
    if (!isset($_GET[$param])) {
        return null;
    }

    return $_GET[$param];
}
