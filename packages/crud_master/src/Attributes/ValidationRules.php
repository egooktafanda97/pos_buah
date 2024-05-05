<?php

namespace CrudMaster\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class ValidationRules
{
    public $rules = "test";
    public function __construct(
        public mixed $class = null,
    ) {
    }
}
