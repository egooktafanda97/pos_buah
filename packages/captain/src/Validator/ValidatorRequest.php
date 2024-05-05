<?php

namespace Captain\Validator;

use Captain\Collection\UseAttributeParameter;
use Captain\Attributes\DataTrasferAttribute\Rules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ValidatorRequest extends FormRequest
{
    use UseAttributeParameter;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return $this->getParsingRules();
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if (in_array('api', request()->route()->gatherMiddleware())) {
            $response = response()->json([
                'success' => false,
                'message' => 'Ops! Some errors occurred',
                'errors' => $validator->errors()
            ]);
        } else {
            $response = redirect()
                ->back()
                ->with('message', 'Ops! Some errors occurred')
                ->withErrors($validator);
        }

        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
