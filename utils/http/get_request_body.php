<?php

function get_request_body(): string
{
    return (string) file_get_contents('php://input');
}
