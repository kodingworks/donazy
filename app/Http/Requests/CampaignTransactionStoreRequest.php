<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CampaignTransactionStoreRequest extends FormRequest
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
            'payment_method_id' => [
                'required',
                'exists:payment_methods,id',
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

        if ($this->filled('payment_method_id')) {
            $validatedData['payment_method_id'] = $this->payment_method_id;
        }

        if ($this->filled('meta')) {
            $validatedData['meta'] = $this->meta;
        }

        if (Auth::check()) {
            $validatedData['user_id'] = Auth::id();
        }

        return $validatedData;
    }
}
