<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($places as $place)
        <a href="{{ route('places.show', $place->slug) }}{{ request('region') ? '?region=' . urlencode(request('region')) : '' }}" class="block group">
            <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-[1.02] hover:-translate-y-1">
                <!-- Place Image -->
                <div class="relative h-48 overflow-hidden bg-gradient-to-br from-blue-500 to-purple-600">
                    @if($place->image_url)
                        <img src="{{ $place->image_url }}" 
                             alt="{{ $place->name }}" 
                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-20 h-20 text-white opacity-40" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Brand Badge (Top Right) -->
                    @if($place->brand_id && $place->brand)
                        <div class="absolute top-3 right-3 w-10 h-10 rounded-xl bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm shadow-lg p-1.5 flex items-center justify-center">
                            @if($place->brand->icon)
                                <img src="{{ asset('images/brands/' . $place->brand->icon) }}" 
                                     alt="{{ $place->brand->localized_name }}" 
                                     class="w-full h-full object-contain"
                                     title="{{ $place->brand->localized_name }}">
                            @else
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                                </svg>
                            @endif
                        </div>
                    @endif
                    
                    <!-- Popular Badge (Top Left) -->
                    @if($place->is_popular)
                        <div class="absolute top-3 left-3 px-3 py-1.5 bg-red-500/90 backdrop-blur-sm rounded-full text-white text-xs font-bold shadow-lg">
                            {{ __('popular') }}
                        </div>
                    @endif
                    
                    <!-- Glassmorphism Overlay -->
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent p-4">
                        <h3 class="font-bold text-lg text-white mb-1 line-clamp-1 drop-shadow-lg">{{ $place->name }}</h3>
                        @if($place->location)
                            <div class="flex items-center gap-1.5 text-white/90">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm font-medium drop-shadow">{{ $place->location->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Place Info -->
                <div class="p-4">
                    @if($place->description)
                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-3">{{ $place->description }}</p>
                    @endif
                    
                    <!-- Rating -->
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @if(isset($place->reviews_count) && $place->reviews_count > 0)
                                <span class="font-bold text-gray-900 dark:text-white">{{ number_format($place->average_rating, 1) }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">({{ $place->reviews_count }})</span>
                            @else
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('No reviews yet') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @empty
        <div class="col-span-full text-center py-16">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('no_places_found') }}</h3>
            <p class="text-gray-600 dark:text-gray-400">{{ __('no_places_in_subcategory') }}</p>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($places->hasPages())
    <div class="mt-8">
        {{ $places->links() }}
    </div>
@endif
