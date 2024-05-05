<?php

namespace TaliumAttributes\Collection\Rutes;

use Attribute;

#[Attribute]
class Middleware
{
    public function __construct(public $middleware)
    {
    }
}
