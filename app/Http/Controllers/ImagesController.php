<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageFormRequest;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagesController extends Controller
{
    public function store(ImageFormRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $this->saveImage($request);
            $this->makeImageGrayAndResize($image);

            return redirect('/')->with('status', 'Your image has been uploaded successfully!');
        }

    }

    private function saveImage($request)
    {
        $file = $request->file('image');
        $name = $file->getClientOriginalName();
        $file->move(public_path() . '/images/', $name);

        return public_path() . '/images/' . $name;
    }

    private function makeImageGrayAndResize($imagePath)
    {
        Image::make($imagePath)->resize(1000, 250)->greyscale()->save();
    }
}
