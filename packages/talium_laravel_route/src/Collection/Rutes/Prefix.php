<?php

namespace TaliumAttributes\Collection\Rutes;

use Attribute;

#[Attribute]
class Prefix
{
    public function __construct(public $prefix)
    {
    }
}
