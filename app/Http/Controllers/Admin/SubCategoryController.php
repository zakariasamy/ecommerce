<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use DB;
class SubCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::child()->orderBy('id','DESC') -> paginate(PAGINATION_COUNT);
        return view('admin.subCategories.index', compact('categories'));
    }

    public function create()
    {
         $categories = Category::parent()->orderBy('id','DESC') -> get();
        return view('admin.subCategories.create',compact('categories'));
    }


    public function store(SubCategoryRequest $request)
    {

        try {


            //validation

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);

            $category = Category::create($request->all());

            return redirect()->route('admin.subcategories')->with(['success' => 'تم ألاضافة بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function edit($id)
    {


        //get specific categories and its translations
        $category = Category::orderBy('id', 'DESC')->find($id);

        if (!$category)
            return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود ']);

        $categories = Category::parent()->orderBy('id','DESC') -> get();


        return view('admin.subCategories.edit', compact('category','categories'));

    }


    public function update($id, SubCategoryRequest $request)
    {
        try {
            //validation

            //update DB


            $category = Category::find($id);

            if (!$category)
                return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود']);

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);


            $category->update($request->all());


            return redirect()->route('admin.subcategories')->with(['success' => 'تم ألتحديث بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {

        try {
            //get specific categories and its translations
            $category = Category::orderBy('id', 'DESC')->find($id);

            if (!$category)
                return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود ']);

            $category->delete();

            return redirect()->route('admin.subcategories')->with(['success' => 'تم  الحذف بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
}
