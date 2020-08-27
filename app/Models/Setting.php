<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Translatable;
    protected $with='translations';
    protected $fillable=['key','is_translatable','plain_value'];
    protected $casts= ['is_translatable' => 'boolean']; // casting this field to boolean (get true instead of 1 .. )
    public $translatedAttributes = ['value','locale']; // Used For translatable package



    public static function setMany($settings){
        foreach($settings as $key => $value){
            self::set($key,$value);
        }
    }

    public static function set($key, $value){

    if ($key == 'translatable') {
        foreach($value as $keyName => $val){
             static::setTranslatableSettings($keyName,$val);
        }
        return 0;
    }

    if(is_array($value)){
        $value=json_encode($value);
    }
    static::updateOrCreate(['key' => $key, 'plain_value' => $value]);

    }

    public static function setTranslatableSettings($key,$values = []){

        foreach ($values as $lang => $value) {

            static::updateOrCreate(['key' => $key], [
            'is_translatable' => true,
            'value' => $value, // The package will Now we add it to setting translations table
            'locale' => $lang // If we don't add locale, it will be added as language of app
            ]);

        }
    }
}
