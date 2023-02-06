<?php

namespace Storage;


class Storage
{
    private static \PDO $pdo;

    public static function init()
    {
        $pdo_config = require_once $_SERVER['DOCUMENT_ROOT'] . '/config/pdo.inc.php';

        self::$pdo = new \PDO(
            $pdo_config->dsn,
            $pdo_config->username,
            $pdo_config->password,
            $pdo_config->options
        );
    }

    public static function store(string $collection, \stdClass $data)
    {
        $fields = self::getStatementFields($data);
        $values = self::getStatementValues($data);

        $statement = self::$pdo->prepare(
            "INSERT INTO $collection ($fields) VALUES ($values);"
        );

        $statement->execute((array) $data);
    }

    public static function getAll(string $collection): array
    {
        $statement = self::$pdo->prepare(
            "SELECT * FROM $collection;"
        );

        $statement->execute();

        return array_map(function ($row) {
            return (object) $row;
        }, $statement->fetchAll());
    }

    public static function getOne(string $collection, \stdClass $data): ?\stdClass
    {
        $conditions = self::getStatementConditions($data);

        $statement = self::$pdo->prepare(
            "SELECT * FROM $collection WHERE $conditions;"
        );

        $statement->execute((array) $data);

        $row = $statement->fetch(\PDO::FETCH_OBJ);

        return $row ? $row : null;
    }

    private static function getStatementFields(\stdClass $data): string
    {
        return implode(', ', array_keys((array) $data));
    }

    private static function getStatementValues(\stdClass $data): string
    {
        return implode(', ', array_map(function ($key) {
            return ":$key";
        }, array_keys((array) $data)));
    }

    private static function getStatementConditions(\stdClass $data): string
    {
        return implode(' AND ', array_map(function ($key) {
            return "$key = :$key";
        }, array_keys((array) $data)));
    }
}

Storage::init();