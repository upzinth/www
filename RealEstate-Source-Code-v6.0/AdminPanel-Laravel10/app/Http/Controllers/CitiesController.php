<?php

namespace App\Http\Controllers;

use App\Library\FileHelper;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitiesController extends Controller
{
    public $validationRules = [
        'name' => 'required',
        'image_name' => 'required',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        return view('cities.index')->with('cities', $cities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cities.create');
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
        $imageName = $request->input('image_name');
        $city = new City;
        $city->name = $request->input('name');
        $city->image_name = $imageName;
        $city->search_count = 0;
        $city->save();
        FileHelper::moveCacheToImages($imageName);
        return redirect('cities');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::findOrFail($id);
        return view('cities.edit')->with('city', $city);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->validationRules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $imageName =  $request->input('image_name');
        $city = City::findOrFail($id);
        if ($city->image_name != $imageName) {
            FileHelper::removeImageFile($city->image_name);
        }
        $city->name = $request->input('name');
        $city->image_name = $imageName;
        $city->update();
        FileHelper::moveCacheToImages($imageName);
        return redirect('cities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        FileHelper::removeImageFile($city->image_name);
        $city->delete();
        return redirect('cities');
    }
}
