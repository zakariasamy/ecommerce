<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Category extends Model
{
    use Translatable;
    protected $with='translations';
    protected $guarded=[];
    protected $hidden = ['translations']; // it can be visible by writing some code in controller
    protected $casts= ['is_active']; // casting this field to boolean (get true instead of 1

    public $translatedAttributes = ['name']; // Used For translatable package


}
