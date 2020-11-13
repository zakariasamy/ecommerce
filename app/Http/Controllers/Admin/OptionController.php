<?php

namespace App\Http\Controllers\Admin;

use App\Models\Option;
use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\OptionRequest;

class OptionController extends Controller
{
    public function index()
    {
        $options = Option::with(['product' => function ($prod) {
            $prod->select('id');
        }, 'attribute' => function ($attr) {
            $attr->select('id');
        }])->select('id', 'product_id', 'attribute_id', 'price')->paginate(PAGINATION_COUNT);

        return view('admin.products.options.index', compact('options'));
    }

    public function create()
    {
        $data = [];
        $data['products'] = Product::active()->select('id')->get();
        $data['attributes'] = Attribute::select('id')->get();

        return view('admin.products.options.create', $data);
    }

    public function store(OptionRequest $request)
    {

       // return $request->value;
        DB::beginTransaction();

        //validation
        $option = Option::create([
            'attribute_id' => $request->attribute_id,
            'product_id' => $request->product_id,
            'price' => $request->price,
        ]);
        //save translations
        $option->value = $request->value;
        $option->save();
        DB::commit();

        return redirect()->route('admin.products.options')->with(['success' => 'تم ألاضافة بنجاح']);
    }

    public function edit($optionId)
    {

        $data = [];
         $data['option'] = Option::find($optionId);

        if (!$data['option'])
            return redirect()->route('admin.products.options')->with(['error' => 'هذه القيمة غير موجود ']);

         $data['products'] = Product::active()->select('id')->get();
        $data['attributes'] = Attribute::select('id')->get();

        return view('admin.products.options.edit', $data);

    }

    public function update($id, OptionRequest $request)
    {
        try {

             $option = Option::find($id);

            if (!$option)
                return redirect()->route('admin.products.options')->with(['error' => 'هذا ألعنصر غير موجود']);

            $option->update($request->only(['price','product_id','attribute_id']));
            //save translations
            $option->value = $request->value;
            $option->save();

            return redirect()->route('admin.products.options')->with(['success' => 'تم ألتحديث بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->route('admin.products.options')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {
        /*
        try {
            //get specific categories and its translations
            $category = Category::orderBy('id', 'DESC')->find($id);

            if (!$category)
                return redirect()->route('admin.categorie')->with(['error' => 'هذا القسم غير موجود ']);

            $category->delete();

            return redirect()->route('admin.maincategories')->with(['success' => 'تم  الحذف بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
        */
    }
}
