<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $topList = DB::table('property_likes')
            ->join('properties', 'property_likes.property_id', '=', 'properties.id')
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->where('properties.user_id', Auth::user()->id)
            ->groupBy('property_likes.property_id')
            ->select(DB::raw('count(*) as count, properties.title as propert_title, cities.name as city_name'))
            ->orderByRaw('count DESC')
            ->take(10)
            ->get();
        return view('dashboard.index')->with('topList', $topList);
    }
}
