<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Exception;

class ProfileController extends Controller
{
    public function edit(){

        $admin = auth('admin')->user();
        return view('admin.profile.edit',compact('admin'));

    }


    public function update(ProfileRequest $request){
        try{
            unset($request['id']);
            unset($request['password_confirmation']);

            if($request->filled('password'))
                $request['password'] = bcrypt($request->password);
            else{
                unset($request['password']);
                unset($request['password_confirmation']);
            }


            auth('admin')->user()->update($request->all());
            return redirect()->route('edit.profile')
            ->with(['success' => 'تم التحديث بنجاح']);
        }
        catch(Exception $ex){
            return redirect()->route('edit.profile')
            ->with(['error' => 'حدث خطأ! يرجي المحاولة مرة أخري']);
        }
    }

}
