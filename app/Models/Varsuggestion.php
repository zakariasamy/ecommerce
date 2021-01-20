<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Varsuggestion extends Model
{
    use Translatable;
    protected $guarded = [];
    protected $translatedAttributes = ['name']; // Used For translatable package


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }




}
