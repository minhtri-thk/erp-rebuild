<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class RegisterRequest extends BaseApiRequest
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
                'email',
                Rule::unique($this->table),
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'min:4',
            ],
            'employee_code' => [
                'required',
                'string',
                Rule::unique('user_profiles', 'user_id'),
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
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
