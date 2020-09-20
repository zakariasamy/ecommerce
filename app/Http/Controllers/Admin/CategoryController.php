<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;
class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::paginate(PAGINATION_COUNT);
        return view('admin.categories.index', compact('categories'));
    }

    public function create(){
        $categories = Category::select('id', 'parent_id')->get(); // Package will add name too
        return view('admin.categories.create',compact('categories'));
    }

    public function store(CategoryRequest $request){
        try{
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);

            if($request->type == 1) // Main category
                $request->request->add(['parent_id' => null]);

            Category::create($request->except('type'));
            return redirect()->route('admin.categories')->with(['success' => 'تم التحديث بنجاح']);
        }
        catch(Exception $ex){
            return redirect()->route('admin.categories')->with(['error' => 'حدث خطأ ما ، يرجي المحاولة لاحقاً']);
        }
    }

    public function edit($id)
    {

        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('admin.categories')->with(['error' => 'هذا القسم غير موجود']);
        }

        return view('admin.categories.edit', compact('category'));
    }

    public function update($id, CategoryRequest $request)
    {

        try {
            $category = Category::find($id);
            if (!$category)
                return redirect()->route('admin.categories')->with(['error' => 'هذا القسم غير موجود']);


            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);

            $category->update($request->all());
            return redirect()->route('admin.categories')->with(['success' => 'تم التحديث بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.categories')->with(['error' => 'حدث خطأ ما ، يرجي المحاولة لاحقاً']);
        }
    }

    public function destroy($id){

        try{
        $category = Category::find($id);

        if(!$category)
            return redirect()->route('admin.categories')->with(['error' => 'هذا القسم غير موجود']);

        $category->delete();

        return redirect()->route('admin.categories')->with(['success' => 'تم الحذف بنجاح']);

    } catch (\Exception $ex){
        return redirect()->route('admin.categories')->with(['error' => 'حدث خطأ ما ، يرجي المحاولة لاحقاً']);
    }

}
}
