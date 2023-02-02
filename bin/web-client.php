<?php

$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../';

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/cmd.inc.php';

cmd('collection create', function () {
    if (get_cmd_arg('--help') || get_cmd_arg('-h')) {
        echo 'This is the help for collection creation.';

        return;
    }

    echo 'Collection created.';
});
