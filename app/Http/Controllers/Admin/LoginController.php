<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminLoginRequest;

class LoginController extends Controller
{
    public function login(){

        return view('admin.auth.login');

    }

    public function store(AdminLoginRequest $request){
        $remember_me = $request->has('remember_me') ? true : false;
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password],$remember_me))
            return redirect()->route('admin.dashboard');

        return $redirect()->route('admin.login')->with(['error' => 'هناك خطأ في البيانات']);
    }
}
