<?php

namespace App\Http\Controllers\api\v1;

use App\Models\AppSettings;
use App\Models\City;
use App\Models\Property;

class DashboardController extends BaseAPIController
{
    public function get()
    {
        $appSettings = AppSettings::find(1);
        $headerImages = $appSettings ? explode(',', $appSettings->header_images) : [];

        $featuredProperties = Property::with('property_type', 'property_category', 'user', 'city')->where('visible', 1)->get();

        $newProperties = Property::with('property_type', 'property_category', 'user', 'city')
            ->where('visible', 1)
            ->orderByRaw('properties.created_at DESC')
            ->take(5)
            ->get();

        $topSearchCities = City::orderByRaw('search_count DESC')->take(10)->get();

        return $this->responseJSON(
            [
                'headerImages' => $headerImages,
                'featuredProperties' => $featuredProperties,
                'newProperties' => $newProperties,
                'topSearchCities' => $topSearchCities,
            ]
        );
    }
}