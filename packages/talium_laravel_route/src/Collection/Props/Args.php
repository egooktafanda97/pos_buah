<?php

namespace TaliumAttributes\Collection;

use Attribute;

#[Attribute]
class Args
{
    public function __construct(public $args = [])
    {
    }
}
