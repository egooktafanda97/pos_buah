<?php

namespace CrudMaster\Attributes;

use Attribute;

#[Attribute]
class StaticMethodRules
{
    public $rules;
    public function __construct($models)
    {
        $this->rules = $models::rules();
    }
}
