<?php

namespace TaliumAttributes\Collection\Models;

use Attribute;

#[Attribute]
class Model
{
    public function __construct(public $model)
    {
    }
}
