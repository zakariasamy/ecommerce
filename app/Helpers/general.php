<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

define('PAGINATION_COUNT',15);
function getFolder(){
    return LaravelLocalization::setLocale() == 'ar' ? "css-rtl" : "css";
}

?>
