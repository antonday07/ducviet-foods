<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'description' => ['required', 'string', 'min:5', 'max:250'],
            'type' => "required|integer|in:1,2,3",
            'price' => "required|numeric|max:100000",
            'date_from' => "required|date",
            'date_expiry' => "required|date"
        ];
    }
}
