<?php

namespace TaliumAttributes\Collection\Rutes;

use Attribute;

#[Attribute]
class Put
{
    public function __construct(public $uri)
    {
    }
}
