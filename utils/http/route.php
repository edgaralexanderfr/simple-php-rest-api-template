<?php

function route(string $method, callable $callable)
{
    static $request_method;

    if (!$request_method) {
        $request_method = strtolower($_SERVER['REQUEST_METHOD']);
    }

    if (strtolower($method) == $request_method) {
        $callable();
    }
}
