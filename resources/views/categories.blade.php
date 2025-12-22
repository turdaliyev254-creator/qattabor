<x-glass-layout>
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('home') }}" class="w-10 h-10 flex items-center justify-center card hover:bg-gray-100 dark:hover:bg-gray-800">
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('categories') }}</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Explore places by category</p>
                </div>
            </div>
            
            <!-- Search Bar -->
            <div class="relative max-w-xl">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" id="searchInput" placeholder="{{ __('search_placeholder') }}" class="input pl-12">
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4" id="categoriesGrid">
            @forelse($categories as $category)
                <a href="#" class="category-item group block" data-name="{{ strtolower($category->name) }}">
                    <div class="card card-hover p-5 text-center">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-xl bg-gradient-to-br from-brand-50 to-accent-50 dark:from-brand-900/20 dark:to-accent-900/20 flex items-center justify-center text-3xl">
                            {{ $category->icon ?? '📍' }}
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $category->name }}
                        </h3>
                    </div>
                </a>
            @empty
                <div class="col-span-2 md:col-span-5 text-center py-20">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">{{ __('no_categories_found') }}</p>
                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Try adjusting your search</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Search Script -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            document.querySelectorAll('.category-item').forEach(item => {
                const categoryName = item.getAttribute('data-name');
                item.style.display = categoryName.includes(searchTerm) ? 'block' : 'none';
            });
        });
    </script>
</x-glass-layout>
