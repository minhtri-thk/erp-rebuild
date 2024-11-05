<?php

namespace App\Http\Requests\Products;

use App\Http\Requests\BaseApiRequest;

class CreateProductRequest extends BaseApiRequest
{
     /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'products.*.name' => [
                'required', 
                'max:255'
            ],
            'products.*.product_code' => [
                'required', 
                'unique:products,product_code', 
                'max:255'
            ],
            'products.*.category_id' => [
                'required', 
                'integer', 
                'exists:categories,id',
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

    public function messages(): array
    {
        return [
            'products.*.name.required' => 'The field is required.',
            'products.*.name.max' => 'The field is max length.',

            'products.*.product_code.required' => 'The field is required.',
            'products.*.product_code.unique' => 'The field has already been taken.',
            'products.*.product_code.max' => 'The field is max length.',

            'products.*.category_id.required' => 'The field is required.',
            'products.*.category_id.integer' => 'The must be an integer.',
            'products.*.category_id.exists' => 'The field value does not exist.',
        ];
    }
}
