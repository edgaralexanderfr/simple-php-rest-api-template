<?php

namespace Controller;

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/exceptions/ResourceCreationException.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/models/Collection.php';

use \Exception\ResourceCreationException;
use \Model\Collection;
use \stdClass;

class CollectionController
{
    private static $last_id = 5;
    private static $collections = [];

    public static function init()
    {
        self::$collections = [
            new Collection((object)[
                'id' => 1,
                'name' => 'Foo Fighters',
            ]),
            new Collection((object)[
                'id' => 2,
                'name' => 'Goo Goo Dolls'
            ]),
            new Collection((object)[
                'id' => 3,
                'name' => 'Radiohead',
            ]),
            new Collection((object)[
                'id' => 4,
                'name' => 'Oasis',
            ]),
        ];
    }

    public static function create(stdClass $collection = null)
    {
        if (!isset($collection->{'name'})) {
            throw new ResourceCreationException('The name for the collection is required', 101);
        }

        $collection = new Collection((object) [
            'id' => self::$last_id++,
            'name' => $collection->name,
        ]);

        self::$collections[] = $collection;

        return $collection;
    }

    public static function deleteOne(string $id)
    {
        $new_collections = [];

        foreach (self::$collections as $i => $collection) {
            if ($collection->id != $id) {
                $new_collections[] = $collection;
            }
        }

        self::$collections = $new_collections;
    }

    public static function retrieveOneById(string $id): Collection|null
    {
        $collections = self::retrieveAll();

        foreach ($collections as $collection) {
            if ($collection->id == $id) {
                return $collection;
            }
        }

        return null;
    }

    public static function retrieveAll(): array
    {
        return self::$collections;
    }
}

CollectionController::init();
