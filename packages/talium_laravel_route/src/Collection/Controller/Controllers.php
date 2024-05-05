<?php

namespace TaliumAttributes\Collection\Controller;

use Attribute;

#[Attribute]
class Controllers
{
    public function __construct(public $controller = 'web')
    {
    }
}
