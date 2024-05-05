<?php

namespace TaliumAttributes\Collection\Rutes;

use Attribute;

#[Attribute]
class Post
{
    public function __construct(public $uri)
    {
    }
}
