# Location-Based Filtering Implementation Guide

This document contains all the code changes needed to implement mandatory location selection and location-based filtering.

## Files to Modify

### 1. HomeController.php
**File:** `app/Http/Controllers/HomeController.php`

Replace the entire `index` method with:

```php
public function index(Request $request)
{
    // Show all categories
    $categories = Category::withCount('subcategories')
        ->take(10)
        ->get();
    
    // Filter popular places by location if selected
    $popularPlacesQuery = Place::where('is_popular', true)->with(['category', 'location']);
    
    if ($request->has('location') && $request->location) {
        $location = Location::where('name', $request->location)->first();
        if ($location) {
            $popularPlacesQuery->where('location_id', $location->id);
        }
    }
    
    $popularPlaces = $popularPlacesQuery->take(6)->get();
    $locations = Location::all();
    $banners = Banner::active()->get();

    return view('welcome', compact('categories', 'popularPlaces', 'locations', 'banners'));
}
```

---

### 2. PlaceController.php
**File:** `app/Http/Controllers/PlaceController.php`

#### Update `byCategory` method (around line 28-46):

```php
public function byCategory(Request $request, Category $category)
{
    $subcategories = $category->subcategories()
        ->withCount('places')
        ->orderBy('name')
        ->get();
    
    $placesQuery = $category->places()->with(['subcategory', 'location']);
    
    // Filter by location if provided
    if ($request->has('location') && $request->location) {
        $location = Location::where('name', $request->location)->first();
        if ($location) {
            $placesQuery->where('location_id', $location->id);
        }
    }
    
    $places = $placesQuery->latest()->paginate(12);

    return view('places.by-category', compact('category', 'subcategories', 'places'));
}
```

#### Update `bySubcategory` method (around line 48-62):

```php
public function bySubcategory(Request $request, Category $category, Subcategory $subcategory)
{
    $placesQuery = $subcategory->places()->with(['category', 'location']);
    
    // Filter by location if provided
    if ($request->has('location') && $request->location) {
        $location = Location::where('name', $request->location)->first();
        if ($location) {
            $placesQuery->where('location_id', $location->id);
        }
    }
    
    $places = $placesQuery->latest()->paginate(12);

    return view('places.by-subcategory', compact('category', 'subcategory', 'places'));
}
```

#### Update `show` method to filter related places (around line 64-104):

```php
public function show(Request $request, Place $place)
{
    $place->load(['category', 'subcategory', 'location']);
    
    // Track recently viewed places in session
    $recentlyViewed = session()->get('recently_viewed', []);
    $recentlyViewed = array_diff($recentlyViewed, [$place->id]);
    array_unshift($recentlyViewed, $place->id);
    $recentlyViewed = array_slice($recentlyViewed, 0, 10);
    session()->put('recently_viewed', $recentlyViewed);
    
    // Get related places from same subcategory or category AND same location
    $relatedPlaces = Place::where('id', '!=', $place->id)
        ->where('location_id', $place->location_id)  // Filter by same location
        ->where(function($query) use ($place) {
            if ($place->subcategory_id) {
                $query->where('subcategory_id', $place->subcategory_id);
            } else {
                $query->where('category_id', $place->category_id);
            }
        })
        ->with(['category', 'subcategory', 'location'])
        ->limit(6)
        ->get();

    // Check if place is saved by current user
    $isSaved = auth()->check() && auth()->user()->savedPlaces()->where('place_id', $place->id)->exists();

    return view('places.show', compact('place', 'relatedPlaces', 'isSaved'));
}
```

---

### 3. SearchController.php
**File:** `app/Http/Controllers/SearchController.php`

#### Update `index` method (around line 16-28):

```php
public function index(Request $request)
{
    $query = $request->get('q', '');
    $location = $request->get('location', null);
    $results = [];
    $aiResponse = null;
    
    if ($query) {
        $results = $this->performSearch($query, $location);
    }

    return view('search.index', compact('query', 'results', 'aiResponse'));
}
```

#### Update `aiSearch` method (around line 33-56):

```php
public function aiSearch(Request $request)
{
    $request->validate([
        'query' => 'required|string|min:2',
    ]);

    $query = $request->input('query');
    $location = $request->input('location', null);
    
    // Perform basic search with location filter
    $searchResults = $this->performSearch($query, $location);
    
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
```

#### Update `performSearch` method (around line 63-100):

```php
private function performSearch($query, $locationFilter = null)
{
    $searchTerm = '%' . $query . '%';
    
    // Search places with relationships and location filter
    $placesQuery = Place::with(['category', 'subcategory', 'location'])
        ->where(function($q) use ($searchTerm) {
            $q->where('name', 'like', $searchTerm)
              ->orWhere('description', 'like', $searchTerm)
              ->orWhere('address', 'like', $searchTerm);
        });
    
    // Apply location filter if provided
    if ($locationFilter) {
        $location = Location::where('name', $locationFilter)->first();
        if ($location) {
            $placesQuery->where('location_id', $location->id);
        }
    }
    
    $places = $placesQuery->limit(20)->get();

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
```

