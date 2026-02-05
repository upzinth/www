<?php

namespace App\Http\Controllers;

use App\Library\FileHelper;
use App\Models\City;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\PropertyType;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PropertiesController extends Controller
{
    public $validationRules = [
        'property_type_id' => 'required',
        'property_category_id' => 'required',
        'city_id' => 'required',
        'title' => 'required',
        'description' => 'required',
        'size' => 'required|numeric',
        'bed_room_count' => 'required|numeric',
        'bath_room_count' => 'required|numeric',
        'kitchen_room_count' => 'required|numeric',
        'parking_count' => 'required|numeric',
        'price' => 'required|numeric',
        'currency' => 'required',
        'address' => 'required',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'image_names' => 'required',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = Auth::user()->is_admin ? Property::all() : Property::where('user_id', Auth::user()->id)->get();
        return view('properties.index')->with('properties', $properties);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('properties.create')
            ->with('property_types', PropertyType::all())
            ->with('property_categories', PropertyCategory::all())
            ->with('cities', City::all())
            ->with('users', User::all());
    }

    private function fillModelFromRequest(Property $property, Request $request)
    {
        $property->property_type_id = (int) $request->input('property_type_id');
        $property->property_category_id = (int) $request->input('property_category_id');
        $property->city_id = (int) $request->input('city_id');
        $property->user_id = Auth::user()->is_admin ? (int) $request->input('user_id') : Auth::user()->id;
        $property->title = $request->input('title');
        $property->featured = filter_var($request->input('featured'), FILTER_VALIDATE_BOOLEAN);
        $property->visible = filter_var($request->input('visible'), FILTER_VALIDATE_BOOLEAN);
        $property->description = $request->input('description');
        $property->bed_room_count = (int) $request->input('bed_room_count');
        $property->bath_room_count = (int) $request->input('bath_room_count');
        $property->kitchen_room_count = (int) $request->input('kitchen_room_count');
        $property->parking_count = (int) $request->input('parking_count');
        $property->size = (int) $request->input('size');
        $property->additional_features = $request->input('additional_features');
        $property->currency = $request->input('currency');
        $property->price = (float) $request->input('price');
        $property->address = $request->input('address');
        $property->latitude = (float) $request->input('latitude');
        $property->longitude = (float) $request->input('longitude');
        $property->image_names = $request->input('image_names');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $imageNames = $request->input('image_names');
        $property = new Property;
        $this->fillModelFromRequest($property, $request);
        $property->save();

        $imageNamesArray = explode(',', $imageNames);
        foreach ($imageNamesArray as $imageName) {
            FileHelper::moveCacheToImages($imageName);
        }
        return redirect(route('properties.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $property = Property::findOrFail($id);
        return view('properties.edit')
            ->with('property', $property)
            ->with('property_types', PropertyType::all())
            ->with('property_categories', PropertyCategory::all())
            ->with('cities', City::all())
            ->with('users', User::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->validationRules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $property = Property::findOrFail($id);

        if (!Auth::user()->is_admin && Auth::user()->id != $property->user_id) {
            throw new Exception("security alert!");
        }

        if (!Auth::user()->is_admin) {
            $property->user_id = Auth::user()->id;
        }

        $entityImagesNames = collect(explode(',', $property->image_names));
        $requestImageNames =  collect(explode(',', $request->input('image_names')));

        $this->fillModelFromRequest($property, $request);
        $property->update();

        foreach ($requestImageNames as $imageName) {
            FileHelper::moveCacheToImages($imageName);
        }
        foreach ($entityImagesNames as $imageName) {
            if (!$requestImageNames->contains($imageName)) {
                FileHelper::removeImageFile($imageName);
            }
        }
        return redirect(route('properties.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $imageNamesArray = explode(',', $property->image_names);
        $property->delete();
        foreach ($imageNamesArray as $imageName) {
            FileHelper::removeImageFile($imageName);
        }
        return redirect(route('properties.index'));
    }
}