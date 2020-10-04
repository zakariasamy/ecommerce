<?php

namespace App\Http\Requests;

use App\Rules\ProductQty;
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
            'name' => 'required|max:100|string',
            'description' => 'required|max:1000',
            'short_description' => 'nullable|max:500',
            'categories' => 'required|array|min:1', //[]
            'categories.*' => 'numeric|exists:categories,id',
            'tags' => 'nullable',
            'brand_id' => 'exists:brands,id',

            // Prices
            'price' => 'required|numeric|min:0',
            'special_price' => 'nullable|numeric|min:0|lt:price',
            'special_price_type' => 'required_with:special_price|nullable|in:fixed,percent',
            'special_price_start' => 'required_with:special_price|nullable|date|date_format:Y-m-d',
            'special_price_end' => 'required_with:special_price|nullable|date|date_format:Y-m-d|after_or_equal:special_price_start',

            // Inventory Section المستودع
            'sku' => 'nullable|string|min:1|max:120',
            'in_stock' => 'required|in:0,1',
            'manage_stock' => 'required|in:0,1',
            'qty' => 'required_if:manage_stock,==,1',
            // Another way of use required_if , we will create custom rule - php artisan make:rule ProductQty
            'qty' => [new ProductQty($this->manage_stock)],
        ];
    }
}
