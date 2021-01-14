<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Category extends Model
{
    use Translatable;

    protected $with='translations';
    protected $guarded=[];
    protected $hidden = ['translations']; // it can be visible by writing some code in controller
    protected $casts= ['is_active' => 'boolean']; // casting this field to boolean (get true instead of 1

    protected $translatedAttributes = ['name']; // Used For translatable package



    public function scopeParent($query){
        return $query -> whereNull('parent_id');
    }

    public function scopeChild($query){
        return $query -> whereNotNull('parent_id');
    }

    public function scopeActive($query){
        return $query->where('is_active',1);
    }

    public function getActive(){
       return  $this -> is_active  == 0 ?  'غير مفعل'   : 'مفعل' ;
    }

    public function _parent(){
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function _childs(){
        return $this->hasMany(self::class, 'parent_id');
    }

    public function products()
    {
        return $this -> belongsToMany(Product::class,'product_category');
    }


}
