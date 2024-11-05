<?php

namespace App\Http\Requests\Departments;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'phone' => ['nullable', 'regex:/^[0-9]{10,11}$/', 'max:11'],
            'parent_id' => ['nullable', 'integer', 'exists:departments,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('department name'),
            'phone' => __('department phone'),
            'parent_id' => __('department parent'),
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'số điện thoại sai format ',
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
