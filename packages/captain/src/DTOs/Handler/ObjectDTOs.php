<?php

namespace Captain\DTOs\Handler;

use Captain\Attributes\Types\DTOs;
use CrudMaster\Attributes\Model;
use ReflectionClass;
use ReflectionMethod;

abstract class ObjectDTOs extends ExtractAttribute
{
    use Builder, Eloquents;

    abstract public function rules($rules);

    public function getAttributes()
    {
        return [
            'class' => $this->class_attributes,
            'method' => $this->methood_attributes,
            'property' => $this->properti_attributes
        ];
    }


}
