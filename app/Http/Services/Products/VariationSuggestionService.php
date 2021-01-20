<?php

namespace App\Http\Services\Products;

use App\Http\Traits\SlugTrait;
use App\Models\VarsuggestionTranslation;
use App\Models\VariationSuggestionTranslation;


class VariationSuggestionService
{


    public function validateNameInCreate($lang, $name){
        // json contains accepts array like (['color','size']) - we should give length to return just who
        // are the same length
        $suggest = VarsuggestionTranslation::where('locale', $lang)->whereJsonContains('name', $name)
       ->whereJsonLength('name', sizeof($name))->exists();

        return $suggest; // true or false

        }

    public function GetNameErros($names){
        $errors = [];
        foreach($names as $lang => $val){
            $names[$lang] = SlugTrait::improveName($val);
             $name = preg_split('/\s*[-]\s*/', $names[$lang]); // ["color", "size"];

             $suggest = VarsuggestionTranslation::where('locale', $lang)->whereJsonContains('name', $name)
       ->whereJsonLength('name', sizeof($name))->exists();

            if($suggest)
                $errors+= ['name.' . $lang => 'الإسم مكرر' ];
        }

            return $errors; // true or false

        }

    // بحفظ كود فيها بس
    public function a(){
        $rules = [];
        // Make sure that name is unique

        if(isset($this->id)){ // it's set if we edit , but if we create we doesn't put this field
            foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            {
                $ID = VariationSuggestionTranslation::where('suggestion_id',$this->id)->where('locale',$localeCode)->select('id')->first();
                if(isset($ID))
                    $ID = $ID['id'];
                $rules += ['name.' . $localeCode => 'required|unique:variation_suggestion_translations,name,' . $ID];
            }
        }
        return $rules;
    }

}
