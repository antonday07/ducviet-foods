<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckingInfoRequest extends FormRequest
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
            'name' =>'min:4' ,'max:225' ,'string',
            'phone'=>'min:8','phone',
            'address'=>'min:5','max:255',
            'email'=>'min:5','email'
        ];
    }
}
