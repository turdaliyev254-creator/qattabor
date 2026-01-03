<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Place;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'categories' => Category::count(),
            'subcategories' => Subcategory::count(),
            'places' => Place::count(),
            'users' => User::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Export all platform activity to CSV
     */
    public function exportActivity(Request $request)
    {
        // Get all places with relationships
        $places = Place::with(['category', 'location', 'owner'])->get();
        
        // Prepare CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="platform-activity-' . date('Y-m-d') . '.csv"',
        ];
        
        $callback = function() use ($places) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Header
            fputcsv($file, [
                'Place ID',
                'Place Name',
                'Category',
                'Location',
                'Owner ID',
                'Owner Name',
                'Owner Phone',
                'Total Views',
                'Phone Clicks',
                'Website Clicks',
                'Social Clicks',
                'Total Saves',
                'Total Comments',
                'Is Popular',
                'Is Featured',
                'Created Date'
            ]);
            
            // CSV Data
            foreach ($places as $place) {
                fputcsv($file, [
                    $place->id,
                    $place->name,
                    $place->category->name ?? 'N/A',
                    $place->location->name ?? 'N/A',
                    $place->owner_id ?? 'N/A',
                    $place->owner->name ?? 'N/A',
                    $place->owner->phone ?? 'N/A',
                    $place->views_count,
                    $place->phone_clicks,
                    $place->website_clicks,
                    $place->social_clicks,
                    $place->savedByUsers()->count(),
                    $place->comments()->count(),
                    $place->is_popular ? 'Yes' : 'No',
                    $place->is_featured ? 'Yes' : 'No',
                    $place->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}
