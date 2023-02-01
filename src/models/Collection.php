<?php

namespace Model;

use \stdClass;

class Collection
{
    public ?string $id;
    public ?string $name;

    public function __construct(stdClass $collection = null)
    {
        $this->id = $collection->id ?? null;
        $this->name = $collection->name ?? null;
    }

    public function toObject(): stdClass
    {
        return (object) $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
