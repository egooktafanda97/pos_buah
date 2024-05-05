<?php

declare(strict_types=1);

namespace Captain\Attributes\DataObejctModels\Eloquent;


use Attribute;
use Captain\Attributes\DataType\Increments;

#[Attribute]
class Id
{
    public function __construct(
        public mixed $type = Increments::class,
        public string|null $attribute = null
    ) {
    }
}
