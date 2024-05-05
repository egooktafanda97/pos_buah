<?php

namespace TaliumAttributes\Collection\Rutes;

use Attribute;

#[Attribute]
class Name
{
    public function __construct(public $name)
    {
    }
}
