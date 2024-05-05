<?php

namespace Captain\Fn;

class DataContainer
{
    private $value;
    private $calling;
    private $thisClass;
    private $method;
    private $args;

    public function __construct($data)
    {
        $this->args = $data;

        if (isset($data['value'])) {
            $this->setValue($data['value']);
        }
        if (isset($data['calling'])) {
            $this->setCalling($data['calling']);
        }
        if (isset($data['this'])) {
            $this->setThisClass($data['this']);
        }
        if (isset($data['method'])) {
            $this->setMethod($data['method']);
        }
    }

    public function toArray()
    {
        $this->args['value'] = $this->args['value'][0] ?? $this->args['value'] ?? null;
        return $this->args;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        if (count($value) === 1) {
            $value = $value[0];
        }
        $this->value = $value;
    }

    public function getCalling()
    {
        return $this->calling;
    }

    public function setCalling($calling)
    {
        $this->calling = $calling;
    }

    public function getThisClass()
    {
        return $this->thisClass;
    }

    public function setThisClass($thisClass)
    {
        $this->thisClass = $thisClass;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }
}
