<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Translatable;
    protected $with='translations';
    protected $guarded = [];
    protected $translatedAttributes = ['name']; // Used For translatable package
    protected $hidden = 'translations';

}
