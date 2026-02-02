<x-glass-layout>
    <div class="mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2 backdrop-blur-md bg-white/40 dark:bg-black/20 hover:bg-white/60 dark:hover:bg-black/30 rounded-full text-sm font-semibold text-gray-700 dark:text-gray-300 border border-white/30 dark:border-white/10 transition-all hover:scale-105 shadow-sm mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            {{ __('back') }}
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $category->localized_name }}</h1>
    </div>

    <!-- Subcategories Section -->
    @if($subcategories->count() > 0)
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">{{ __('subcategories') }}</h2>
            
            <!-- Grid Layout Subcategories -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                @foreach($subcategories as $subcategory)
                    <a href="{{ route('places.by-subcategory', [$category->slug, $subcategory->slug]) }}{{ request('region') ? '?region=' . urlencode(request('region')) : '' }}" 
                       class="flex flex-col items-center gap-2 cursor-pointer hover:opacity-80 transition-opacity">
                        <div class="w-14 h-14 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                            @if($subcategory->icon)
                                @if(Str::endsWith($subcategory->icon, '.png'))
                                    <img src="{{ asset('size-512/images/' . $subcategory->icon) }}" 
                                         alt="{{ $subcategory->localized_name }}" 
                                         class="w-full h-full object-contain">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 rounded-xl flex items-center justify-center text-white text-2xl">
                                        {{ $subcategory->icon }}
                                    </div>
                                @endif
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 rounded-xl flex items-center justify-center text-white text-xl font-bold">
                                    {{ substr($subcategory->localized_name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 text-center line-clamp-2">{{ $subcategory->localized_name }}</span>
                        <div class="inline-flex items-center justify-center px-2 py-0.5 bg-blue-50 dark:bg-blue-900/30 rounded-full">
                            <span class="text-xs font-medium text-blue-600 dark:text-blue-400">{{ $subcategory->places_count }} {{ __('places') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- All Places in Category -->
    <div>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('all_places') }}</h2>
        <div class="grid grid-cols-2 gap-4">
            @forelse($places as $place)
                <a href="{{ route('places.show', $place->slug) }}{{ request('region') ? '?region=' . urlencode(request('region')) : '' }}" class="block">
                    <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all">
                        <!-- Place Image -->
                        <div class="relative h-40 overflow-hidden bg-gray-200 dark:bg-gray-700">
                            @if($place->image_url)
                                <img src="{{ $place->image_url }}" 
                                     alt="{{ $place->localized_name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-purple-600">
                                    <svg class="w-16 h-16 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Place Info -->
                        <div class="p-3">
                            <h3 class="font-semibold text-base text-gray-900 dark:text-white mb-1 line-clamp-1">{{ $place->localized_name }}</h3>
                            
                            @if($place->subcategory)
                                <p class="text-xs text-blue-600 dark:text-blue-400 mb-1">{{ $place->subcategory->localized_name }}</p>
                            @endif
                            
                            @if($place->location)
                                <div class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 mb-2">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $place->location->name }}</span>
                                </div>
                            @endif
                            
                            <!-- Rating -->
                            <div class="flex items-center gap-1 mt-2">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @if(isset($place->reviews_count) && $place->reviews_count > 0)
                                    <span class="font-semibold text-sm text-gray-900 dark:text-white">{{ number_format($place->average_rating, 1) }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">({{ $place->reviews_count }})</span>
                                @else
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('No reviews yet') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-2 text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('no_places_found') }}</h3>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($places->hasPages())
            <div class="mt-8">
                {{ $places->links() }}
            </div>
        @endif
    </div>
</x-glass-layout>
