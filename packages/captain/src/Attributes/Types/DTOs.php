<?php

declare(strict_types=1);

namespace Captain\Attributes\Types;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class DTOs
{
    public function __construct()
    {
    }
}
