<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Attribute extends Model
{
    use Translatable;
    protected $fillable = ['id'];
    protected $translatedAttributes = ['name']; // Used For translatable package
}
