<?php

namespace TaliumAttributes\Collection;

use Attribute;

#[Attribute]
class Propertis
{
    public function __construct(public $props)
    {
    }
}
