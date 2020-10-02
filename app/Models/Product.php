<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Translatable, SoftDeletes;

    protected $with = ['translations'];
    protected $fillable = [
        'brand_id',
         'slug',
        'sku',
        'price',
        'special_price',
        'special_price_type',
        'special_price_start',
        'special_price_end',
        'selling_price',
        'manage_stock',
        'qty',
        'in_stock',
        'is_active'
    ];

    protected $casts= [
        'manage_stock' => 'boolean',
        'in_stock' => 'boolean',
        'is_active' => 'boolean',
    ]; // casting this field to boolean (get true instead of 1)

    // The attributes that should be returned as date from Database
    protected $dates= [
        'special_price_start',
        'special_price_end',
        'start_date',
        'end_date',
        'deleted_at',
    ];
    protected $translatedAttributes = ['name', 'description', 'short_description']; // Used For translatable package


    public function brand(){
        return $this->belongsTo(Brand::class)->withDefault(); // With default---> to get default if brand Not existed
    }

    public function categories(){
        return $this->belongsToMany(Category::class , 'product_category'); // we don't need import because it at the same namespace
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
