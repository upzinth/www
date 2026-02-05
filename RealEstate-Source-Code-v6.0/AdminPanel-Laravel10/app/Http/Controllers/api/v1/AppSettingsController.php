<?php

namespace App\Http\Controllers\api\v1;

use App\Models\AppSettings;

class AppSettingsController extends BaseAPIController
{
    public static $APP_SETTINGS_DEFAULT_RECORD_ID = 1;

    public function get()
    {
        return $this->responseJSON(
            AppSettings::where('id', AppSettingsController::$APP_SETTINGS_DEFAULT_RECORD_ID)->first()
        );
    }

    public function aboutUs()
    {
        $appSettings = AppSettings::where('id', AppSettingsController::$APP_SETTINGS_DEFAULT_RECORD_ID)->first();
        if ($appSettings == null) {
            return $this->responseJSON(['aboutUs' => '', 'webSite' => '']);
        }
        return $this->responseJSON(
            [
                'aboutUs' => $appSettings->about_us,
                'webSite' => $appSettings->web_site,
            ]
        );
    }

    public function userTerms()
    {
        $appSettings = AppSettings::where('id', AppSettingsController::$APP_SETTINGS_DEFAULT_RECORD_ID)->first();
        if ($appSettings == null) {
            return $this->responseJSON(['userTerms' => '']);
        }
        return $this->responseJSON(
            [
                'userTerms' => $appSettings->user_terms,
            ]
        );
    }

    public function privacyPolicy()
    {
        $appSettings = AppSettings::where('id', AppSettingsController::$APP_SETTINGS_DEFAULT_RECORD_ID)->first();
        if ($appSettings == null) {
            return $this->responseJSON(['privacyPolicy' => '']);
        }
        return $this->responseJSON(
            [
                'privacyPolicy' => $appSettings->privacy_policy,
            ]
        );
    }
}
