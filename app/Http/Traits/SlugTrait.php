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
        // Remove unwanted characters
        $name = $name = preg_replace('/[~!@#$%^&]+/i', '', $name);
        // Convert multiple spaces to one space
        return preg_replace('/\s\s+/i', ' ', $name);
    }

    public static function toSlug($name){
        //return $name;
        // Get the string first to avoid name like : samsung s9 - the best - 2020
        $name = preg_replace('/\s*[-_\/]\s*+/i', '', $name);
        //return preg_replace('/\s+/i', '-', $name);

        return str_replace(' ', '-', $name);
    }
}
