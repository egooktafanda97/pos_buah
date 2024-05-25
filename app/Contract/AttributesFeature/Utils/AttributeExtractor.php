<?php

namespace App\Contract\AttributesFeature\Utils;

use ReflectionClass;

class AttributeExtractor
{
    private $class;
    private $attribute;
    private $method;
    private $property;
    private $attributes;

    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
        return $this;
    }

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    public function setProperty($property)
    {
        $this->property = $property;
        return $this;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getProperty()
    {
        return $this->property;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function extractAttributes()
    {
        $this->extractClassAttributes();
        $this->extractMethodAttributes();
        return $this->attributes;
    }

    private function extractClassAttributes()
    {
        $reflectionClass = new ReflectionClass($this->class);
        $classAttributes = $reflectionClass->getAttributes($this->attribute);
        foreach ($classAttributes as $classAttribute) {
            $attributeInstance = $classAttribute->newInstance();
            $this->attributes[] = $this->getAttributeProperties($attributeInstance);
        }
    }

    private function extractMethodAttributes()
    {
        $reflectionClass = new ReflectionClass($this->class);
        $methods = $reflectionClass->getMethods();
        foreach ($methods as $method) {
            $methodAttributes = $method->getAttributes($this->attribute);
            if (!empty($methodAttributes) && $this->method === $method->getName()) {
                foreach ($methodAttributes as $methodAttribute) {
                    $attributeInstance = $methodAttribute->newInstance();
                    $this->attributes[] = $this->getAttributeProperties($attributeInstance);
                }
            }
        }
    }

    private function getAttributeProperties($attributeInstance)
    {
        $properties = [];
        $reflection = new ReflectionClass($attributeInstance);
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $properties[$property->getName()] = $property->getValue($attributeInstance);
        }
        return $properties;
    }
}
