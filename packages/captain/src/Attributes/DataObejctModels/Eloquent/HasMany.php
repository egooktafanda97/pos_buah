<?php

declare(strict_types=1);

namespace Captain\Attributes\DataObejctModels\Eloquent;

use Attribute;

use function PHPUnit\Framework\callback;

#[Attribute(Attribute::TARGET_PROPERTY)]
class HasMany
{
    public function __construct(
        public  string $function = "",
        public string $model = "",
        public ?string $key  = null,
        public ?string $skey  = null
    ) {
    }
}
