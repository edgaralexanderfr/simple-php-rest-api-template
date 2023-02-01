<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/http/get_request_body.php';

function get_request_body_json()
{
    return json_decode(get_request_body());
}
