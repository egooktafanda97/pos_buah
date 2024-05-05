<?php

declare(strict_types=1);

namespace Captain\Attributes\DataTrasferAttribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Resources
{
    public function __construct(
        public string $title = '',
        public string|null $show_page = null,
        public string|null $create_page = null,
        public string|null $update_page = null,
    ) {
    }
}
