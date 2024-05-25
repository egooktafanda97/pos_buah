<?php

namespace App\Contract\AttributesFeature\Attributes;

use Attribute;
use ReflectionClass;

#[Attribute(Attribute::TARGET_METHOD)]
class Rules
{
    public function __construct(
        public $validated = ''
    ) {
    }

    public function handler($className)
    {
        dd($this->getAttribute($className, $this::class));
    }

    public function getAttribute($class, $attributeClassName, $args = null)
    {
        $reflectionClass = new ReflectionClass($class);
        $classAttributes = $reflectionClass->getAttributes($attributeClassName);
        // $methods = $class->getMethods();
        dd($classAttributes, $reflectionClass->getMethods());
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
