<?php

namespace CrudMaster\Attributes\Contract;

use ReflectionClass;

class ReflectionMeta
{
    public static function  getAttribute($class, $attributeClassName, $args = null)
    {
        $reflectionClass = new ReflectionClass($class);
        $classAttributes = $reflectionClass->getAttributes($attributeClassName);
        foreach ($classAttributes as $classAttribute) {
            $attributeInstance = $classAttribute->newInstance();
            if (!empty($args) && property_exists($attributeInstance, $args)) {
                return $attributeInstance->$args;
            }
            return $attributeInstance;
        }
        return null;
    }
}
