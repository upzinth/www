<?php

namespace App\Http\Controllers;

use App\Library\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function image_get(Request $request)
    {
        $load = $request->load;
        if (FileHelper::checkImageFile($load)) {
            return redirect('/uploadfiles/images/' . $load);
        }
        return redirect('/uploadfiles/caches/' . $load);
    }

    public function image_create(Request $request)
    {
        $imageUploaded = request()->file('filepond');
        $imageName = Str::uuid()->toString() . '.' . $imageUploaded->getClientOriginalExtension();
        $imagePath = public_path('/uploadfiles/caches');
        $imageUploaded->move($imagePath, $imageName);
        return $imageName;
    }

    public function image_delete(Request $request)
    {
        $imageName = request()->getContent();
        $imagePath = public_path('/uploadfiles/caches/');
        File::delete($imagePath . $imageName);
        return $imageName;
    }
}
