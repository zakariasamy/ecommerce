<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Traits\SlugTrait;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;

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

        // Get Name without multi spaces
        $name = SlugTrait::improveName($request->name);

        // Generate Slug
        $slug = SlugTrait::toSlug($name);

        // Get all slugs from DB which starts with the same slug
        $all_slugs = Product::where('slug','like',$slug .'%')->get();

        // Get unique slug
        $slug = SlugTrait::getUniqueSlug($all_slugs, $slug);


        return $slug;
    }
}
