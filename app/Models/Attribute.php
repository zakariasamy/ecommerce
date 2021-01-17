<?php

namespace App\Models;

use App\Models\Option;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Attribute extends Model
{
    use Translatable;
    protected $guarded = [];
    protected $translatedAttributes = ['name']; // Used For translatable package

    public  function options(){
        return $this->hasMany(Option::class,'attribute_id');
    }
}
