<?php

declare(strict_types=1);

namespace Captain\Attributes\DataObejctModels\Eloquent;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class belongsToMany
{
    public function __construct(
        public string $Model = "",
        public ?string $fkey  = "",
        public ?string $pkey  = ""
    ) {
    }
}
