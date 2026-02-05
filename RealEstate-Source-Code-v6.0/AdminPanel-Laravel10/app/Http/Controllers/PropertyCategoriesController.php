<?php

namespace App\Http\Controllers;

use App\Models\PropertyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyCategoriesController extends Controller
{
    public $validationRules = [
        'name' => 'required',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $propertyCategories = PropertyCategory::all();
        return view('property_categories.index')->with('propertyCategories', $propertyCategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('property_categories.create');
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
        $propertyCategory = new PropertyCategory;
        $propertyCategory->name = $request->input('name');
        $propertyCategory->save();
        return redirect('property_categories');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $propertyCategory = PropertyCategory::findOrFail($id);
        return view('property_categories.edit')->with('propertyCategory', $propertyCategory);
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
        $propertyCategory = PropertyCategory::findOrFail($id);
        $propertyCategory->name = $request->input('name');
        $propertyCategory->update();
        return redirect('property_categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $propertyCategory = PropertyCategory::findOrFail($id);
        $propertyCategory->delete();
        return redirect('property_categories');
    }
}
