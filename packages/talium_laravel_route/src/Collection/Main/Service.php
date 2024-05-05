<?php

namespace TaliumAttributes\Collection;

use Attribute;

#[Attribute]
class Service
{
    public function __construct(public $service)
    {
    }
}
