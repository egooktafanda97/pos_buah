<?php

declare(strict_types=1);

namespace Captain\Attributes\UserInterface;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_CLASS)]
class Ui
{

    public function __construct(
        public string $app_path = "",
        public ?string $base_path = "",
    ) {
    }
}
