<?php

namespace Captain\Fn;

use Captain\Fn\DataContainer;

class HandlerArgumentAttribute
{
    private $results = [];

    public function getReulst()
    {
        return $this->results;
    }

    public function __construct(public $class, public $trace = [])
    {
    }

    public function attributes()
    {
        $trace = $this->trace;

        $attr = [];
        foreach ($trace as $traceItem) {
            // Check if args exists and is an array
            if (isset($traceItem['args']) && is_array($traceItem['args']) && !empty($traceItem['args'])) {

                foreach ($traceItem['args'] as $arg) {
                    $class = null;
                    if ($arg instanceof \ReflectionMethod) {
                        $reflection = $arg;
                        $class = $reflection->class;
                    } else {
                        continue; // Skip if it's neither a method nor a parameter reflection
                    }
                    $method = $reflection->getName();
                    if (!isset($attr[$class][$method])) {
                        $attr[$class][$method] = [];
                    }
                    if ($arg instanceof \ReflectionMethod) {
                        $parameters = $reflection->getParameters();

                        foreach ($parameters as $parameter) {
                            // Get attributes for each parameter
                            $attributes = $parameter->getAttributes();

                            foreach ($attributes as $attribute) {
                                $attributeName = $attribute->getName();
                                $arguments = $attribute->getArguments();

                                if (isset($attr[$class][$method][$attributeName])) {

                                    $attr[$attributeName] = [
                                        "value" => array_merge($attr[$class][$method][$attributeName], $arguments),
                                        "calling" => $class,
                                        "this" => $this->class,
                                        "method" => $method
                                    ];
                                } else {
                                    $attr[$attributeName] = [
                                        "value" => $arguments,
                                        "calling" => $class,
                                        "this" => $this->class,
                                        "method" => $method
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->results = $attr;
        return $this;
    }


    public function attributesByConstrusctor()
    {
        $trace = $this->trace;
        $attr = [];
        foreach ($trace as $traceItem) {

            // Check if args exists and is an array
            if (isset($traceItem['args']) && is_array($traceItem['args']) && !empty($traceItem['args'])) {
                foreach ($traceItem['args'] as $arg) {
                    // Check if the argument is a ReflectionMethod or ReflectionParameter
                    $class = null;
                    if ($arg instanceof \ReflectionParameter) {
                        $reflection = $arg->getDeclaringFunction();
                        $class = $arg->getClass()->name;
                    } else {
                        continue; // Skip if it's neither a method nor a parameter reflection
                    }
                    $method = $reflection->getName();
                    if (!isset($attr[$class][$method])) {
                        $attr[$class][$method] = [];
                    }

                    if ($arg instanceof \ReflectionParameter) {
                        // Get attributes directly if it's a parameter reflection
                        $attributes = $arg->getAttributes();
                        foreach ($attributes as $attribute) {
                            $attributeName = $attribute->getName();
                            $arguments = $attribute->getArguments();
                            if (isset($attr[$class][$method][$attributeName])) {
                                $attr[$attributeName] = [
                                    "value" => array_merge($attr[$class][$method][$attributeName], $arguments),
                                    "calling" => $class,
                                    "this" => get_class($this),
                                    "method" => $method
                                ];
                            } else {
                                $attr[$attributeName] = [
                                    "value" => $arguments,
                                    "calling" => $class,
                                    "this" => get_class($this),
                                    "method" => $method
                                ];
                            }
                        }
                    }
                }
            }
        }
        $this->results = $attr;
        return $this;
    }

    public function getArgument($AttributeClass = null)
    {
        if ($AttributeClass === null) {
            return null;
        }
        return new DataContainer($this->results[$AttributeClass] ?? []);
    }

    public function useAttributesII($trace)
    {
        $attr = [];
        foreach ($trace as $traceItem) {
            if (!isset($traceItem['args'][1]) || !$traceItem['args'][1] instanceof \ReflectionMethod) {
                continue; // Skip if not meeting conditions
            }

            $reflectionMethod = $traceItem['args'][1];
            $class = $reflectionMethod->class;
            $method = $reflectionMethod->getName();

            if (!isset($attr[$class][$method])) {
                $attr[$class][$method] = [];
            }

            $parameters = $reflectionMethod->getParameters();
            foreach ($parameters as $parameter) {
                if ($parameter->getName() === 'userServices') {
                    $attributes = $parameter->getAttributes();
                    foreach ($attributes as $attribute) {
                        $attributeName = $attribute->getName();
                        $arguments = $attribute->getArguments();

                        $attr[$class][$method][$attributeName] = $arguments;
                    }
                }
            }
        }

        // $this->setAttribute($attr);
    }
}
