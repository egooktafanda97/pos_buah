<?php

namespace CrudMaster\Trait;

use Captain\Attributes\DataObejctModels\Eloquent\NoFillable;
use Captain\Attributes\DataTrasferAttribute\DataDTOs;
use CrudMaster\Attributes\Contract\ReflectionMeta;
use CrudMaster\Attributes\Table;

trait InjectModel
{
    public function Iject()
    {
        $dot = $this->getAttributeClass(DataDTOs::class);

        if (!empty($dot)) {
            $fillables = (new $dot())->fillable();
            foreach ($fillables as $key => $value) {
                if (!empty($value[NoFillable::class])) {
                    unset($fillables[$key]);
                }
            }
            $this->fillable(collect($fillables)->keys()->toArray());
        }

        $table = $this->getAttributeClass(Table::class);
        if (!empty($table)) {
            $this->table = $table;
        }
    }
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->Iject();
    }
    public function getAttributeClass($Attributes, $class = null,)
    {
        try {
            if ($class === null) {
                $class = $this;
            }
            $refrection = new \ReflectionClass($class);
            $attributesInMethod = $refrection->getAttributes($Attributes, \ReflectionAttribute::IS_INSTANCEOF);
            if (!empty($attributesInMethod)) {
                $ruleClass = $attributesInMethod;
                $name = $attributesInMethod[0]->getName() ?? null;
                $argument = $attributesInMethod[0]->getArguments()[0] ?? null;
                if ($name !== null && $argument !== null) {
                    $ruleClass = $argument;
                }
            }
        } catch (\Throwable $th) {
            return null;
        }
        return $ruleClass ?? null;
    }

    public  function getRules()
    {
        // if (!empty(self::$rules) || !empty($this->rules())) {
        //     return self::$rules ?? $this->rules();
        // }
    }
}
