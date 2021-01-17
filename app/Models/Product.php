<?php

namespace App\Models;

use App\Models\Option;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
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

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function getActive(){
        return  $this -> is_active  == 0 ?  'غير مفعل' : 'مفعل';
     }

    public function scopeActive($query){
        return $query -> where('is_active',1);
    }

     public function options()
     {
         return $this->hasMany(Option::class,'product_id');
     }

     public function hasStock($quantity)
     {
         return $this->qty >= $quantity;
     }

     public function outOfStock()
     {
         return $this->qty === 0;
     }

     public function inStock()
     {
         return $this->qty >= 1;
     }


    public function getTotal($converted = true)
    {
        return $total =  $this->special_price ?? $this -> price;
    }
}