#### Update `quickSearch` method (around line 272-304):

```php
public function quickSearch(Request $request)
{
    $query = $request->get('q', '');
    $location = $request->get('location', null);
    
    if (strlen($query) < 2) {
        return response()->json([]);
    }

    $searchTerm = '%' . $query . '%';
    
    $placesQuery = Place::select('id', 'name', 'slug', 'category_id', 'location_id', 'address')
        ->with(['category:id,name', 'location:id,name'])
        ->where(function($q) use ($searchTerm) {
            $q->where('name', 'like', $searchTerm)
              ->orWhere('description', 'like', $searchTerm)
              ->orWhere('address', 'like', $searchTerm);
        });
    
    // Apply location filter
    if ($location) {
        $locationModel = Location::where('name', $location)->first();
        if ($locationModel) {
            $placesQuery->where('location_id', $locationModel->id);
        }
    }
    
    $places = $placesQuery->limit(10)
        ->get()
        ->map(function($place) {
            return [
                'id' => $place->id,
                'name' => $place->name,
                'category' => $place->category->name ?? '',
                'location' => $place->location->name ?? '',
                'url' => route('places.show', $place->slug)
            ];
        });

    return response()->json($places);
}
```

---

### 4. glass.blade.php
**File:** `resources/views/layouts/glass.blade.php`

#### Add Location Modal (Insert after `<body>` tag, around line 19):

```html
<!-- Location Selection Modal -->
<div id="locationModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full p-8 transform transition-all">
        <div class="text-center mb-6">
            <div class="mx-auto w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Select Your Location') }}</h2>
            <p class="text-gray-600 dark:text-gray-400">{{ __('Choose your region to see relevant places near you') }}</p>
        </div>
        
        <div class="grid grid-cols-2 gap-3 max-h-96 overflow-y-auto">
            <button onclick="selectInitialLocation('Toshkent')" class="location-modal-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all text-left group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">To</div>
                    <span class="text-gray-900 dark:text-white font-medium group-hover:text-blue-600 dark:group-hover:text-blue-400">Toshkent</span>
                </div>
            </button>
            <button onclick="selectInitialLocation('Toshkent viloyati')" class="location-modal-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all text-left group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">TV</div>
                    <span class="text-gray-900 dark:text-white font-medium group-hover:text-blue-600 dark:group-hover:text-blue-400">Toshkent viloyati</span>
                </div>
            </button>
            <button onclick="selectInitialLocation('Fargona')" class="location-modal-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all text-left group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">Fa</div>
                    <span class="text-gray-900 dark:text-white font-medium group-hover:text-blue-600 dark:group-hover:text-blue-400">Farg'ona</span>
                </div>
            </button>
            <button onclick="selectInitialLocation('Qoqon')" class="location-modal-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all text-left group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">Qo</div>
                    <span class="text-gray-900 dark:text-white font-medium group-hover:text-blue-600 dark:group-hover:text-blue-400">Qo'qon</span>
                </div>
            </button>
            <button onclick="selectInitialLocation('Namangan')" class="location-modal-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all text-left group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">Na</div>
                    <span class="text-gray-900 dark:text-white font-medium group-hover:text-blue-600 dark:group-hover:text-blue-400">Namangan</span>
                </div>
            </button>
            <button onclick="selectInitialLocation('Samarqand')" class="location-modal-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all text-left group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">Sa</div>
                    <span class="text-gray-900 dark:text-white font-medium group-hover:text-blue-600 dark:group-hover:text-blue-400">Samarqand</span>
                </div>
            </button>
            <button onclick="selectInitialLocation('Buxoro')" class="location-modal-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all text-left group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">Bu</div>
                    <span class="text-gray-900 dark:text-white font-medium group-hover:text-blue-600 dark:group-hover:text-blue-400">Buxoro</span>
                </div>
            </button>
            <button onclick="selectInitialLocation('Andijon')" class="location-modal-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all text-left group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">An</div>
                    <span class="text-gray-900 dark:text-white font-medium group-hover:text-blue-600 dark:group-hover:text-blue-400">Andijon</span>
                </div>
            </button>
            <button onclick="selectInitialLocation('Navoi')" class="location-modal-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all text-left group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">Nv</div>
                    <span class="text-gray-900 dark:text-white font-medium group-hover:text-blue-600 dark:group-hover:text-blue-400">Navoi</span>
                </div>
            </button>
            <button onclick="selectInitialLocation('Xorazm')" class="location-modal-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all text-left group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">Xo</div>
                    <span class="text-gray-900 dark:text-white font-medium group-hover:text-blue-600 dark:group-hover:text-blue-400">Xorazm</span>
                </div>
            </button>
            <button onclick="selectInitialLocation('Surxondaryo')" class="location-modal-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all text-left group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">Su</div>
                    <span class="text-gray-900 dark:text-white font-medium group-hover:text-blue-600 dark:group-hover:text-blue-400">Surxondaryo</span>
                </div>
            </button>
            <button onclick="selectInitialLocation('Qashqadaryo')" class="location-modal-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all text-left group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">Qa</div>
                    <span class="text-gray-900 dark:text-white font-medium group-hover:text-blue-600 dark:group-hover:text-blue-400">Qashqadaryo</span>
                </div>
            </button>
            <button onclick="selectInitialLocation('Jizzax')" class="location-modal-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all text-left group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">Ji</div>
                    <span class="text-gray-900 dark:text-white font-medium group-hover:text-blue-600 dark:group-hover:text-blue-400">Jizzax</span>
                </div>
            </button>
        </div>
    </div>
</div>
```

