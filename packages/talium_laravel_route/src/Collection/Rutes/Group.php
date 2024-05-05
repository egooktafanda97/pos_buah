<?php

namespace TaliumAttributes\Collection\Rutes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Group
{
    public function __construct(
        public string $prefix = '',
        public array $middleware = [],
        public string $namespace = '',
        public string $name = '',
        public array $where = [],
    ) {
    }
}
