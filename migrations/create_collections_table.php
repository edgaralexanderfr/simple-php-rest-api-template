<?php

$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../';

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/cmd.inc.php';

$pdo = require $_SERVER['DOCUMENT_ROOT'] . '/storage/pdo.inc.php';
$rollback = get_cmd_arg('--rollback');

if (!$rollback) {
    $pdo->query(
        "CREATE TABLE IF NOT EXISTS collections (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT
        );"
    );

    echo 'Table `collections` created successfully.' . PHP_EOL;
} else {
    $pdo->query(
        "DROP TABLE IF EXISTS collections;"
    );

    echo 'Table `collections` deleted successfully.' . PHP_EOL;
}
