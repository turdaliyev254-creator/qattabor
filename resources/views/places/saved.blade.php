<x-glass-layout>
    <div class="mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 mb-2 hover:underline">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            {{ __('back') }}
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('saved_places') }}</h1>
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
                        
                        <!-- Saved Badge -->
                        <div class="absolute top-2 right-2 p-2 bg-white dark:bg-gray-800 rounded-full shadow-lg">
                            <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Place Info -->
                    <div class="p-3">
                        <h3 class="font-semibold text-base text-gray-900 dark:text-white mb-1 line-clamp-1">{{ $place->name }}</h3>
                        
                        @if($place->subcategory)
                            <p class="text-xs text-blue-600 dark:text-blue-400 mb-1">{{ $place->subcategory->name }}</p>
                        @endif
                        
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('no_saved_places') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">{{ __('start_saving_places') }}</p>
                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                    {{ __('explore_places') }}
                </a>
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
