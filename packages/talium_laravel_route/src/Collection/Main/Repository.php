<?php

namespace TaliumAttributes\Collection;

use Attribute;

#[Attribute]
class Repository
{
    public function __construct($repository)
    {
        app()->bind($repository, function () use ($repository) {
            return new $repository;
        });
    }
}
