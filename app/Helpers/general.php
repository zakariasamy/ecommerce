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


function subCatRecursion($categories, $counter, $char){ // For create category
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

function subCatRecursionForIndex($categories){ // FOr index cats
    foreach($categories as $category){

        if(isset($category->id)){
            echo '
    <tr>
        <td>' . $category->name . '</td>
        <td> ' . $category->_parent->name  . '</td>
        <td>' . $category->slug . '</td>
        <td> ' . $category->getActive() . '</td>
        <td>  <img style="width: 150px; height: 100px;"
                src="' . $category->photo . '"></td>
        <td>
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="' . route("admin.categories.edit", $category->id) . '"
                    class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>


                <a href="' . route('admin.categories.delete', $category->id) . '"
                    class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>

            </div>
        </td>
    </tr>
            ';
        }
        if(isset($category->_childs)){
            subCatRecursionForIndex($category->_childs);
        }
    }
}

function subCatRecursionForEdit($categories, $counter, $char, $parent){ // For edit cats
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
            $show = '<option value=" ' . $cat->id . '"';
            if($cat->id == $parent)
                $show.='selected';
            $show .= '> ' . $space . $style .
            $cat->name . '</option>';

            echo $show;
        }

        if(isset($cat->_childs)){
            subCatRecursion($cat->_childs, $counter+1, $char, $parent);
        }
    }
}




?>
