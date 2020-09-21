<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryRequest extends FormRequest
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
        'slug' => 'required|unique:categories,slug,' . $this->id,
        'type' => 'required|in:1,2', // Main or sub category
        ];
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        {
            $rules += ['name.' . $localeCode => 'required'];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.*.required' => 'الإسم مطلوب',
        ];
    }
}
