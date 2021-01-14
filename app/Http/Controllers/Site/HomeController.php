<?php

namespace App\Http\Controllers\Site;


use App\Models\Category;
use App\Models\Slider;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function home()
    {
        $data = [];
         $data['sliders'] = Slider::get(['photo']);
         $data['categories'] = Category::parent()->select('id', 'slug')->with(['_childs' => function ($q) {
            $q->select('id', 'parent_id', 'slug');
            $q->with(['_childs' => function ($qq) {
                $qq->select('id', 'parent_id', 'slug');
            }]);
        }])->get();
        return view('front.home', $data);
    }
}
