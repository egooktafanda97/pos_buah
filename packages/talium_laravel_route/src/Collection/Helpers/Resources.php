<?php

namespace TaliumAttributes\Collection;

use Attribute;

#[Attribute]
class Resources
{
    public $show;
    public $update;
    public $create;

    public function __construct($path)
    {
    }
}
