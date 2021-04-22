<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class TemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        return view('newTemplate');
    }

    private function resizeImage($image, $destination)
    {

        $imageName = $image->getClientOriginalName() . time() . '.' . $image->extension();

        $destinationPath = public_path('\images') . '\\' . $imageName;
        $img = Image::make($image->path());
        $img->resize(100, 100)->save($destinationPath);

        $newImage = $destination->create([]);

        $newImage->name = json_encode($imageName);
        $newImage->save();
    }

    public function store(Request $request)
    {
        // Check data
        $this->validate($request, [
            'name' => 'required',
            'profile' => 'required|mimes:jpeg,jpg,png,gif,csv,txt,xlx,xls,pdf|max:10000',
            'imageCollection' => 'required',
            'imageCollection.*' => 'mimes:jpeg,jpg,png,gif,csv,txt,xlx,xls,pdf|max:10000'
        ]);

        // Store template
        $template = $request->user()->templates()->create($request->only('name', 'description'));

        // Get profile picture of template
        $this->resizeImage($request->file('profile'), $template->profile());

        // Get all images
        foreach ($request->file('imageCollection') as $image) {
            $this->resizeImage($image, $template->images());
        }

        // Get all rows
        if (count($request->rows)) {

            for ($i = 0; $i < count($request->rows); $i++) {
                $newRow = $template->rows()->create([]);

                $newRow->colour = json_encode($request->rowColours[$i]);
                $newRow->name = json_encode($request->rows[$i]);
                $newRow->save();
            }
        }

        // Redirect user to template
        return redirect()->intended('dashboard');
    }
}
