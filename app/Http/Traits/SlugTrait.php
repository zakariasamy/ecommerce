<?php
namespace App\Http\Traits;

trait SlugTrait {

    public static function getUniqueSlug($all_slugs,$slug){

        $slug = strtolower($slug);
        $newSlug = $slug;

        if($all_slugs->contains('slug',$newSlug)){
            $i=0;
            do{
                $newSlug= $slug . '-' . $i;
                $i++;
            }while($all_slugs->contains('slug',$newSlug));

        }
        return $newSlug;
    }


    public static function improveName($name){
        // Convert multiple spaces to one space
        return preg_replace('/\s\s+/i', ' ', $name);
    }

    public static function toSlug($name){

        return str_replace(' ', '-', $name);
    }
}
