<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function editShippingMethods($type){

        // free - inner - outer shipping methods

        if($type == 'free'){
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();
        }
        else if($type == 'inner'){
            $shippingMethod = Setting::where('key', 'local_label')->first();
        }
        else if($type == 'outer'){
            $shippingMethod = Setting::where('key', 'outer_label')->first();
        }
        else
            $shippingMethod = Setting::where('key', 'outer_label')->first(); // Get default shipping method

        return $view('admin.settings.shipping.edit',compact('shippingMethod'));


    }

    public function updateShippingMethods(Request $request,$id){

    }
}
