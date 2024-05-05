<?php

declare(strict_types=1);

namespace Captain\Attributes\Helpers;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class Master
{
    public function __construct(
        /**
         * @var bool<string>
         */
        public bool $AutoCrud = true,
    ) {
    }
}
