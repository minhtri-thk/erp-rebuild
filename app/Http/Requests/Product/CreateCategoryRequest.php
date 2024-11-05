<?php

namespace App\Http\Requests\Product;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseApiRequest;

class CreateCategoryRequest extends BaseApiRequest
{
    protected $table = 'categories';

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:255'
            ],
            'code' => [
                'required',
                'max:20',
                Rule::unique($this->table, 'code')
            ]
        ];
    }
}