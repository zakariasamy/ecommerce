<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Http\Requests\TagRequest;
use App\Http\Controllers\Controller;

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


        //validation
        $tag = Tag::create($request->all());


        return redirect()->route('admin.tags')->with(['success' => 'تم ألاضافة بنجاح']);


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
            //validation

            //update DB


             $tag = Tag::find($id);

            if (!$tag)
                return redirect()->route('admin.tags')->with(['error' => 'هذا الماركة غير موجود']);


            $tag->update($request->all());  // update only for slug column

            return redirect()->route('admin.tags')->with(['success' => 'تم ألتحديث بنجاح']);

        } catch (\Exception $ex) {

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
