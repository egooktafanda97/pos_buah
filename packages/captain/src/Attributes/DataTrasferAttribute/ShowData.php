<?php

declare(strict_types=1);

namespace Captain\Attributes\DataObejctModels\Eloquent;


use Attribute;
use Captain\Attributes\DataType\increments;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ShowData
{
    public function __construct()
    {
    }
}
