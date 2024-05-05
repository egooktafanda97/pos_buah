<?php

declare(strict_types=1);

namespace Captain\Attributes\DataObejctModels\Eloquent;


use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
class Model
{
    /**
     * Model Table
     * @param string $table
     * @return void
     * @throws \ReflectionException
     */
    public function __construct(
        public string $name = "",
        public bool $fillable = true,
        public bool $timestamps = true,
        public bool $softDeletes = false,
        public mixed $casts = null,
        public mixed $hidden = false,
        public bool $forminput = true,
    ) {
    }
}
