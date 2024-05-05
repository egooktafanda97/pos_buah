<?php

namespace CrudMaster\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class ValidationRulesMerge
{
    public $rules = null;
    public function __construct(
        public mixed $class = null,
    ) {
    }
}
