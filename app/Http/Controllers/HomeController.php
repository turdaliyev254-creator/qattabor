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
        // Show only categories that have subcategories
        $categories = Category::has('subcategories')
            ->withCount('subcategories')
            ->take(10)
            ->get();
        
        $popularPlaces = Place::where('is_popular', true)->with(['category', 'location'])->take(6)->get();
        $locations = Location::all();

        return view('welcome', compact('categories', 'popularPlaces', 'locations'));
    }

    public function allCategories()
    {
        // Show only categories that have subcategories
        $categories = Category::has('subcategories')
            ->withCount('subcategories')
            ->get();
        
        return view('categories', compact('categories'));
    }
}
