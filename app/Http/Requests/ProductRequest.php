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
        return [
            // Basic data
            'name' => 'required|max:100',
            'description' => 'required|max:1000',
            'short_description' => 'nullable|max:500',
            'categories' => 'required|array|min:1', //[]
            'categories.*' => 'numeric|exists:categories,id',
            'tags' => 'nullable',
            'brand_id' => 'required|exists:brands,id',
            // Prices
            'price' => 'required|numeric|min:0',
            'special_price' => 'nullable|numeric|min:0|lt:price',
            'special_price_type' => 'required_with:special_price|nullable|in:fixed,percent',
            'special_price_start' => 'required_with:special_price|nullable|date|date_format:Y-m-d',
            'special_price_end' => 'required_with:special_price|nullable|date|date_format:Y-m-d',

        ];
    }
}
