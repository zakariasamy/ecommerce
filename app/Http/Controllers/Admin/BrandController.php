<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Support\Str;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }


    public function store(BrandRequest $request)
    {

        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);


        $fileName = "";
        if ($request->has('photo')) {
            $fileName = uploadImage('brands', $request->photo);
        }
        $request = $request->except('photo');
        $request['photo'] = $fileName;

       // return $newRequest;

        $brand = Brand::create($request);

        return redirect()->route('admin.brands')->with(['success' => 'تم ألاضافة بنجاح']);



    }


    public function edit($id)
    {

        //get specific categories and its translations
        $brand = Brand::find($id);

        if (!$brand)
            return redirect()->route('admin.brands')->with(['error' => 'هذا الماركة غير موجود ']);

        return view('admin.brands.edit', compact('brand'));

    }


    public function update($id, BrandRequest $request)
    {
        try {
            //validation

            //update DB


            $brand = Brand::find($id);

            if (!$brand)
                return redirect()->route('admin.brands')->with(['error' => 'هذا الماركة غير موجود']);


            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);

            if ($request->has('photo')) {
                $photo = Str::after($brand->photo, 'brands/');
                $photo = public_path('/assets/images/brands/' . $photo);
                if(file_exists($photo))
                    unlink($photo);
                $fileName = uploadImage('brands', $request->photo);
                $request = $request->except('photo');
                $request['photo'] = $fileName;
                $brand->update($request);
            }
            else
                $brand->update($request->all());

            return redirect()->route('admin.brands')->with(['success' => 'تم ألتحديث بنجاح']);

        } catch (\Exception $ex) {

            return redirect()->route('admin.brands')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {
        try {
            //get specific categories and its translations
            $brand = Brand::find($id);

            if (!$brand)
                return redirect()->route('admin.brands')->with(['error' => 'هذا الماركة غير موجود ']);

            $photo = Str::after($brand->photo, 'brands/');
            $photo = public_path('/assets/images/brands/' . $photo);
            if(file_exists($photo))
                unlink($photo);

            $brand->delete();

            return redirect()->route('admin.brands')->with(['success' => 'تم  الحذف بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.brands')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
}
