<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

function getFolder(){
    return LaravelLocalization::setLocale() == 'ar' ? "css-rtl" : "css";
}

?>
