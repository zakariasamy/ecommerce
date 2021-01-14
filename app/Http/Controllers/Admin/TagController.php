<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Http\Traits\SlugTrait;
use App\Http\Requests\TagRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Exception;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }


    public function store(TagRequest $request)
    {
        try{
            DB::beginTransaction();

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

            // Generate Slug
            $slug = SlugTrait::toSlug($name);

            // Get all slugs from DB which starts with the same slug
            $all_slugs = Tag::where('slug','like',$slug .'%')->get();

            // Get unique slug
            $slug = SlugTrait::getUniqueSlug($all_slugs, $slug);

            $request->request->add(['slug' => $slug]);

            $tag = Tag::create($request->except('name'));
            foreach($names as $lang => $val)
                $tag->translateOrNew($lang)->name = $val;
            $tag->save();
            DB::commit();
            return redirect()->route('admin.tags')->with(['success' => 'تم ألاضافة بنجاح']);
        }
    catch(Exception $ex){
        DB::rollback();
        return redirect()->route('admin.tags')->with(['error' => 'حدث خطأ ما ، يرجي المحاولة لاحقاً']);
    }

    }


    public function edit($id)
    {

        //get specific categories and its translations
          $tag = Tag::find($id);

        if (!$tag)
            return redirect()->route('admin.tags')->with(['error' => 'هذا الماركة غير موجود ']);



        return view('admin.tags.edit', compact('tag'));

    }


    public function update($id, TagRequest  $request)
    {
        try {

            $tag = Tag::find($id);

            if (!$tag)
                return redirect()->route('admin.tags')->with(['error' => 'هذا الماركة غير موجود']);

            DB::beginTransaction();

            $names=$request->name;

            // Get Name without multi spaces & unwanted chars
            foreach($names as $lang => $val)
                $names[$lang] = SlugTrait::improveName($val);
            $tag->update($request->except('name'));  // update only for slug column

            foreach($names as $lang => $val)
                $tag->translateOrNew($lang)->name = $val;
            $tag->save();
            DB::commit();

            return redirect()->route('admin.tags')->with(['success' => 'تم ألتحديث بنجاح']);

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.tags')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {
        try {
            //get specific categories and its translations
            $tags = Tag::find($id);

            if (!$tags)
                return redirect()->route('admin.tags')->with(['error' => 'هذا الماركة غير موجود ']);

            $tags->delete();

            return redirect()->route('admin.tags')->with(['success' => 'تم  الحذف بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.tags')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
}
