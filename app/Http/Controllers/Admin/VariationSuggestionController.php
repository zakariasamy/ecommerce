<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Varsuggestion;
use App\Http\Traits\SlugTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuggestionRequest;
use App\Repositories\VariationSuggestionRepository;

class VariationSuggestionController extends Controller
{


    private $service;
    public function __construct(VariationSuggestionRepository $varService){

        $this->service = $varService;

    }


    public function index()
    {


        $suggestions = Varsuggestion::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        //return $suggestions[0]->categories[0]->name;
        return view('admin.products.variation_suggestions.index', compact('suggestions'));
    }

    public function create()
    {

        $categories = Category::parent()->get(); // get all main categories
        return view('admin.products.variation_suggestions.create', compact('categories'));
    }

    public function store(SuggestionRequest $request)
    {
        $names=$request->name;

        $errors = $this->service->GetNameErros($names);
        if(!empty($errors))
            return redirect()->route('admin.products.var.suggest.create')->withErrors($errors);
        //return $request;
        //try{

        // Validation
        $validate = $request;

        DB::beginTransaction();
        // Names
        $general = ['is_general' => 0];
        if(in_array(-1 ,$request->categories))
            $general['is_general'] = 1;

           // return $request->categories;
        $suggestion = Varsuggestion::create(array_merge($request->except(['categories', 'name']), $general));
            //return $request;

        if($general['is_general'] == 0)
            $suggestion->categories()->sync($request->categories, false);

        foreach($names as $lang => $val){
            $names[$lang] = SlugTrait::improveName($val);
             $name = preg_split('/\s*[-]\s*/', $names[$lang]); // ["color", "size"];
                $name = json_encode($name); // to store in DB
             $suggestion->translateOrNew($lang)->name = $name;
        }


        $json_names=[];
        foreach($json_names as $lang => $val)
            $suggestion->translateOrNew($lang)->name = $val;
        //return $request;

        $suggestion->save();
        DB::commit();
        return redirect()->route('admin.products.var.suggest')->with(['success' => 'تم ألاضافة بنجاح']);
    //}
    //catch(Exception $ex){
    //    DB::rollback();
        //return redirect()->route('admin.products.var.suggest')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
   // }

    }

    public function edit($id)
    {

        //get specific categories and its translations
        $attribute = Attribute::find($id);

        if (!$attribute)
            return redirect()->route('admin.products.var.suggest')->with(['error' => 'هذه الخاصية غير موجود ']);

        return view('admin.products.variation_suggestions.edit', compact('attribute'));

    }

    public function update($id, AttributeRequest $request)
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

            return redirect()->route('admin.products.var.suggest')->with(['success' => 'تم التحديث بنجاح']);
        }
        catch(Exception $ex){
            DB::rollback();
            return redirect()->route('admin.products.var.suggest')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }

    public function destroy($id)
    {
        try {

            $attribute = Attribute::find($id);


            if (!$attribute)
                return redirect()->route('admin.products.var.suggest')->with(['error' => 'هذه الخاصية غير موجود ']);


            $attribute->delete();

            return redirect()->route('admin.products.var.suggest')->with(['success' => 'تم الحذف بنجاح']);
        }
        catch(Exception $ex){
            DB::rollback();
            return redirect()->route('admin.products.var.suggest')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }


}
