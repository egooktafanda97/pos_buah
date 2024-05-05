<?php

namespace TaliumAttributes\Handler;

use ReflectionMethod;
use ReflectionParameter;
use TaliumAttributes\helper\FileHelpers;

class Handler
{
    use FileHelpers;

    private $results = [];

    public function __construct(public $class, public $trace = [])
    {
    }

    public function attributes()
    {
        $trace = $this->trace;
        $attr = [];
        foreach ($trace as $traceItem) {

            // Check if args exists and is an array
            if (isset($traceItem['args']) && is_array($traceItem['args'])) {

                foreach ($traceItem['args'] as $arg) {
                    // Check if the argument is a ReflectionMethod or ReflectionParameter
                    if ($arg instanceof ReflectionMethod) {
                        $reflection = $arg;
                    } elseif ($arg instanceof ReflectionParameter) {
                        $reflection = $arg->getDeclaringFunction();
                    } else {
                        continue; // Skip if it's neither a method nor a parameter reflection
                    }
                    if ($arg instanceof ReflectionParameter && strcasecmp($arg->getName(), $this->class) != 0)
                        continue;

                    if ($arg instanceof ReflectionMethod && strcasecmp($arg->getName(), $this->class) != 0)
                        continue;

                    $class = $reflection->class ?? null;
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
                    } elseif ($arg instanceof \ReflectionParameter) {
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
        return new ArgDataContainer($this->results[$AttributeClass] ?? []);
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
