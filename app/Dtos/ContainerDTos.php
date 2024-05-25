<?php

namespace App\Dtos;

class ContainerDTos
{
    private $properties = [];

    public function __get($name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        trigger_error('Undefined property: ' . $name, E_USER_NOTICE);
        return null;
    }

    public function __set($name, $value)
    {
        $this->properties[$name] = $value;
    }

    public function __isset($name)
    {
        return isset($this->properties[$name]);
    }

    public function __unset($name)
    {
        unset($this->properties[$name]);
    }
}
