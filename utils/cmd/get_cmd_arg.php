<?php

function get_cmd_arg(string $arg): string|null|bool
{
    global $argv;

    foreach ($argv as $param) {
        if (strpos($param, $arg) !== false) {
            $pair = explode('=', $param);

            if (count($pair) > 1) {
                return $pair[1];
            }

            return true;
        }
    }

    return null;
}
