<?php

namespace App\Http\Requests\Products;

use App\Http\Requests\BaseApiRequest;

class CreateAttributeRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'data_type' => [
                'required',
                'integer'
            ]
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
