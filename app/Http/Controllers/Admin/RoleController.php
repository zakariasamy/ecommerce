<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::get(); // use pagination and  add custom pagination on index.blade
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function saveRole(RoleRequest $request)
    {

        try {

            $role = $this->process(new Role, $request);
            if ($role)
                return redirect()->route('admin.roles.index')->with(['success' => 'تم ألاضافة بنجاح']);
            else
                return redirect()->route('admin.roles.index')->with(['error' => 'رساله الخطا']);
        } catch (\Exception $ex) {
            return $ex;
            // return message for unhandled exception
            return redirect()->route('admin.roles.index')->with(['error' => 'رساله الخطا']);
        }
    }

    public function edit($id)
    {
          $role = Role::findOrFail($id);
        return view('admin.roles.edit',compact('role'));
    }

    public function update($id,RoleRequest $request)
    {
        try {
            $role = Role::findOrFail($id);
            $role = $this->process($role, $request);
            if ($role)
                return redirect()->route('admin.roles.index')->with(['success' => 'تم التحديث بنجاح']);
            else
                return redirect()->route('admin.roles.index')->with(['error' => 'رساله الخطا']);
        } catch (\Exception $ex) {
            // return message for unhandled exception
            return redirect()->route('admin.roles.index')->with(['error' => 'رساله الخطا']);
        }
    }

    protected function process(Role $role, Request $r)
    {
        $role->name = $r->name;
        $role->permissions = json_encode($r->permissions);
        $role->save();
        return $role;
    }


}
