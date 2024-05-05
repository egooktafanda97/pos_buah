<?php

namespace TaliumAttributes\Collection\Models;

use Attribute;

#[Attribute]
class BeforeAction
{
    public function __construct(public array $variable = [])
    {
    }
}
