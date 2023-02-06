<?php

namespace Controller;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/storage.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/includes/collection.inc.php';

use \Exception\ResourceCreationException;
use \Model\Collection;
use \Storage\Storage;
use \stdClass;

class CollectionController
{
    public const COLLECTION = 'collections';

    public static function create(stdClass $collection = null)
    {
        if (!isset($collection->{'name'})) {
            throw new ResourceCreationException('The name for the collection is required', 101);
        }

        $collection = new Collection((object) [
            'name' => $collection->name,
        ]);

        Storage::store(self::COLLECTION, $collection->toObject());

        return $collection;
    }

    public static function updateOne(string $id, stdClass $collection = null)
    {
    }

    public static function deleteOne(string $id)
    {
    }

    public static function retrieveOneById(string $id): Collection|null
    {
        $collection = Storage::getOne(self::COLLECTION, (object) [
            'id' => (int) $id,
        ]);

        if ($collection) {
            return new Collection($collection);
        }

        return null;
    }

    public static function retrieveAll(): array
    {
        return array_map(function ($collection) {
            return new Collection($collection);
        }, Storage::getAll(self::COLLECTION));
    }
}