#### Replace JavaScript (around line 400-560, find the existing location script and replace it):

```javascript
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if location has been selected before
        const hasSelectedLocation = sessionStorage.getItem('selectedLocation');
        const urlParams = new URLSearchParams(window.location.search);
        const locationParam = urlParams.get('location');
        
        // Show modal if no location selected and not on admin pages
        if (!hasSelectedLocation && !locationParam && !window.location.pathname.startsWith('/admin') && !window.location.pathname.startsWith('/dashboard')) {
            document.getElementById('locationModal').classList.remove('hidden');
        }
        
        // Restore selected location
        const currentLocation = locationParam || hasSelectedLocation || 'Toshkent';
        
        if (currentLocation) {
            const locationEl = document.getElementById('current-location');
            if (locationEl) {
                locationEl.textContent = currentLocation;
            }
            
            // Set active location button
            const locationButtons = document.querySelectorAll('.location-btn');
            locationButtons.forEach(btn => {
                const btnLocation = btn.getAttribute('data-location');
                if (btnLocation === currentLocation) {
                    btn.classList.remove('text-gray-700', 'dark:text-gray-300', 'bg-gray-100/80', 'dark:bg-gray-700/80', 'hover:bg-blue-50', 'hover:text-blue-600', 'dark:hover:bg-gray-600', 'dark:hover:text-blue-400', 'border-transparent', 'hover:border-blue-200', 'dark:hover:border-blue-800');
                    btn.classList.add('text-white', 'bg-gradient-to-br', 'from-blue-500', 'to-purple-600', 'shadow-lg', 'border-blue-400');
                    btn.style.fontWeight = '700';
                }
            });
            
            sessionStorage.setItem('selectedLocation', currentLocation);
            
            // Add location parameter to current URL if not present and not on admin pages
            if (!locationParam && !window.location.pathname.startsWith('/admin') && !window.location.pathname.startsWith('/dashboard')) {
                const newUrl = new URL(window.location);
                newUrl.searchParams.set('location', currentLocation);
                window.history.replaceState({}, '', newUrl);
            }
        }
        
        // Update search forms with location
        const searchForms = document.querySelectorAll('form[action*="search"]');
        searchForms.forEach(form => {
            let locationInput = form.querySelector('input[name="location"]');
            if (!locationInput) {
                locationInput = document.createElement('input');
                locationInput.type = 'hidden';
                locationInput.name = 'location';
                form.appendChild(locationInput);
            }
            locationInput.value = currentLocation;
        });
    });

    // Initial location selection from modal
    function selectInitialLocation(location) {
        sessionStorage.setItem('selectedLocation', location);
        document.getElementById('locationModal').classList.add('hidden');
        
        // Reload page with location parameter
        const newUrl = new URL(window.location);
        newUrl.searchParams.set('location', location);
        window.location.href = newUrl.toString();
    }

    // Change location from header
    function changeLocation(location) {
        sessionStorage.setItem('selectedLocation', location);
        
        // Update URL and reload
        const newUrl = new URL(window.location);
        newUrl.searchParams.set('location', location);
        window.location.href = newUrl.toString();
    }
</script>
```

---

## Testing Checklist

After implementing these changes, test the following:

- [ ] First-time visitor sees location selection modal
- [ ] Modal doesn't appear on admin pages
- [ ] Selecting a location from modal redirects with `?location=` parameter
- [ ] Homepage shows only places from selected location
- [ ] Category pages filter places by location
- [ ] Subcategory pages filter places by location
- [ ] Place detail page shows related places from same location only
- [ ] Search results are filtered by location
- [ ] Quick search (autocomplete) filters by location
- [ ] Saved places page shows ALL saved places (not filtered)
- [ ] Changing location from header updates the site-wide filter
- [ ] Location persists across page navigation
- [ ] URL always contains `?location=` parameter (except admin pages)

---

## Implementation Steps

1. Back up your current files
2. Apply changes to `HomeController.php`
3. Apply changes to `PlaceController.php`
4. Apply changes to `SearchController.php`
5. Apply changes to `glass.blade.php`
6. Clear Laravel cache: `php artisan cache:clear`
7. Clear view cache: `php artisan view:clear`
8. Test the application
9. Deploy to production

---

## Notes

- Saved places intentionally NOT filtered by location (personal list)
- Admin pages bypass location modal and filtering
- Location is stored in sessionStorage for persistence
- URL parameter takes precedence over sessionStorage
- Related places on detail page filtered by same location for better UX
