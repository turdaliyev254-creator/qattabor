<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        
        // Check if user has owned places
        if (!$user->isOwner()) {
            abort(403, 'You do not own any places.');
        }

        // Get all owned places with statistics
        $ownedPlaces = $user->ownedPlaces()->with(['category', 'location', 'comments'])->get();
        
        // Calculate total statistics
        $stats = [
            'total_places' => $ownedPlaces->count(),
            'total_views' => $ownedPlaces->sum('views_count'),
            'total_phone_clicks' => $ownedPlaces->sum('phone_clicks'),
            'total_website_clicks' => $ownedPlaces->sum('website_clicks'),
            'total_social_clicks' => $ownedPlaces->sum('social_clicks'),
            'total_saves' => $ownedPlaces->sum(fn($place) => $place->savedByUsers()->count()),
            'total_comments' => $ownedPlaces->sum(fn($place) => $place->comments()->count()),
            'pending_comments' => $ownedPlaces->sum(fn($place) => $place->comments()->where('is_approved', false)->count()),
        ];

        // Get recent comments on owned places
        $recentComments = \App\Models\Comment::whereIn('place_id', $ownedPlaces->pluck('id'))
            ->with(['user', 'place'])
            ->latest()
            ->take(10)
            ->get();

        return view('owner.dashboard', compact('ownedPlaces', 'stats', 'recentComments'));
    }

    /**
     * Export monitor activity to CSV
     */
    public function exportActivity(Request $request)
    {
        $user = auth()->user();
        
        // Check if user has owned places
        if (!$user->isOwner()) {
            abort(403, 'You do not own any places.');
        }

        // Get all owned places with statistics
        $ownedPlaces = $user->ownedPlaces()->with(['category', 'location'])->get();
        
        // Prepare CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="monitor-activity-' . date('Y-m-d') . '.csv"',
        ];
        
        $callback = function() use ($ownedPlaces) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Header
            fputcsv($file, [
                'Place ID',
                'Place Name',
                'Category',
                'Location',
                'Total Views',
                'Phone Clicks',
                'Website Clicks',
                'Social Clicks',
                'Total Saves',
                'Total Comments',
                'Created Date'
            ]);
            
            // CSV Data
            foreach ($ownedPlaces as $place) {
                fputcsv($file, [
                    $place->id,
                    $place->name,
                    $place->category->name ?? 'N/A',
                    $place->location->name ?? 'N/A',
                    $place->views_count,
                    $place->phone_clicks,
                    $place->website_clicks,
                    $place->social_clicks,
                    $place->savedByUsers()->count(),
                    $place->comments()->count(),
                    $place->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}
