<?php

declare(strict_types=1);

namespace Captain\Attributes\DataTrasferAttribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS  | Attribute::TARGET_PROPERTY)]
class Setter
{
    public function __construct(public bool $setter = true)
    {
    }
}
