<?php

declare(strict_types=1);

namespace Captain\Attributes\DataObejctModels\Eloquent;

use Attribute;

use function PHPUnit\Framework\callback;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Attr
{
    public function __construct(
        public bool $input = true,
    ) {
    }
}
