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


function subCatRecursion($categories, $counter, $char){
    foreach($categories as $cat){
        $space = "";
        $style= "";
        $temp=$counter;
        while($temp>0){
            $space.="&nbsp&nbsp&nbsp";
            $style.= $char;
            $temp--;
        }

        if(isset($cat->id)){
            echo '<option value=" ' . $cat->id . '"> ' . $space . $style .
             $cat->name . '</option>';
        }
        if(isset($cat->_childs)){
            subCatRecursion($cat->_childs, $counter+1, $char);
        }
    }
}




?>
