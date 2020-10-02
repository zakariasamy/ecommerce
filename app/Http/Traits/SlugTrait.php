<?php
namespace App\Http\Traits;

trait SlugTrait {

    public static function getUniqueSlug($all_slugs,$slug){

        if($all_slugs->contains('slug',$slug)){
            $i=0;

            do{
                $slug.='-' . $i;
                $i++;
            }while($all_slugs->contains('slug',$slug));

        }
        return $slug;
    }


    public static function improveName($name){
        // Convert multiple spaces to one space
        return preg_replace('/\s\s+/i', ' ', $name);
    }

    public static function toSlug($name){

        return str_replace(' ', '-', $name);
    }
}
