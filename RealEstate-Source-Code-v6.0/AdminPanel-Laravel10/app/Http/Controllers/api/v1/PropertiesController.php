<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\PropertyLike;
use App\Models\PropertyType;
use Illuminate\Support\Facades\Auth;

class PropertiesController extends BaseAPIController
{
    public function searchProperties(Request $request)
    {
        $mapFuncForId = function ($item) {
            return $item['id'];
        };

        $properties = Property::with('property_type', 'property_category', 'user', 'city')->where('visible', 1);

        if ($request->searchText != '') {
            $properties = $properties->where('title', 'like', '%' . $request->searchText . '%')
                ->orWhere('additional_features', 'like', '%' . $request->searchText . '%');
        }

        if (count($request->propertyTypes) > 0) {
            $properties = $properties->whereIn('property_type_id', collect($request->propertyTypes)->map($mapFuncForId));
        }

        if (count($request->propertyCategories) > 0) {
            $properties = $properties->whereIn('property_category_id', collect($request->propertyCategories)->map($mapFuncForId));
        }

        if (count($request->cities) > 0) {
            $properties = $properties->whereIn('city_id', collect($request->cities)->map($mapFuncForId));
        }

        $bedRoomCount = count($request->bedRoomCounts) > 0 ? head($request->bedRoomCounts) : 0;
        if ($bedRoomCount > 0) {
            $properties = $bedRoomCount > 5 ? $properties->where('bed_room_count', '>=', 5) :
                $properties->where('bed_room_count', '=', $bedRoomCount);
        }

        $bathRoomCount = count($request->bathRoomCounts) > 0 ? head($request->bathRoomCounts) : 0;
        if ($bathRoomCount > 0) {
            $properties = $bathRoomCount > 5 ? $properties->where('bath_room_count', '>=', 5) :
                $properties->where('bath_room_count', '=', $bathRoomCount);
        }

        $kitchenRoomCount = count($request->kitchenRoomCounts) > 0 ? head($request->kitchenRoomCounts) : 0;
        if ($kitchenRoomCount > 0) {
            $properties = $kitchenRoomCount > 5 ? $properties->where('kitchen_room_count', '>=', 5) :
                $properties->where('kitchen_room_count', '=', $kitchenRoomCount);
        }

        $parkingCount = count($request->parkingCounts) > 0 ? head($request->parkingCounts) : 0;
        if ($parkingCount > 0) {
            $properties = $parkingCount > 5 ? $properties->where('parking_count', '>=', 5) :
                $properties->where('parking_count', '=', $parkingCount);
        }

        $properties = $properties->whereBetween('price', [$request->minPrice, $request->maxPrice]);
        $properties = $properties->whereBetween('size', [$request->minSize, $request->maxSize]);

        if ($request->address != '') {
            $properties = $properties->where('address', 'like', '%' . $request->address . '%');
        }

        return $this->responseJSON(
            $properties->get()
        );
    }

    public function searchConstants()
    {
        return $this->responseJSON(
            [
                'propertyTypes' => PropertyType::all(),
                'propertyCategories' => PropertyCategory::all(),
                'cities' => City::all(),
            ]
        );
    }

    public function likedProperties()
    {
        $properties = PropertyLike::with('property.property_type', 'property.property_category', 'property.user', 'property.city', 'user')
            ->where('user_id', Auth::user()->id)
            ->get();

        return $this->responseJSON($properties->map(function ($item) {
            return $item['property'];
        }));
    }

    public function likeProperty(Request $request)
    {
        $isLiked = filter_var($request->isLiked, FILTER_VALIDATE_BOOLEAN);
        $propertyId = $request->propertyId;

        if ($isLiked) {
            if (!PropertyLike::where('property_id',  $propertyId)->where('user_id', Auth::user()->id)->exists()) {
                PropertyLike::create([
                    'property_id' => $propertyId,
                    'user_id' => Auth::user()->id,
                ]);
            }
        } else {
            PropertyLike::where('property_id',  $propertyId)->where('user_id', Auth::user()->id)->delete();
        }

        return $this->responseJSON(
            $request->input()
        );
    }
}