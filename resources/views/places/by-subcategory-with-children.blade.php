<x-glass-layout>
    <div class="mb-6">
        <a href="{{ route('places.by-category', $category->slug) }}{{ request('region') ? '?region=' . urlencode(request('region')) : '' }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 mb-2 hover:underline">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            {{ __('back_to_category') }}
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $subcategory->localized_name }}</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $category->localized_name }}</p>
    </div>

    <!-- Sub-Subcategories Section -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">{{ __('subcategories') }}</h2>
        
        <!-- Grid Layout Sub-Subcategories -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
            @foreach($subSubcategories as $subSubcategory)
                <a href="{{ route('places.by-subcategory', [$category->slug, $subSubcategory->slug]) }}{{ request('region') ? '?region=' . urlencode(request('region')) : '' }}" 
                   class="flex flex-col items-center gap-2 cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="w-14 h-14 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                        @if($subSubcategory->icon)
                            @if(Str::endsWith($subSubcategory->icon, '.png'))
                                <img src="{{ asset('size-512/images/' . $subSubcategory->icon) }}" 
                                     alt="{{ $subSubcategory->localized_name }}" 
                                     class="w-full h-full object-contain">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 rounded-xl flex items-center justify-center text-white text-2xl">
                                    {{ $subSubcategory->icon }}
                                </div>
                            @endif
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 rounded-xl flex items-center justify-center text-white text-xl font-bold">
                                {{ substr($subSubcategory->localized_name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 text-center line-clamp-2">{{ $subSubcategory->localized_name }}</span>
                    <div class="inline-flex items-center justify-center px-2 py-0.5 bg-blue-50 dark:bg-blue-900/30 rounded-full">
                        <span class="text-xs font-medium text-blue-600 dark:text-blue-400">{{ $subSubcategory->places_count }} {{ __('places') }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-glass-layout>
