<?php

namespace Captain\DTOs\ClassFunctional;

class RuleBuilder
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $rules = [];
        foreach ($this->data as $key => $value) {
            $rules[$key] = new Rule($value['rules'], $value['message']);
        }
        return $rules;
    }

    public function getRules()
    {
        $result = [];
        foreach ($this->data as $key => $value) {
            $rules = $value['rules'];
            if (is_string($value['rules'])) {
                try {
                    $rules = explode('|', $value['rules']);
                } catch (\Throwable $th) {
                    $rules = [];
                }
            }
            $result[$key] = $rules;
        }
        return $result;
    }
}
