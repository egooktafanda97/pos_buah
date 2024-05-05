<?php

namespace CrudMaster\Attributes;

use Attribute;

#[Attribute]
class Service
{
    public function __construct(public $service)
    {
    }
}
