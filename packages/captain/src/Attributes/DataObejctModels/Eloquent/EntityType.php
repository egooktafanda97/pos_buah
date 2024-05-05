<?php

declare(strict_types=1);

namespace Captain\Attributes\DataObejctModels\Eloquent;


use Attribute;
use Captain\Attributes\DataType\Str;

#[Attribute]
class EntityType
{
    /**
     * Model Table
     * @param string $table
     * @return void
     * @throws \ReflectionException
     */
    public function __construct(
        public mixed $type = new Str(255),
        public int|null $length = null,
        /**
         * default value
         */
        public mixed $default = null,
        /**
         * @var array
         */
        public array $attribute = [],
        /**
         * @var string
         */
        public string $comment = "",

        public bool $nullable = false,

        public bool $primary = false,

        public bool $fillable = true,

        public mixed $casts = null,

        public mixed $hidden = false,

        public bool $forminput = false,

        public bool $index = false,
    ) {
    }
}
