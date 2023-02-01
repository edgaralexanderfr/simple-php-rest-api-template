<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/http.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/includes/collection.inc.php';

use Controller\CollectionController;
use Exception\ResourceCreationException;

route('get', function () {
    $id = get_request_param('id');

    if ($id) {
        $collection = CollectionController::retrieveOneById((string) $id);

        if (!$collection) {
            send_response((object) [
                'code' => 102,
                'message' => 'Collection not found',
            ], 404);
        }

        send_response($collection);
    }

    send_response(CollectionController::retrieveAll());
});

route('post', function () {
    $params = get_request_body_json();

    try {
        CollectionController::create($params);
    } catch (ResourceCreationException $e) {
        send_response((object) [
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
        ], 400);
    }

    send_response(CollectionController::retrieveAll(), 201);
});

route('delete', function () {
    $id = get_request_param('id');

    CollectionController::deleteOne((string) $id);

    send_response(CollectionController::retrieveAll());
});
