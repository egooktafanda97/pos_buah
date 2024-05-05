<?php

declare(strict_types=1);

namespace Captain\Attributes\DataTrasferAttribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
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
        public array|string $messages = [],

        /**
         * @var array<string>
         */
        public array|string $rules_update = [],
    ) {
    }
}
