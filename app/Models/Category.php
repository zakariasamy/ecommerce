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
    protected $casts= ['is_active' => 'boolean']; // casting this field to boolean (get true instead of 1

    public $translatedAttributes = ['name']; // Used For translatable package



    public function scopeParent($query){
        return $query -> whereNull('parent_id');
    }

    public function scopeChild($query){
        return $query -> whereNotNull('parent_id');
    }

    public function getActive(){
       return  $this -> is_active  == 0 ?  'غير مفعل'   : 'مفعل' ;
    }

    public function _parent(){
        return $this->belongsTo(self::class, 'parent_id');
    }


}
