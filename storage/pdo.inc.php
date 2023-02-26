<?php

$pdo_config = require $_SERVER['DOCUMENT_ROOT'] . '/config/pdo.inc.php';

$pdo = new PDO(
    $pdo_config->dsn,
    $pdo_config->username,
    $pdo_config->password,
    $pdo_config->options
);

return $pdo;
