<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
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
                'unique:users,email,' . Auth::id(),
            ],
            'phone' => [
                'required',
                'string',
                'unique:users,phone,' . Auth::id(),
            ],
        ];

        if ($this->filled('password') || $this->filled('old_password')) {
            $rules['old_password'] = [
                'required',
                'regex:/\S*/i',
                'current_password',
            ];

            $rules['password'] = [
                'required',
                'regex:/\S*/i',
                'confirmed',
            ];
        }

        return $rules;
    }

    public function validation(): array
    {
        $data = parent::validated();

        if ($this->filled('password') || $this->filled('old_password')) {
            unset($data['old_password']);
            unset($data['password_confirmation']);
        }

        return $data;
    }
}
