<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRequest extends FormRequest
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
        $data = [
            'name' => 'required|min:5|max:225|string',
            'password' =>'required|string|min:6|max:50',
            'email'=>'required|min:5|email|max:50',
            'address' => 'required|string|max:255'
        ];

        if(request()->routeIs('employee.update')) {
            $data['password'] = 'nullable|string|min:8|max:50';
        }
        return $data;
    }
}
