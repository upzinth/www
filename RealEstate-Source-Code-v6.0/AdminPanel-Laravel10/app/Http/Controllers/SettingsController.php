<?php

namespace App\Http\Controllers;

use App\Library\FileHelper;
use App\Models\AppSettings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SettingsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appSettings = AppSettings::find(1);
        if ($appSettings == null) {
            AppSettings::create([
                'id' => 1,
                'email' => 'publsoftware@gmail.com',
                'website' => 'http://pulsoft.com',
                'app_version' => '1.0.0',
                'facebook_url' => 'https://www.facebook.com/',
                'twitter_url' => 'https://www.twitter.com/',
                'user_terms' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'
            ]);
        }
        return view('settings.index')
            ->with('app_settings', $appSettings)
            ->with('user', Auth::user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'app_settings_email' => 'nullable|email',
            'app_settings_website' => 'nullable|url',
            'user_first_name' => 'required',
            'user_last_name' => 'required',
            'user_email' => 'required|email',
            'user_new_password' => 'same:user_new_password_again'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // App Settings Start
        if (Auth::user()->is_admin) {
            $appSettings = AppSettings::findOrFail(1);

            // For images operations
            $entityImagesNames = collect(explode(',', $appSettings->header_images))->filter(function ($value, $key) {
                return $value != '';
            });
            $requestImageNames =  collect(explode(',', $request->input('app_settings_header_images')))->filter(function ($value, $key) {
                return $value != '';
            });

            $appSettings->email = $request->input('app_settings_email');
            $appSettings->website = $request->input('app_settings_website');
            $appSettings->app_version = $request->input('app_settings_app_version');
            $appSettings->about_us = $request->input('app_settings_about_us');
            $appSettings->privacy_policy = $request->input('app_settings_privacy_policy');
            $appSettings->user_terms = $request->input('app_settings_user_terms');
            $appSettings->header_images = $request->input('app_settings_header_images');
            $appSettings->facebook_url = $request->input('app_settings_facebook_url');
            $appSettings->twitter_url = $request->input('app_settings_twitter_url');
            $appSettings->youtube_url = $request->input('app_settings_youtube_url');
            $appSettings->instagram_url = $request->input('app_settings_instagram_url');

            $appSettings->update();

            // Images operations
            foreach ($requestImageNames as $imageName) {
                FileHelper::moveCacheToImages($imageName);
            }
            foreach ($entityImagesNames as $imageName) {
                if (!$requestImageNames->contains($imageName)) {
                    FileHelper::removeImageFile($imageName);
                }
            }
        }
        // App Settings End

        // User Start
        $user = User::findOrFail(Auth::user()->id);
        $user->first_name = $request->input('user_first_name');
        $user->last_name = $request->input('user_last_name');
        $user->phone_number = $request->input('user_phone_number');
        $user->email = $request->input('user_email');
        $user->address = $request->input('user_address');
        $user->latitude = $request->input('user_latitude');
        $user->longitude = $request->input('user_longitude');

        $usernameFromForm = strtolower($request->input('user_username'));
        $usernameFromDB = strtolower($user->username);

        if ($usernameFromForm != $usernameFromDB) {
            if (User::where('username', $usernameFromForm)->exists()) {
                $validator->errors()->add('user_username', 'This username is already taken');
                return back()->withErrors($validator)->withInput();
            }
            $user->username = $usernameFromForm;
        }

        $emailFromForm = strtolower($request->input('user_email'));
        $emailFromDB = strtolower($user->email);

        if ($emailFromForm != $emailFromDB) {
            if (User::where('email', $emailFromForm)->exists()) {
                $validator->errors()->add('user_email', 'This email is already taken');
                return back()->withErrors($validator)->withInput();
            }
            $user->email = $emailFromForm;
        }

        $newPassword = $request->user_new_password;
        $newPasswordAgain = $request->user_new_password_again;

        if ($newPassword != '' && $newPasswordAgain != '') {
            $user->password = bcrypt($newPassword);
        }

        $user->update();
        // User End

        return redirect(route('settings'))->with('status', 'Settings updated!');
    }
}