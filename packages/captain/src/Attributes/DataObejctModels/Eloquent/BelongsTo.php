<?php

declare(strict_types=1);

namespace Captain\Attributes\DataObejctModels\Eloquent;

use Attribute;

use function PHPUnit\Framework\callback;

#[Attribute(Attribute::TARGET_PROPERTY)]
class BelongsTo
{
    public function __construct(
        public  mixed $function = "",
        public string $relation = "",
        public ?string $key  = "id",
        public ?string $fkey  = null
    ) {
    }
}
