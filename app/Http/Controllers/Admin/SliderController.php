<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderImagesRequest;

class SliderController extends Controller
{
    public function addImages()
    {

        $images = Slider::get(['photo']); // Get all photos from databae
        return view('admin.sliders.images.create', compact('images'));
    }

    // save images to folder only
    public function saveSliderImages(Request $request)
        {

        $file = $request->file('dzfile');
        $filename = uploadImage('sliders', $file);

        return response()->json([
           'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);

    }

    public function saveSliderImagesDB(SliderImagesRequest $request)
    {


        try {
            // save dropzone images
            if ($request->has('document') && count($request->document) > 0) {
                foreach ($request->document as $image) {
                    Slider::create([
                        'photo' => $image,
                    ]);
                }
            }

            return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);

        } catch (\Exception $ex) {

        }
    }

    public function deleteImage(Request $request){

        $photo = public_path('/assets/images/sliders/' . $request->photo);
        if(file_exists($photo))
            unlink($photo);

    }
}
