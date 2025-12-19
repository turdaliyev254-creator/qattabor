<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Place;
use App\Models\Location;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $popularPlaces = Place::where('is_popular', true)->with(['category', 'location'])->take(6)->get();
        $locations = Location::all();

        return view('welcome', compact('categories', 'popularPlaces', 'locations'));
    }
}
