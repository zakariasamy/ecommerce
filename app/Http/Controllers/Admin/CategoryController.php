<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Category;
use App\Http\Traits\SlugTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Enumerations\CategoryType;

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
        //return $request->name['en'];
        try{
            DB::beginTransaction();
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);

            if($request->type == CategoryType::MainCategory) // Main category
                $request->request->add(['parent_id' => null]);


            $names=$request->name;

            // Generate slug
            // Get Name without multi spaces & unwanted chars
            foreach($names as $lang => $val)
                $names[$lang] = SlugTrait::improveName($val);
            $name = '';
            // Get first name in array which is $name["en"] to make slug from it
            foreach($names as $lang => $val){
                $name = $val;
                break;
            }

            if(isset($names["en"]))
                $name = $names["en"];
            else
                $name = $names["ar"];

            // Generate Slug
            $slug = SlugTrait::toSlug($name);

            // Get all slugs from DB which starts with the same slug
            $all_slugs = Category::where('slug','like',$slug .'%')->get();

            // Get unique slug
            $slug = SlugTrait::getUniqueSlug($all_slugs, $slug);

            $request->request->add(['slug' => $slug]);
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

            // Get Name without multi spaces & unwanted chars
            foreach($names as $lang => $val)
            $names[$lang] = SlugTrait::improveName($val);

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
