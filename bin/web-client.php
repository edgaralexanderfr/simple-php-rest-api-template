<?php

$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../';

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/cmd.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/http.inc.php';

cmd('collection get', function () {
    $collection = send_request('http://localhost:8888/api/v1/collection');

    echo PHP_EOL . 'Collection list:' . PHP_EOL;

    foreach ($collection as $entry) {
        echo PHP_EOL;
        echo "ID: $entry->id" . PHP_EOL;
        echo "Name: $entry->name" . PHP_EOL;
    }

    echo PHP_EOL;
});

cmd('collection create', function () {
    if (get_cmd_arg('--help') || get_cmd_arg('-h')) {
        echo 'This is the help for collection creation.';

        return;
    }

    echo 'Collection created.';
});
