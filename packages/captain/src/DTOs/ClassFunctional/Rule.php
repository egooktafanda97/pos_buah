<?php

namespace Captain\DTOs\ClassFunctional;

class Rule
{
    private $rules;
    private $message;

    public function __construct($rules, $message = null)
    {
        $this->rules = $rules;
        $this->message = $message;
    }

    public function getRules()
    {
        return [$this->rules];
    }

    public function getMessage()
    {
        return $this->message;
    }
}
