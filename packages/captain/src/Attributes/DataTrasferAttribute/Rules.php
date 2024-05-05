<?php

declare(strict_types=1);

namespace Captain\Attributes\DataTrasferAttribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY|Attribute::TARGET_CLASS|Attribute::TARGET_PARAMETER)]
class Rules
{
    public function __construct(
        /**
         * @var array<string>
         */
        public array|string $rules = [],
        /**
         * @var array<string, string>
         */
        public array $messages = []
    ) {
    }
}
