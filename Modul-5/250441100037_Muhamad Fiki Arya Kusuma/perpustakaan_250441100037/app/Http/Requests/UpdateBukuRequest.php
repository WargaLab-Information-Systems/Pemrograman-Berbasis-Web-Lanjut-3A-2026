<?php

namespace App\Http\Requests;

class UpdateBukuRequest extends StoreBukuRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        
        foreach ($rules as $field => $rule) {
            $rules[$field] = str_replace('required', 'sometimes', $rule);
        }

        return $rules;
    }
}