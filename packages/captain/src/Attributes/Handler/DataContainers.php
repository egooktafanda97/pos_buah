<?php

namespace Captain\Attributes\Handler;

class DataContainers
{
    private $value = [];
    private $calling;
    private $thisClass;
    private $method;

    public function setValue(array $value): void
    {
        $this->value = $value;
    }

    public function getValue(): array
    {
        return $this->value;
    }

    public function setCalling(string $calling): void
    {
        $this->calling = $calling;
    }

    public function getCalling(): string
    {
        return $this->calling;
    }

    public function setThisClass(string $thisClass): void
    {
        $this->thisClass = $thisClass;
    }

    public function getThisClass(): string
    {
        return $this->thisClass;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function toArray(): array
    {
        return [
            "value" => $this->value,
            "calling" => $this->calling,
            "this" => $this->thisClass,
            "method" => $this->method
        ];
    }
}
