<x-glass-layout>
    <div class="mb-6">
        <a href="{{ route('places.by-category', $category->slug) }}{{ request('region') ? '?region=' . urlencode(request('region')) : '' }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 mb-2 hover:underline">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            {{ __('back_to_category') }}
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ __($subcategory->name) }}</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __($category->name) }}</p>
    </div>

    <!-- Brand Filter Section -->
    @if($brands->isNotEmpty())
        <!-- Desktop: Horizontal Scrollable -->
        <div class="hidden md:block mb-8">
            <div class="flex overflow-x-auto gap-4 pb-4 scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600">
                <!-- All Places Button -->
                <button onclick="filterByBrand('')" 
                        class="brand-filter-btn flex-shrink-0 group relative">
                    <div class="flex flex-col items-center gap-2 px-6 py-4 rounded-2xl transition-all duration-300 {{ !$selectedBrand ? 'bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/50' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 shadow-md hover:shadow-xl hover:scale-[1.02] hover:-translate-y-1' }}">
                        <div class="w-12 h-12 flex items-center justify-center rounded-xl {{ !$selectedBrand ? 'bg-white/20' : 'bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-sm">{{ __('All Places') }}</span>
                    </div>
                </button>
                
                <!-- Brand Buttons -->
                @foreach($brands as $brand)
                    <button onclick="filterByBrand('{{ $brand->slug }}')" 
                            class="brand-filter-btn flex-shrink-0 group relative">
                        <div class="flex flex-col items-center gap-2 px-6 py-4 rounded-2xl transition-all duration-300 {{ $selectedBrand && $selectedBrand->id === $brand->id ? 'bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/50' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 shadow-md hover:shadow-xl hover:scale-[1.02] hover:-translate-y-1' }}">
                            @if($brand->icon)
                                <div class="w-12 h-12 flex items-center justify-center rounded-xl {{ $selectedBrand && $selectedBrand->id === $brand->id ? 'bg-white/20' : 'bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600' }} p-2">
                                    <img src="{{ asset('images/brands/' . $brand->icon) }}" alt="{{ $brand->localized_name }}" class="w-full h-full object-contain">
                                </div>
                            @else
                                <div class="w-12 h-12 flex items-center justify-center rounded-xl {{ $selectedBrand && $selectedBrand->id === $brand->id ? 'bg-white/20' : 'bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600' }}">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                    </svg>
                                </div>
                            @endif
                            <span class="font-semibold text-sm text-center">{{ $brand->localized_name }}</span>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Mobile: Horizontal Scrollable Chips -->
        <div class="md:hidden mb-6">
            <div class="flex overflow-x-auto gap-3 pb-2 scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600 -mx-4 px-4">
                <!-- All Places Button -->
                <button onclick="filterByBrand('')" 
                        class="brand-filter-btn flex-shrink-0"
                        title="{{ __('All Places') }}">
                    <div class="w-16 h-16 flex items-center justify-center rounded-full transition-all duration-300 {{ !$selectedBrand ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-md' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 shadow-sm border border-gray-200 dark:border-gray-700 active:scale-95' }}">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </div>
                </button>
                
                <!-- Brand Buttons -->
                @foreach($brands as $brand)
                    <button onclick="filterByBrand('{{ $brand->slug }}')" 
                            class="brand-filter-btn flex-shrink-0"
                            title="{{ $brand->localized_name }}">
                        <div class="w-16 h-16 flex items-center justify-center rounded-full transition-all duration-300 {{ $selectedBrand && $selectedBrand->id === $brand->id ? 'bg-gradient-to-r from-indigo-500 to-purple-600 shadow-md' : 'bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 active:scale-95' }} p-2.5">
                            @if($brand->icon)
                                <img src="{{ asset('images/brands/' . $brand->icon) }}" alt="{{ $brand->localized_name }}" class="w-full h-full object-contain">
                            @else
                                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                                </svg>
                            @endif
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Places Container -->
    <div id="places-container">
        @include('places.partials.places-grid', ['places' => $places])
    </div>

    <script>
        function filterByBrand(brandSlug) {
            const container = document.getElementById('places-container');
            const currentRegion = '{{ request("region") }}';
            
            // Show loading state
            container.classList.add('opacity-50', 'pointer-events-none');
            
            // Build URL
            let url = '{{ route("places.ajax-filter", [$category->slug, $subcategory->slug]) }}';
            const params = new URLSearchParams();
            
            if (brandSlug) {
                params.append('brand', brandSlug);
            }
            if (currentRegion) {
                params.append('region', currentRegion);
            }
            
            if (params.toString()) {
                url += '?' + params.toString();
            }
            
            // Fetch filtered places
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Update container
                    container.innerHTML = data.html;
                    container.classList.remove('opacity-50', 'pointer-events-none');
                    
                    // Update browser URL with state data
                    const newUrl = new URL(window.location);
                    if (brandSlug) {
                        newUrl.searchParams.set('brand', brandSlug);
                    } else {
                        newUrl.searchParams.delete('brand');
                    }
                    window.history.pushState({ brand: brandSlug }, '', newUrl);
                })
                .catch(error => {
                    console.error('Error filtering places:', error);
                    container.classList.remove('opacity-50', 'pointer-events-none');
                    alert('{{ __("Failed to load places. Please try again.") }}');
                });
        }
        
        // Handle browser back/forward navigation
        window.addEventListener('popstate', function(event) {
            // Get brand from URL query parameters
            const urlParams = new URLSearchParams(window.location.search);
            const brandSlug = urlParams.get('brand') || '';
            
            // Reload content when user navigates back/forward
            filterByBrand(brandSlug);
        });
        
        // Set initial state on page load
        window.history.replaceState({ brand: '{{ request("brand", "") }}' }, '', window.location.href);
    </script>
</x-glass-layout>
