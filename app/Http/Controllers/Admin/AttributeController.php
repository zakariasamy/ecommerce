<?php

namespace App\Http\Controllers\Admin;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Traits\SlugTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{

    public function index()
    {
        $attributes = Attribute::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('admin.products.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.products.attributes.create');
    }

    public function store(Request $request)
    {
        //return $request;
        try{

        DB::beginTransaction();
        // Names
        $names=$request->name;

        // Get Name without multi spaces & unwanted chars
        foreach($names as $lang => $val)
            $names[$lang] = SlugTrait::improveName($val);

        $attribute = Attribute::create($request->all());
        // Name of Attribute
        foreach($names as $lang => $val)
            $attribute->translateOrNew($lang)->name = $val;
        $attribute->save();
        DB::commit();
        return redirect()->route('admin.products.attributes')->with(['success' => 'تم ألاضافة بنجاح']);
    }
    catch(Exception $ex){
        DB::rollback();
        return redirect()->route('admin.products.attributes')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
    }

    }

    public function edit($id)
    {

        //get specific categories and its translations
        $attribute = Attribute::find($id);

        if (!$attribute)
            return redirect()->route('admin.products.attributes')->with(['error' => 'هذه الخاصية غير موجود ']);

        return view('admin.products.attributes.edit', compact('attribute'));

    }

    public function update($id, Request $request)
    {
        try {

            $attribute = Attribute::find($id);

            if (!$attribute)
                return redirect()->route('admin.products.attributes')->with(['error' => 'هذه الخاصية غير موجود ']);

            DB::beginTransaction();
            // Names
            $names=$request->name;

            // Get Name without multi spaces & unwanted chars
            foreach($names as $lang => $val)
                $names[$lang] = SlugTrait::improveName($val);

                $attribute->update($request->except('name'));
                // Update The Name of Attribute
                foreach($names as $lang => $val)
                    $attribute->translateOrNew($lang)->name = $val;
                $attribute->save();

            DB::commit();

            return redirect()->route('admin.products.attributes')->with(['success' => 'تم التحديث بنجاح']);
        }
        catch(Exception $ex){
            DB::rollback();
            return redirect()->route('admin.products.attributes')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }

    public function destroy($id)
    {
        try {

            $attribute = Attribute::find($id);


            if (!$attribute)
                return redirect()->route('admin.products.attributes')->with(['error' => 'هذه الخاصية غير موجود ']);


            $attribute->delete();

            return redirect()->route('admin.products.attributes')->with(['success' => 'تم الحذف بنجاح']);
        }
        catch(Exception $ex){
            DB::rollback();
            return redirect()->route('admin.products.attributes')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }


}
