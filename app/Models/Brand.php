<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Brand extends Model
{
    use Translatable;

    protected $with='translations';
    protected $guarded = [];
    protected $casts= ['is_active' => 'boolean']; // casting this field to boolean (get true instead of 1 .. )
    public $translatedAttributes = ['name']; // Used For translatable package

    public function getActive(){
        return  $this -> is_active  == 0 ?  'غير مفعل'   : 'مفعل' ;
     }

     public function  getPhotoAttribute($val){
        return ($val !== null) ? asset('assets/images/brands/' . $val) : "";
    }
}
