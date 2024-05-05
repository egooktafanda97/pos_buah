<?php

declare(strict_types=1);

namespace Captain\Attributes\DataObejctModels\Eloquent;


use Attribute;

#[Attribute]
class Table
{
    /**
     * Model Table
     * @param string $table
     * @return void
     * @throws \ReflectionException
     */
    public function __construct(
        public string $name,
        public bool $timestamps = true,
        public bool $softDeletes = false,
        public bool $seeder = false,
        public bool $factory = false,
    ) {
    }
}
