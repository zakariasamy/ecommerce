<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Traits\SlugTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index(){

    }

    public function Create(){
        $data['brands'] = Brand::active()->select('id')->get();
        $data['tags'] = Tag::select('id')->get();
        $data['categories'] = Category::active()->select('id')->get();
        return view('admin.products.general.create',$data);
    }

    public function store(ProductRequest $request){

        DB::beginTransaction();
        // Get Name without multi spaces
        $name = SlugTrait::improveName($request->name);

        // Generate Slug
        $slug = SlugTrait::toSlug($name);

        // Get all slugs from DB which starts with the same slug
        $all_slugs = Product::where('slug','like',$slug .'%')->get();

        // Get unique slug
        $slug = SlugTrait::getUniqueSlug($all_slugs, $slug);
        return $slug;
        $categories = $request->categories;
        $tags = '';
        if($request->has('tags'))
            $tags= $request->tags;

        $request = $request->except(['categories','tags']);

        $request['slug'] = $slug;
        $request['name'] = $name;

        // will be deleted
        $request['price']=10;

        $product = Product::create($request);

        $product->categories()->attach($categories);
        if($tags != '')
            $product->tags()->attach($tags);

        DB::commit();
        return dd($request);

        return $slug;
    }
}
