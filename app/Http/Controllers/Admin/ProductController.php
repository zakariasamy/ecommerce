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

    public function try(){
        return view('admin.products.general.try');
    }
    public function index(){
        $products = Product::select('id','slug','price', 'is_active','created_at')->paginate(PAGINATION_COUNT);
        return view('admin.products.general.index', compact('products'));
    }

    public function Create(){
        $data['brands'] = Brand::active()->select('id')->get();
        $data['tags'] = Tag::select('id')->get();
        $data['categories'] = Category::active()->select('id')->get();
        return view('admin.products.general.create',$data);
    }

    public function store(ProductRequest $request){
        //return $request;

        DB::beginTransaction();
        // Get Name without multi spaces
        $name = SlugTrait::improveName($request->name);
        // Generate Slug
        $slug = SlugTrait::toSlug($name);

        // Get all slugs from DB which starts with the same slug
        $all_slugs = Product::where('slug','like',$slug .'%')->get();

        // Get unique slug
        $slug = SlugTrait::getUniqueSlug($all_slugs, $slug);

        //return $slug;
        $categories = $request->categories;
        $tags = '';
        if($request->has('tags'))
            $tags= $request->tags;

        $request = $request->except(['categories','tags']);

        $request['slug'] = $slug;
        $request['name'] = $name;

        // Price section
        // Handle if user entered special price details without special price using postman
        if($request['special_price'] == null){
            $request['special_price_type'] = null;
            $request['special_price_start'] = null;
            $request['special_price_end'] = null;
        }

        //return $request;
        $product = Product::create($request);
        $product->name = $name;
        $product->short_description = $request['short_description'];
        $product->description = $request['description'];
        $product->save();

        $product->categories()->attach($categories);
        if($tags != '')
            $product->tags()->attach($tags);

        DB::commit();
        return dd($request);

        return $slug;
    }
}
