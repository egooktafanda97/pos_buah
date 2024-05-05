<?php

namespace TaliumAttributes\Collection\Rutes;

use Attribute;

#[Attribute]
class Url
{
    public function __construct(public $url)
    {
    }
}
