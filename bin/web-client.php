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
        ], get_app_headers());

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
        ], get_app_headers());

        list_collection($collection);
    } catch (HTTPResponseException $e) {
        show_error($e);
    }
});

cmd('collection delete', function () {
    $config = get_config();
    $id = (int) get_arg('--id', 'ID: ');

    try {
        $collection = send_request("$config->api_endpoint/collection?id=$id", 'delete', null, get_app_headers());

        list_collection($collection);
    } catch (HTTPResponseException $e) {
        show_error($e);
    }
});

function get_config(): stdClass
{
    $auth_config = require $_SERVER['DOCUMENT_ROOT'] . '/config/auth.inc.php';

    return (object) [
        'api_endpoint' => get_cmd_arg('--api-endpoint') ?? API_ENDPOINT,
        'username' => get_cmd_arg('--username') ?? $auth_config->username,
        'password' => get_cmd_arg('--password') ?? $auth_config->password,
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

function get_app_headers(): array
{
    $config = get_config();
    $token = base64_encode("$config->username:$config->password");

    return [
        'Content-Type' => 'application/json',
        'Authorization' => "Basic $token",
    ];
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
    if (in_array($e->getCode(), [400, 401, 404])) {
        echo $e->getResponse()->message;
    } else {
        echo 'An unknown error has occurred.';
    }

    exit(1);
}
