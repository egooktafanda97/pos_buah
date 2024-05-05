<?php

namespace Captain\Collection;

use Captain\Attributes\DataTrasferAttribute\DataDTOs;
use Captain\Attributes\DataTrasferAttribute\Rules;
use Captain\Fn\HandlerArgumentAttribute;
use CrudMaster\Attributes\ValidationRules;
use CrudMaster\Attributes\ValidationRulesMerge;
use Illuminate\Support\Arr;

trait UseAttributeParameter
{
    private $myattributes;

    public function setAttribute($attr)
    {

        $this->myattributes = $attr;
    }

    public function __construct()
    {

        $this->useAttributes();
    }

    public function getParsingRules()
    {
        try {
            $ruleClass = $this->argumetAttribute(Rules::class)->getValue();
            if (empty($ruleClass)) {
                $ruleClass = $this->argumetAttribute(ValidationRules::class)->getValue();
                $refrection = new \ReflectionClass($ruleClass);
                $attributesInMethod = $refrection->getAttributes(DataDTOs::class, \ReflectionAttribute::IS_INSTANCEOF);
                if (!empty($attributesInMethod)) {
                    $name = $attributesInMethod[0]->getName() ?? null;
                    $argument = $attributesInMethod[0]->getArguments()[0] ?? null;

                    if ($name !== null && $argument !== null) {
                        $ruleClass = $argument;
                    }
                }
            }
            $useRules = (new $ruleClass())->getRules();

            return $useRules;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage(), 500);
        }
    }

    public function useAttributes()
    {
        $trace = debug_backtrace();

        $this->setAttribute((new HandlerArgumentAttribute(basename(__CLASS__), $trace))->attributes());
    }

    public function useAttributesConstruct()
    {
        $trace = debug_backtrace();
        $this->setAttribute((new HandlerArgumentAttribute(basename(__CLASS__), $trace))->attributesByConstrusctor());
    }

    /**
     * struktur 2
     */

    public function getParsingRulesMerge()
    {
        try {
            $isDTOs = $this->myattributes->getReulst()[ValidationRulesMerge::class]['value'][0];
            $rules = [];
            foreach ($isDTOs as $ky => $va) {
                $rules[] = (new $va())->getRules();
            }
            $useRules = call_user_func_array('array_merge', $rules);
            $xdata = [];
            foreach ($useRules as $xk => $xv) {
                $xvx = [];
                foreach ($xv as $xkk => $xvv) {
                    $unique = explode(":", $xvv);
                    if (count($unique) > 1 && $unique[0] == "unique") {
                        $xvx[] = $xvv;
                        if (empty(request()->id))
                            $xdata[$xk] =  $xvx;
                    } else {
                        $xvx[] = $xvv;
                        $xdata[$xk] =  $xvx;
                    }
                }
            }
            return $xdata;
        } catch (\Throwable $th) {
            return [];
        }
    }


    public function argumetAttribute($class)
    {

        return $this->myattributes->getArgument($class);
    }
}
