<?php

namespace TaliumAttributes\Collection\Rutes;

use Attribute;

#[Attribute]
class Delete
{
    public function __construct(public $uri)
    {
    }
}
