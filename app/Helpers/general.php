<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

define('PAGINATION_COUNT',15);
function getFolder(){

    return LaravelLocalization::setLocale() == 'ar' ? "css-rtl" : "css";

}

function uploadImage($folder , $image){ // $folder is Added to fileSystem config
    $image->store('/',$folder);
    $fileName = $image->hashName();
    return $fileName;
}

?>
