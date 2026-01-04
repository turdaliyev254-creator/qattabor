<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Comment;
use App\Models\SavedPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get favorites count
        $favoritesCount = SavedPlace::where('user_id', $user->id)->count();
        
        // Get reviews count
        $reviewsCount = Comment::where('user_id', $user->id)->count();
        
        // Get recently viewed places from session
        $recentlyViewed = session()->get('recently_viewed', []);
        $recentPlaces = Place::whereIn('id', array_slice($recentlyViewed, 0, 5))
            ->with(['category', 'location'])
            ->get();
        
        // Get latest favorites
        $latestFavorites = SavedPlace::where('user_id', $user->id)
            ->with(['place.category', 'place.location'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('user.dashboard', compact(
            'user',
            'favoritesCount',
            'reviewsCount',
            'recentPlaces',
            'latestFavorites'
        ));
    }
    
    public function favorites()
    {
        $user = Auth::user();
        
        $favorites = SavedPlace::where('user_id', $user->id)
            ->with(['place.category', 'place.location', 'place.subcategory'])
            ->latest()
            ->paginate(12);
        
        return view('user.favorites', compact('favorites'));
    }
    
    public function reviews()
    {
        $user = Auth::user();
        
        $reviews = Comment::where('user_id', $user->id)
            ->with(['place', 'parent'])
            ->latest()
            ->paginate(15);
        
        return view('user.reviews', compact('reviews'));
    }
    
    public function recentlyViewed()
    {
        $user = Auth::user();
        
        // Get recently viewed places from session
        $recentlyViewedIds = session()->get('recently_viewed', []);
        
        $places = Place::whereIn('id', $recentlyViewedIds)
            ->with(['category', 'location', 'subcategory'])
            ->get()
            ->sortBy(function($place) use ($recentlyViewedIds) {
                return array_search($place->id, $recentlyViewedIds);
            });
        
        return view('user.recently-viewed', compact('places'));
    }
}
