<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Http\Controllers\Controller;
use App\Http\Enumerations\CategoryType;
use App\Http\Requests\CategoryRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::parent()->paginate(PAGINATION_COUNT);
        return view('admin.categories.index', compact('categories'));
    }

    public function create(){
        $categories = Category::parent()->get();
        return view('admin.categories.create',compact('categories'));
    }

    public function store(CategoryRequest $request){

        try{
            DB::beginTransaction();
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);

            if($request->type == CategoryType::MainCategory) // Main category
                $request->request->add(['parent_id' => null]);


            $names=$request->name;
            $cat = Category::create($request->except('type', 'name'));

            foreach($names as $lang => $val)
                $cat->translateOrNew($lang)->name = $val;
            $cat->save();

            DB::commit();

            return redirect()->route('admin.categories')->with(['success' => 'تم الإضافة بنجاح']);
        }
        catch(Exception $ex){
            DB::rollback();
            return redirect()->route('admin.categories')->with(['error' => 'حدث خطأ ما ، يرجي المحاولة لاحقاً']);
        }
    }

    public function edit($id)
    {

        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('admin.categories')->with(['error' => 'هذا القسم غير موجود']);
        }
        $categories = Category::parent()->get();
        return view('admin.categories.edit', compact('category'),compact('categories'));
    }

    public function update($id, CategoryRequest $request)
    {

        try {
            DB::beginTransaction();
            $category = Category::find($id);
            if (!$category)
                return redirect()->route('admin.categories')->with(['error' => 'هذا القسم غير موجود']);


            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);

            if($request->type == CategoryType::MainCategory) // Main category
            $request->request->add(['parent_id' => null]);

            $category->update($request->except('type','name'));

            $names=$request->name;

            foreach($names as $lang => $val)
                $category->translateOrNew($lang)->name = $val;
            $category->save();

            DB::commit();


            return redirect()->route('admin.categories')->with(['success' => 'تم التحديث بنجاح']);

        } catch (\Exception $ex) {
            DB::rollback();
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
