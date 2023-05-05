<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => [
                'required',
                'string',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $this->user->id,
            ],
            'phone' => [
                'required',
                'string',
                'unique:users,phone,' . $this->user->id,
            ],
        ];

        if ($this->filled('password')) {
            $rules['password'] = [
                'required',
                'regex:/\S*/i',
                'confirmed',
            ];
        }

        $rules['admin'] = [
            'nullable',
            'boolean',
        ];

        return $rules;
    }
}
