<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiBaseRequest;

class CreateTransactionRequest extends ApiBaseRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'amount' => [
                'required',
                'numeric',
                'min:10000',
            ],
            'name' => [
                'required',
                'string',
            ],
            'email' => [
                'required',
                'string',
                'email',
            ],
            'phone' => [
                'nullable',
                'string',
            ],
            'anonymous' => [
                'nullable',
                'boolean',
            ],
            'message' => [
                'nullable',
                'string',
            ],
            'meta' => [
                'nullable',
                'json',
            ],
        ];
        
    }

    public function validation()
    {
        $validatedData = [
            'user_email' => $this->email,
            'user_name' => $this->name,
            'amount' => $this->amount,
        ];

        if ($this->filled('phone')) {
            $validatedData['user_phone'] = $this->phone;
        }

        if ($this->filled('anonymous')) {
            $validatedData['anonymous'] = $this->anonymous;
        }

        if ($this->filled('message')) {
            $validatedData['message'] = $this->message;
        }

        if ($this->filled('meta')) {
            $validatedData['meta'] = $this->meta;
        }

        return $validatedData;
    }
}
