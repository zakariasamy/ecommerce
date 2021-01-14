<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingRequest;

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

        return view('admin.settings.shipping.edit',compact('shippingMethod'));


    }

    public function updateShippingMethods(ShippingRequest $request){
        try{
            DB::beginTransaction();
            $shippingMethod = Setting::find($request->id);
            $shippingMethod->update(['plain_value' => $request->plain_value]);
            $shippingMethod->value = $request->value;
            $shippingMethod->save();
            DB::commit();
            return redirect()->route('edit.shipping.methods',$shippingMethod->id)->with(['success' => 'تم التحديث بنجاح']);
        }
        catch(Exception $ex){
            DB::rollback();
            return redirect()->route('edit.shipping.methods',$shippingMethod->id)
            ->with(['error' => 'حدث خطأ! يرجي المحاولة مرة أخري']);

        }
    }
}
