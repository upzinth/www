<?php

namespace App\Library;

use Illuminate\Support\Facades\File;

class FileHelper
{
    public static function checkImageFile(string $imageName)
    {
        $imagePath = public_path('/uploadfiles/images/') . $imageName;
        return File::exists($imagePath);
    }

    public static function moveCacheToImages(string $imageName)
    {
        $sourceImagePath = public_path('/uploadfiles/caches/') . $imageName;
        $destImagePath = public_path('/uploadfiles/images/') . $imageName;
        if (File::exists($sourceImagePath)) {
            File::move($sourceImagePath, $destImagePath);
        }
    }

    public static function removeImageFile(string $imageName)
    {
        $imagePathForCaches = public_path('/uploadfiles/caches/') . $imageName;
        $imagePathForImages = public_path('/uploadfiles/images/') . $imageName;
        if (File::exists($imagePathForCaches)) {
            File::delete($imagePathForCaches);
        }
        if (File::exists($imagePathForImages)) {
            File::delete($imagePathForImages);
        }
    }
}