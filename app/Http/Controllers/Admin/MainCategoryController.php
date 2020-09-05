<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class MainCategoryController extends Controller
{

    public function index()
    {
        $categories = Category::parent()->paginate(PAGINATION_COUNT);
        return view('admin.categories.index', compact('categories'));
    }

    public function create(){
        return view('admin.categories.create');
    }

    public function store(MainCategoryRequest $request){
        try{
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);

            Category::create($request->all());
            return redirect()->route('admin.maincategories')->with(['success' => 'تم التحديث بنجاح']);
        }
        catch(Exception $ex){
            return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطأ ما ، يرجي المحاولة لاحقاً']);
        }
    }

    public function edit($id)
    {

        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود']);
        }

        return view('admin.categories.edit', compact('category'));
    }

    public function update($id, MainCategoryRequest $request)
    {

        try {
            $category = Category::find($id);
            if (!$category)
                return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود']);


            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);

            $category->update($request->all());
            return redirect()->route('admin.maincategories')->with(['success' => 'تم التحديث بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطأ ما ، يرجي المحاولة لاحقاً']);
        }
    }

    public function destroy($id){

        try{
        $category = Category::find($id);

        if(!$category)
            return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود']);

        $category->delete();

        return redirect()->route('admin.maincategories')->with(['success' => 'تم الحذف بنجاح']);

    } catch (\Exception $ex){
        return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطأ ما ، يرجي المحاولة لاحقاً']);
    }

}
}
