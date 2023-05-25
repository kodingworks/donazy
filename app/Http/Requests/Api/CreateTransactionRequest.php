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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_email' => 'required|email',
            'amount' => 'required|numeric',
            'campaign_id' => 'required|exists:campaigns,id',
        ];
    }
}
