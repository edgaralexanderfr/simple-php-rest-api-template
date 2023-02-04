<?php

use Exception\HTTPResponseException;

$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../';

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/cmd.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/http.inc.php';

define('API_ENDPOINT', 'http://localhost:8888/api/v1/');

cmd('collection get --id', function () {
    $config = get_config();
    $id = (int) get_arg('--id', 'ID: ');

    try {
        $entry = send_request("$config->api_endpoint/collection?id=$id");

        echo PHP_EOL;
        echo 'Entry:' . PHP_EOL . PHP_EOL;

        show_entry($entry);

        echo PHP_EOL;
    } catch (HTTPResponseException $e) {
        show_error($e);
    }
});

cmd('collection get', function () {
    $config = get_config();

    try {
        $collection = send_request("$config->api_endpoint/collection");

        list_collection($collection);
    } catch (HTTPResponseException $e) {
        show_error($e);
    }
});

cmd('collection create', function () {
    $config = get_config();
    $name = (string) get_arg('--name', 'Name: ');

    try {
        $collection = send_request("$config->api_endpoint/collection", 'post', (object) [
            'name' => $name,
        ]);

        list_collection($collection);
    } catch (HTTPResponseException $e) {
        show_error($e);
    }
});

cmd('collection update', function () {
    $config = get_config();
    $id = (int) get_arg('--id', 'ID: ');
    $name = (string) get_arg('--name', 'Name: ');

    try {
        $collection = send_request("$config->api_endpoint/collection?id=$id", 'patch', (object) [
            'name' => $name,
        ]);

        list_collection($collection);
    } catch (HTTPResponseException $e) {
        show_error($e);
    }
});

cmd('collection delete', function () {
    $config = get_config();
    $id = (int) get_arg('--id', 'ID: ');

    try {
        $collection = send_request("$config->api_endpoint/collection?id=$id", 'delete');

        list_collection($collection);
    } catch (HTTPResponseException $e) {
        show_error($e);
    }
});

function get_config(): stdClass
{
    return (object) [
        'api_endpoint' => get_cmd_arg('--api-endpoint') ?? API_ENDPOINT,
    ];
}

function get_arg(string $arg, string $input_message): string
{
    $value = get_cmd_arg($arg);

    if (gettype($value) != 'string') {
        $value = readline($input_message);
    }

    return $value;
}

function list_collection(array $collection)
{
    echo PHP_EOL . 'Collection list:' . PHP_EOL;

    foreach ($collection as $entry) {
        echo PHP_EOL;

        show_entry($entry);
    }

    echo PHP_EOL;
}

function show_entry(mixed $entry)
{
    echo "ID: $entry->id" . PHP_EOL;
    echo "Name: $entry->name" . PHP_EOL;
}

function show_error(HTTPResponseException $e)
{
    if (in_array($e->getCode(), [400, 404])) {
        echo $e->getResponse()->message;
    } else {
        echo 'An unknown error has occurred.';
    }

    exit(1);
}
