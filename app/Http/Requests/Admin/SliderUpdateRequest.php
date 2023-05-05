<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SliderUpdateRequest extends FormRequest
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
                'string'
            ],
            'campaign_ids' => [
                'required',
                'array',
            ],
            'campaign_ids.*' => [
                'required',
                'integer',
            ],
        ];

        if ($this->filled('sort')) {
            $rules['sort'] = [
                'required',
                'integer',
                'min:1',
            ];
        }

        return $rules;
    }
}
