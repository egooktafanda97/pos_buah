<?php

declare(strict_types=1);

namespace Captain\Attributes\DataTrasferAttribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS  | Attribute::TARGET_PROPERTY)]
class DataDTOs
{
    public $classImpl = null;
    public function __construct(public $dto = null, $class = null)
    {
        $this->classImpl = $class;
    }
}
