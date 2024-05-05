<?php

namespace TaliumAttributes\Collection\Models;

use Attribute;

#[Attribute]
class Table
{
    /**
     * Model Table
     * @param string $table
     * @return void
     * @throws \ReflectionException
     */
    public function __construct(public $table)
    {
    }
}
