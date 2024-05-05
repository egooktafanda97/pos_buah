<?php

namespace CrudMaster\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class BasicCrud
{
    public function __construct(
        public string|null $show = null,
        public string|null $create = null,
        public string|null $edit = null,
        public string|null $detail = null,
        public object|null $dots = null,
    ) {
    }
}
