<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $requiredImage = 'required';
        if(request()->routeIs('product.update')) {
            $requiredImage = 'nullable';
        }
        return [
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'slug' => ['required', 'string', 'min:5', 'max:50'],
            'unit_id' => "required|exists:units,id",
            'category_id' => "required|exists:categories,id",
            'promotion_id' => "required|exists:promotions,id",
            'supplier_id' => "required|exists:suppliers,id",
            'image' => [$requiredImage, 'image'],
            'entry_price' => ['required', 'numeric'],
            'retail_price' => ['required', 'numeric'],
            'description' => ['required', 'string', 'min:5'],
            'status' => "required|integer|in:1,2,3",
        ];
    }
}
