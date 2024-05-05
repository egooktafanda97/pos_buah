<?php

namespace TaliumAttributes\Collection\Rutes;

use Attribute;

#[Attribute]
class Get
{
    public function __construct(public $uri = '')
    {
    }
}
