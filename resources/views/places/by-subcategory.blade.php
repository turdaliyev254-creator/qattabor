<x-glass-layout>
    <div class="mb-6">
        <a href="{{ route('places.by-category', $category->slug) }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 mb-2 hover:underline">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            {{ __('back_to_category') }}
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ __($subcategory->name) }}</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __($category->name) }}</p>
    </div>

    <!-- Places Grid -->
    <div class="grid grid-cols-2 gap-4">
        @forelse($places as $place)
            <a href="{{ route('places.show', $place->slug) }}" class="block">
                <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all">
                    <!-- Place Image -->
                    <div class="relative h-40 overflow-hidden bg-gray-200 dark:bg-gray-700">
                        @if($place->image_url)
                            <img src="{{ $place->image_url }}" 
                                 alt="{{ $place->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-purple-600">
                                <svg class="w-16 h-16 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @endif
                        
                        @if($place->is_popular)
                            <div class="absolute top-2 left-2 px-2 py-1 bg-red-500 rounded-lg text-white text-xs font-semibold">
                                {{ __('popular') }}
                            </div>
                        @endif
                    </div>
                    
                    <!-- Place Info -->
                    <div class="p-3">
                        <h3 class="font-semibold text-base text-gray-900 dark:text-white mb-1 line-clamp-1">{{ $place->name }}</h3>
                        
                        @if($place->location)
                            <div class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 mb-2">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $place->location->name }}</span>
                            </div>
                        @endif
                        
                        @if($place->description)
                            <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2">{{ $place->description }}</p>
                        @endif
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
</x-glass-layout>
