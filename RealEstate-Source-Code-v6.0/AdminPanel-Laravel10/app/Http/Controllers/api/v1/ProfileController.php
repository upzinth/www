<?php

namespace App\Http\Controllers\api\v1;

use App\Library\FileHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfileController extends BaseAPIController
{
    public function userInfo()
    {
        return $this->responseJSON(['user' => Auth::user()]);
    }

    public function updateProfileImage(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($user->image_name != null || $user->image_name != '') {
            FileHelper::removeImageFile($user->image_name);
        }

        $imageUploaded = request()->file('image');
        $imageName = Str::uuid()->toString() . '.' . $imageUploaded->getClientOriginalExtension();
        $imagePath = public_path('/uploadfiles/images');
        $imageUploaded->move($imagePath, $imageName);

        $user->image_name = $imageName;
        $user->update();

        return $imageName;
    }
}