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
        
        // Get AI interpretation if Gemini API key is configured
        $aiInterpretation = null;
        if (config('services.gemini.api_key')) {
            $aiInterpretation = $this->getGeminiInterpretation($query, $searchResults);
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
     * Get interpretation from Google Gemini
     */
    private function getGeminiInterpretation($query, $searchResults)
    {
        try {
            $currentTime = now()->format('H:i');
            $currentDay = now()->format('l');
            
            // Detect query language
            $detectedLanguage = $this->detectLanguage($query);
            
            // Build detailed context about available places
            $placesContext = $searchResults['places']->take(10)->map(function($place) use ($currentTime) {
                $isOpen = $this->isPlaceOpen($place, $currentTime);
                return [
                    'name' => $place->name,
                    'category' => $place->category->name ?? 'Unknown',
                    'subcategory' => $place->subcategory->name ?? null,
                    'description' => substr($place->description ?? '', 0, 100),
                    'rating' => $place->rating ?? 0,
                    'is_popular' => $place->is_popular ?? false,
                    'location' => $place->location->name ?? 'Unknown',
                    'address' => $place->address ?? '',
                    'is_open' => $isOpen,
                    'working_hours' => $place->working_hours ?? 'Not specified'
                ];
            })->toArray();

            $categoriesContext = $searchResults['categories']->map(function($cat) {
                return [
                    'name' => $cat->name,
                    'places_count' => $cat->places_count ?? 0
                ];
            })->toArray();

            // Language-specific response instructions
            $languageInstructions = [
                'uzbek' => "CRITICAL: User wrote in UZBEK (Latin). You MUST respond ONLY in UZBEK LATIN script. Use Uzbek words like: tavsiya qilaman, yaxshi, ochiq, yopiq, reyting, mashhur, yaqin, uzoq, etc.",
                'russian' => "КРИТИЧЕСКИ ВАЖНО: Пользователь написал на РУССКОМ языке. Вы ДОЛЖНЫ отвечать ТОЛЬКО на РУССКОМ языке. Используйте русские слова: рекомендую, хороший, открыто, закрыто, рейтинг, популярный, близко, далеко и т.д.",
                'english' => "CRITICAL: User wrote in ENGLISH. You MUST respond ONLY in ENGLISH. Use words like: recommend, good, open, closed, rating, popular, nearby, far, etc."
            ];

            // Build the comprehensive AI prompt
            $systemPrompt = "You are an intelligent location-based search assistant for QattaBor, a local discovery platform.

Your task is to analyze the user's query and recommend the most relevant places.

## Context:
- Current time: {$currentTime} ({$currentDay})
- User query: \"{$query}\"
- Detected language: {$detectedLanguage}
- Available places: " . count($placesContext) . "
- Available categories: " . count($categoriesContext) . "

## LANGUAGE REQUIREMENT (MOST IMPORTANT):
{$languageInstructions[$detectedLanguage]}

## Your Responsibilities:

1. **Intent Understanding**: Understand user intent, even if indirect or conversational
   - \"I'm hungry\" / \"qornim ochdi\" / \"я голоден\" → food, cafes, restaurants
   - \"dorixona\" / \"apteka\" / \"аптека\" → pharmacies
   - \"bolam kasal\" / \"мой ребенок болен\" → clinics or pharmacies
   - \"coffee\" / \"kofe\" / \"кофе\" → cafes
   - \"tez ovqat\" / \"быстрая еда\" / \"fast food\" → fast food

2. **Time-Aware Filtering**: ONLY recommend places that are currently OPEN
   - If searching at late hours (e.g., 23:45), show only 24/7 or open places
   - If no places are open, politely say so and suggest alternatives

3. **Smart Ranking**: Consider rating, popularity, and relevance

4. **Response Style**: Be helpful, friendly, and concise (2-3 sentences max)

## Available Places Data:
" . json_encode($placesContext, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "

## Available Categories:
" . json_encode($categoriesContext, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "

## Instructions:
- Analyze the user's intent
- Recommend the MOST RELEVANT places (mention 1-3 by name)
- Explain WHY they're good matches
- Consider time, rating, and popularity
- Keep response under 3 sentences
- Use friendly, natural language
- **RESPOND IN THE SAME LANGUAGE AS THE USER'S QUERY: {$detectedLanguage}**

Provide your recommendation now in {$detectedLanguage}:";

            $response = Http::timeout(20)->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . config('services.gemini.api_key'),
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $systemPrompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.8,
                        'maxOutputTokens' => 250,
                        'topP' => 0.95,
                    ]
                ]
            );

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
            }
        } catch (\Exception $e) {
            \Log::error('Gemini AI Search Error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Detect the language of the user's query
     */
    private function detectLanguage($query)
    {
        // Check for Cyrillic characters (Russian)
        if (preg_match('/[\p{Cyrillic}]/u', $query)) {
            return 'russian';
        }
        
        // Check for common Uzbek words/patterns (Latin script)
        $uzbekWords = ['qornim', 'ochdi', 'yopiq', 'ochiq', 'dorixona', 'bolam', 'kasal', 'ovqat', 'tez', 'yaxshi', 'qaerda', 'qayerda', 'kerak', 'bormi'];
        foreach ($uzbekWords as $word) {
            if (stripos($query, $word) !== false) {
                return 'uzbek';
            }
        }
        
        // Check for Uzbek characters
        if (preg_match("/[oʻgʻ]/u", $query)) {
            return 'uzbek';
        }
        
        // Default to English
        return 'english';
    }

    /**
     * Check if a place is currently open
     */
    private function isPlaceOpen($place, $currentTime)
    {
        // Simple implementation - can be enhanced with actual working hours logic
        if (!$place->working_hours || $place->working_hours === '24/7') {
            return true;
        }
        
        // You can implement more sophisticated time checking here
        // For now, assume most places are open during business hours (8:00 - 22:00)
        $hour = (int) substr($currentTime, 0, 2);
        return $hour >= 8 && $hour < 22;
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
