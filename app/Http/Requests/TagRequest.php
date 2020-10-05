<?php

namespace App\Http\Requests;

use App\Models\TagTranslation;
use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class TagRequest extends FormRequest
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
        $rules =[];
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        {
            $ID = TagTranslation::where('tag_id',$this->id)->where('locale',$localeCode)->select('id')->first();
            if(isset($ID))
                $ID = $ID['id'];
            $rules += ['name.' . $localeCode => 'required|unique:tag_translations,name,' . $ID];
        }
        return $rules;
    }
}
