<?php

namespace Captain\DTOs\Handler;

use ReflectionClass;
use ReflectionMethod;

abstract class ExtractAttribute
{
    protected $class_attributes = [];
    protected $methood_attributes = [];
    protected $properti_attributes = [];

    abstract public function getAttributes();

    public function __construct()
    {
        $this->handlerAttribute();
    }

    /**
     * extract all attributes in class, method and
     */
    private function handlerAttribute()
    {
        $reflectionClass = new ReflectionClass($this);
        $attributesInClass = $reflectionClass->getAttributes();
        /**
         * get all attributes in class
         */
        foreach ($attributesInClass as $attribute) {
            $this->class_attributes[$attribute->getName()] = $attribute->newInstance();
        }
        /**
         * get all attributes in method
         */
        $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            $attributesInMethod = $method->getAttributes();
            foreach ($attributesInMethod as $attribute) {
                $this->methood_attributes[$method->getName()][$attribute->getName()] = $attribute->newInstance();
            }
        }
        /**
         * get all attributes in property
         */
        $properties = $reflectionClass->getProperties();
        foreach ($properties as $property) {
            $attributesInProperty = $property->getAttributes();
            foreach ($attributesInProperty as $attribute) {
                $this->properti_attributes[$property->getname()][$attribute->getName()] = $attribute->newInstance();
            }
        }
    }

    /**
     * get all attributes in class
     */
    public function getClassAttributes()
    {
        return $this->class_attributes;
    }

    /**
     * get all attributes in method
     */
    public function getMethodAttributes()
    {
        return $this->methood_attributes;
    }

    /**
     * get all attributes in property
     */
    public function getPropertyAttributes()
    {
        return $this->properti_attributes;
    }


}
