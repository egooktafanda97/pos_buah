<?php

namespace Captain\DTOs\Handler;

use Captain\Attributes\DataTrasferAttribute\{
    Rules,
    SetGet,
    Setter,
    Getter
};
use Captain\Attributes\DataObejctModels\Eloquent\{
    BelongsTo,
    EntityType,
    HasMany,
    Id,
    Table,
};

use Captain\Attributes\DataType\{
    Str,
    Date,
    DateTime,
    UnsignedInteger,
    BigIncrements,
    Text,
    UnsignedBigInteger,
    Increments
};
use Captain\DTOs\ClassFunctional\RuleBuilder;
use Illuminate\Contracts\Validation\Rule;

trait Builder
{
    public $rules = null;

    public static function attribute_register()
    {
        return [
            Rules::class,
            SetGet::class,
            Setter::class,
            Getter::class,
            BelongsTo::class,
            EntityType::class,
            HasMany::class,
            Id::class,
            Table::class,
            Str::class,
            Date::class,
            DateTime::class,
            UnsignedInteger::class,
            BigIncrements::class,
            Text::class,
            UnsignedBigInteger::class,
            Increments::class
        ];
    }

    private function attribute_validate($attribute)
    {
        return in_array($attribute, self::attribute_register());
    }

    private function findRegisterAttributes($attribute)
    {
        $arr =  array_search($attribute, self::attribute_register());
        return self::attribute_register()[$arr];
    }

    public function RulesBuilders()
    {
        $attributes = $this->properti_attributes;
        foreach ($attributes as $fild => $attribute) {
            foreach ($attribute as $key => $value) {
                if ($this->attribute_validate($key)) {
                    if ($this->findRegisterAttributes($key) == Rules::class) {
                        $this->rules[$fild][] = $value;
                    }
                }
            }
        }
        foreach ($this->rules as $key => $value) {
            foreach ($value as $k => $v) {
                $rules = $v->rules;
                $message = $v->message ?? null;
                $this->rules[$key] = [
                    'rules' => $rules,
                    'message' => $message
                ];
            }
        }
        $builder = new RuleBuilder($this->rules);
        # $rules->getRules(); | $rules = $builder->build(); > $rules['user_id']
        $this->rules = $builder;
    }
    public  function  getProperty()
    {
        return $this->properti_attributes;
    }
    public function getRules()
    {
        return $this->rules->getRules();
    }

    public function __construct()
    {
        parent::__construct();
        $this->RulesBuilders();
        // $this->rule($this->rules->getRules());
    }

    public function getRequest($request)
    {
        $req = collect($this->getProperty())->map(function ($x, $ky) {
            return $ky;
        })->keys()->toArray();
        $data = [];
        foreach ($req as $ky => $va) {
            if (!empty($request[$va])) {
                $data[$va] = $request[$va];
            }
        }
        return $data;
    }
}
