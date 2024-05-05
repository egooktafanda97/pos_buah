<?php

declare(strict_types=1);

namespace Captain\Attributes\DataType;

class Str
{
    public function __construct(public int $length = 255)
    {
    }
}
