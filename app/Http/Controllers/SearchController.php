<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    /**
     * Display the search page
     */
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $results = [];
        $aiResponse = null;
        
        if ($query) {
            $results = $this->performSearch($query);
        }

        return view('search.index', compact('query', 'results', 'aiResponse'));
    }

    /**
     * Perform AI-powered search
     */
    public function aiSearch(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2',
        ]);

        $query = $request->input('query');
        
        // Perform basic search
        $searchResults = $this->performSearch($query);
        
        // Get AI interpretation if API key is configured
        $aiInterpretation = null;
        if (config('services.openai.api_key') || config('services.gemini.api_key')) {
            $aiInterpretation = $this->getAiInterpretation($query, $searchResults);
        }

        return response()->json([
            'success' => true,
            'query' => $query,
            'results' => $searchResults,
            'ai_interpretation' => $aiInterpretation,
            'total_results' => count($searchResults['places']) + count($searchResults['categories'])
        ]);
    }

    /**
     * Perform intelligent search across places, categories, and subcategories
     */
    private function performSearch($query)
    {
        $searchTerm = '%' . $query . '%';
        
        // Search places with relationships
        $places = Place::with(['category', 'subcategory', 'location'])
            ->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm)
                  ->orWhere('address', 'like', $searchTerm);
            })
            ->limit(20)
            ->get();

        // Search categories
        $categories = Category::where('name', 'like', $searchTerm)
            ->withCount('places')
            ->limit(10)
            ->get();

        // Search subcategories
        $subcategories = Subcategory::with('category')
            ->where('name', 'like', $searchTerm)
            ->withCount('places')
            ->limit(10)
            ->get();

        // Search locations
        $locations = Location::where('name', 'like', $searchTerm)
            ->withCount('places')
            ->limit(5)
            ->get();

        return [
            'places' => $places,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'locations' => $locations,
        ];
    }

    /**
     * Get AI interpretation of search query and results
     */
    private function getAiInterpretation($query, $searchResults)
    {
        try {
            // Try Gemini first (better quota)
            if (config('services.gemini.api_key')) {
                return $this->getGeminiInterpretation($query, $searchResults);
            }
            
            // Fallback to OpenAI
            if (config('services.openai.api_key')) {
                return $this->getOpenAiInterpretation($query, $searchResults);
            }
        } catch (\Exception $e) {
            \Log::error('AI Search Error: ' . $e->getMessage());
            return null;
        }

        return null;
    }

    /**
     * Get interpretation from OpenAI
     */
    private function getOpenAiInterpretation($query, $searchResults)
    {
        $placesContext = $searchResults['places']->take(5)->map(function($place) {
            return "{$place->name} ({$place->category->name})";
        })->implode(', ');

        $categoriesContext = $searchResults['categories']->map(function($cat) {
            return "{$cat->name} ({$cat->places_count} places)";
        })->implode(', ');

        $prompt = "User is searching for: '{$query}'. ";
        if ($placesContext) {
            $prompt .= "Top results: {$placesContext}. ";
        }
        if ($categoriesContext) {
            $prompt .= "Related categories: {$categoriesContext}. ";
        }
        $prompt .= "Provide a brief, helpful response (max 2 sentences) about what the user is looking for and suggest the best match.";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.openai.api_key'),
            'Content-Type' => 'application/json',
        ])->timeout(10)->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant for a local places discovery app. Be concise and friendly.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'max_tokens' => 100,
            'temperature' => 0.7,
        ]);

        if ($response->successful()) {
            return $response->json()['choices'][0]['message']['content'];
        }

        return null;
    }

    /**
     * Get interpretation from Google Gemini
     */
    private function getGeminiInterpretation($query, $searchResults)
    {
        $placesContext = $searchResults['places']->take(5)->map(function($place) {
            return "{$place->name} ({$place->category->name})";
        })->implode(', ');

        $categoriesContext = $searchResults['categories']->map(function($cat) {
            return "{$cat->name} ({$cat->places_count} places)";
        })->implode(', ');

        $prompt = "User is searching for: '{$query}'. ";
        if ($placesContext) {
            $prompt .= "Top results: {$placesContext}. ";
        }
        if ($categoriesContext) {
            $prompt .= "Related categories: {$categoriesContext}. ";
        }
        $prompt .= "Provide a brief, helpful response (max 2 sentences) about what the user is looking for and suggest the best match.";

        $response = Http::timeout(15)->post(
            'https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash-lite:generateContent?key=' . config('services.gemini.api_key'),
            [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 100,
                ]
            ]
        );

        if ($response->successful()) {
            $data = $response->json();
            return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
        }

        return null;
    }

    /**
     * Quick search for places (used in homepage search)
     */
    public function quickSearch(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $searchTerm = '%' . $query . '%';
        
        $places = Place::select('id', 'name', 'slug', 'category_id', 'address')
            ->with('category:id,name')
            ->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm)
                  ->orWhere('address', 'like', $searchTerm);
            })
            ->limit(10)
            ->get()
            ->map(function($place) {
                return [
                    'id' => $place->id,
                    'name' => $place->name,
                    'category' => $place->category->name ?? '',
                    'url' => route('places.show', $place->slug)
                ];
            });

        return response()->json($places);
    }

    /**
     * Quick search for autocomplete
     */
    public function autocomplete(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $searchTerm = '%' . $query . '%';
        
        $places = Place::select('id', 'name', 'slug', 'category_id')
            ->with('category:id,name')
            ->where('name', 'like', $searchTerm)
            ->limit(8)
            ->get()
            ->map(function($place) {
                return [
                    'id' => $place->id,
                    'name' => $place->name,
                    'type' => 'place',
                    'category' => $place->category->name ?? '',
                    'url' => route('places.show', $place->slug)
                ];
            });

        $categories = Category::select('id', 'name', 'slug')
            ->where('name', 'like', $searchTerm)
            ->limit(5)
            ->get()
            ->map(function($cat) {
                return [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'type' => 'category',
                    'url' => route('places.by-category', $cat->slug)
                ];
            });

        return response()->json($places->concat($categories));
    }
}
