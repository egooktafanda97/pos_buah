<?php

namespace TaliumAttributes\Collection\Controller;

use Attribute;

#[Attribute]
class RestController
{
    public function __construct(public $controller = 'api', public $middleware = ["api"])
    {
    }
}
