<?php

namespace App\Http\Requests\Users;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseApiRequest;

class UpdateRequest extends BaseApiRequest
{
    protected $table = 'users';
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                Rule::unique($this->table, 'email')->ignore($this->user, 'uuid'),
                'max:255',
            ],
            'password' => [
                'nullable',
                'string',
                'min:4',
            ],
            'employee_code' => [
                'required',
                'string',
                Rule::unique('user_profiles', 'user_id')->ignore($this->route()->user),
                'max:10',
            ],
            'first_name' => [
                'required',
                'string',
                'max:255',
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'gender' => [
                'required',
                'integer'
            ],
            'language' => [
                'required',
                'string'
            ],
            'address' => [
                'nullable',
                'string',
                'max:255',
            ],
            'department_ids' => [
                'nullable',
                'array',
            ],
            'department_ids.*' => [
                'exists:departments,id',
            ],
        ];
    }

    /**
     * Get the validation message that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
