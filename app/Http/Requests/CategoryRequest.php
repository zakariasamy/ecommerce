<?php

namespace App\Http\Requests;

use App\Models\CategoryTranslation;
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
        //'slug' => 'required|unique:categories,slug,' . $this->id,
        'type' => 'required|in:1,2', // Main or sub category
        ];
        // Make unique name except ids
        $ids = CategoryTranslation::where('category_id',$this->id)->select('id')->get();
        foreach($ids as $key=> $val)
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        {
            $ID = CategoryTranslation::where('category_id',$this->id)->where('locale',$localeCode)->select('id')->get();
            $ID = $ID[0]['id'];
            $rules += ['name.' . $localeCode => 'required|unique:category_translations,name,' . $ID];
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
