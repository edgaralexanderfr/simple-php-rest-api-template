<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/cmd.inc.php';

function cmd(string $cmd, callable $callable)
{
    $args = explode(' ', $cmd);

    foreach ($args as $arg) {
        if (get_cmd_arg($arg) === null) {
            return;
        }
    }

    $callable();

    exit(0);
}
