<?php

namespace TaliumAttributes\Collection\Models;

use Attribute;

#[Attribute]
class Rules
{
    public $rules;
    /**
     * class static method to get the rules
     * @param $models
     * @return mixed
     * @throws \ReflectionException
     */
    public function __construct($models)
    {
        $this->rules = $models::rules();
    }
}
