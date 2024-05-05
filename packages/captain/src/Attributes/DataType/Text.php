<?php

declare(strict_types=1);

namespace Captain\Attributes\DataType;

class Text
{
    public function __construct(public int $length = 255)
    {
    }
}
