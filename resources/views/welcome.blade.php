<x-glass-layout>
    <!-- Page Transition Wrapper -->
    <div class="page-transition">
    <!-- Banners Section -->
    @if(isset($banners) && $banners->count() > 0)
    <div class="mb-8 fade-in-up" x-data="{
        currentIndex: 0,
        autoScroll: true,
        bannerCount: {{ $banners->count() }},
        init() {
            this.$nextTick(() => {
                // Auto-scroll to next banner every 3 seconds
                setInterval(() => {
                    if (this.autoScroll) {
                        this.nextBanner();
                    }
                }, 3000);
            });
        },
        nextBanner() {
            this.currentIndex = (this.currentIndex + 1) % this.bannerCount;
            this.scrollToIndex(this.currentIndex);
        },
        scrollToIndex(index) {
            const container = this.$refs.bannerContainer;
            const cardWidth = container.offsetWidth;
            container.scrollTo({
                left: index * (cardWidth + 16), // 16px is gap-4
                behavior: 'smooth'
            });
        },
        handleScroll() {
            const container = this.$refs.bannerContainer;
            const cardWidth = container.offsetWidth;
            const scrolled = container.scrollLeft;
            this.currentIndex = Math.round(scrolled / (cardWidth + 16));
        },
        pauseScroll() {
            this.autoScroll = false;
        },
        resumeScroll() {
            this.autoScroll = true;
        }
    }">
        <!-- Banner Cards Container -->
        <div 
            x-ref="bannerContainer"
            @scroll.debounce.100ms="handleScroll()"
            @mouseenter="pauseScroll()"
            @mouseleave="resumeScroll()"
            @touchstart="pauseScroll()"
            @touchend="setTimeout(() => resumeScroll(), 2000)"
            class="flex gap-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory pb-1"
        >
            @foreach($banners as $index => $banner)
            <div class="flex-shrink-0 w-full snap-start">
                <div class="relative overflow-hidden rounded-3xl backdrop-blur-xl bg-white/10 dark:bg-black/10 border border-white/20 dark:border-white/5 h-48 md:h-56 lg:h-72 transform transition-all duration-300 hover:scale-[1.02] hover:border-white/30 dark:hover:border-white/10">
                    @if($banner->link)
                    <a href="{{ $banner->link }}" target="_blank" rel="noopener noreferrer" class="block w-full h-full group">
                        <img src="{{ asset('storage/' . $banner->image) }}" 
                             alt="{{ $banner->title }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                    @else
                    <img src="{{ asset('storage/' . $banner->image) }}" 
                         alt="{{ $banner->title }}" 
                         class="w-full h-full object-cover">
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Dots Indicator - Below Banner Cards -->
        @if($banners->count() > 1)
        <div class="flex justify-center gap-2 mt-4">
            @foreach($banners as $index => $banner)
            <button 
                @click="scrollToIndex({{ $index }}); currentIndex = {{ $index }}; autoScroll = false; setTimeout(() => autoScroll = true, 5000)"
                class="h-2 rounded-full transition-all duration-300 hover:bg-blue-600 dark:hover:bg-blue-400"
                :class="currentIndex === {{ $index }} ? 'bg-blue-600 dark:bg-blue-400 w-8' : 'bg-gray-300 dark:bg-gray-600 w-2'">
            </button>
            @endforeach
        </div>
        @endif
    </div>
    @endif

    <!-- Search Bar with Beautiful Glass Design -->
    <div class="mb-6 relative fade-in-down" x-data="{
        showAiModal: false,
        aiQuery: '',
        aiSearching: false,
        aiResponse: null,
        searchQuery: '',
        searchResults: [],
        showResults: false,
        searching: false,
        init() {
            this.$watch('showAiModal', value => {
                if (value) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });
        },
        performSearch() {
            if (this.searchQuery.trim().length > 0) {
                this.searching = true;
                this.showResults = true;
                fetch('/search-places?q=' + encodeURIComponent(this.searchQuery))
                    .then(response => response.json())
                    .then(data => {
                        this.searchResults = data;
                        this.searching = false;
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        this.searching = false;
                    });
            }
        },
        clearSearch() {
            this.searchQuery = '';
            this.searchResults = [];
            this.showResults = false;
        }
    }" @click.away="showResults = false">
        <!-- Floating background gradient elements -->
        <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl blur-md opacity-20 group-hover:opacity-30 transition-opacity"></div>
        
        <div class="relative backdrop-blur-xl bg-white/40 dark:bg-black/30 rounded-2xl border border-white/50 dark:border-white/10 shadow-xl overflow-hidden">
            <!-- Animated gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 via-purple-500/10 to-pink-500/10 animate-pulse"></div>
            
            <form @submit.prevent="performSearch" class="relative p-1.5">
                <div class="flex items-center gap-2">
                    <!-- Search Icon with glass background -->
                    <label for="main-search" class="flex-shrink-0 pl-2 cursor-pointer">
                        <div class="w-10 h-10 rounded-xl backdrop-blur-md bg-gradient-to-br from-blue-500/20 to-purple-500/20 dark:from-blue-600/30 dark:to-purple-600/30 flex items-center justify-center border border-white/30 dark:border-white/10 shadow-md">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </label>
                    
                    <!-- Search Input -->
                    <input
                        type="text"
                        id="main-search"
                        name="search"
                        x-model="searchQuery"
                        @input="if (searchQuery.length > 1) performSearch()"
                        @focus="if (searchQuery.length > 1) showResults = true"
                        placeholder="{{ __('search_what') }}"
                        class="flex-1 py-3 px-2 bg-transparent border-none text-gray-700 dark:text-gray-300 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-0 text-base font-medium"
                        aria-label="{{ __('search_what') }}"
                        autocomplete="off"
                    />
                    
                    <!-- AI Search Button -->
                    <button 
                        type="button"
                        @click="showAiModal = true; aiQuery = ''; aiResponse = null;"
                        class="flex-shrink-0 mr-1.5 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-xl btn-hover ripple shadow-lg shadow-blue-500/50 dark:shadow-blue-900/50 group"
                    >
                        <svg class="w-5 h-5 text-white group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Search Results Dropdown -->
        <div 
            x-show="showResults && searchQuery.length > 0" 
            x-transition
            class="absolute top-full mt-2 w-full bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 max-h-96 overflow-y-auto z-50"
        >
            <div x-show="searching" class="p-4 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <p class="mt-2 text-gray-600 dark:text-gray-400">{{ __('Searching...') }}</p>
            </div>
            
            <div x-show="!searching && searchResults.length === 0" class="p-6 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="mt-4 text-gray-600 dark:text-gray-400">{{ __('No results found') }}</p>
            </div>
            
            <div x-show="!searching && searchResults.length > 0" class="py-2">
                <template x-for="result in searchResults" :key="result.id">
                    <a :href="result.url" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0">
                                <template x-if="result.image_url">
                                    <img :src="'/storage/' + result.image_url" :alt="result.name" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!result.image_url">
                                    <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                </template>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-900 dark:text-white truncate" x-text="result.name"></h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate" x-text="result.category"></p>
                            </div>
                        </div>
                    </a>
                </template>
            </div>
        </div>

        <!-- AI Modal Window -->
        <div 
            x-show="showAiModal" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[200] overflow-y-auto flex items-center justify-center p-4" 
            style="display: none;"
            @click.self="showAiModal = false"
        >
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
            
            <!-- Modal Content -->
            <div 
                x-show="showAiModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative z-10 bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-2xl max-h-[85vh] overflow-y-auto"
                @click.stop
            >
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('AI Assistant') }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Ask me anything') }}</p>
                            </div>
                        </div>
                        <button 
                            @click="showAiModal = false"
                            class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                        >
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-4">
                    <!-- Input Area -->
                    <div class="mb-3">
                        <textarea
                            x-model="aiQuery"
                            rows="3"
                            placeholder="{{ __('Example: qornim ochdi, dorixona kerak, mehmonxona...') }}"
                            class="w-full px-4 py-2.5 text-base text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                            @keydown.escape="showAiModal = false"
                        ></textarea>
                    </div>

                    <!-- Action Button -->
                    <div class="mb-4">
                        <button
                            @click="
                                if (aiQuery.length < 2) {
                                    alert({{ json_encode(__('Please enter at least 2 characters')) }});
                                    return;
                                }
                                aiSearching = true;
                                aiResponse = null;
                                
                                // Get current location from session
                                const selectedLocation = sessionStorage.getItem('selectedLocation') || 'Toshkent';
                                
                                fetch('{{ route('search.ai') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                    },
                                    body: JSON.stringify({ 
                                        query: aiQuery,
                                        region: selectedLocation
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    aiSearching = false;
                                    if (data.success) {
                                        aiResponse = data;
                                        // Scroll to response after a short delay
                                        setTimeout(() => {
                                            const responseEl = document.querySelector('[x-show=aiResponse]');
                                            if (responseEl) {
                                                responseEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                                            }
                                        }, 100);
                                    } else {
                                        aiResponse = { ai_interpretation: {{ json_encode(__('AI assistant is currently unavailable.')) }} };
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    aiSearching = false;
                                    aiResponse = { ai_interpretation: {{ json_encode(__('Sorry, there was an error.')) }} };
                                });
                            "
                            :disabled="aiSearching || aiQuery.length < 2"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white text-sm font-semibold rounded-xl transition-all shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <svg class="w-4 h-4" :class="{ 'animate-spin': aiSearching }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span x-text="aiSearching ? {{ json_encode(__('Thinking...')) }} : {{ json_encode(__('Search with AI')) }}"></span>
                        </button>
                    </div>

                    <!-- AI Response -->
                    <div x-show="aiResponse" x-transition class="space-y-3">
                        <!-- AI Text Response -->
                        <div 
                            x-show="aiResponse?.ai_interpretation"
                            class="p-4 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl border border-purple-200 dark:border-purple-800"
                        >
                            <div class="flex items-start gap-2">
                                <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-semibold text-purple-900 dark:text-purple-300 mb-1">{{ __('AI Recommendation') }}</p>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed" x-text="aiResponse?.ai_interpretation"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Recommended Places -->
                        <div x-show="aiResponse?.results?.places?.length > 0">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ __('Recommended Places') }}
                            </h4>
                            <div class="space-y-2 max-h-60 overflow-y-auto">
                                <template x-for="place in aiResponse?.results?.places.slice(0, 5)" :key="place.id">
                                    <a :href="'/places/' + place.slug" 
                                       class="block p-3 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 rounded-xl border border-gray-200 dark:border-gray-600 transition-all hover:shadow-md">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1 min-w-0">
                                                <h5 class="text-sm font-semibold text-gray-900 dark:text-white truncate" x-text="place.name"></h5>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate" x-text="place.category?.name || ''"></p>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span x-show="place.rating" class="flex items-center gap-1 text-xs text-yellow-600">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                        <span x-text="place.rating"></span>
                                                    </span>
                                                    <span x-show="place.is_popular" class="px-2 py-0.5 bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 text-xs font-medium rounded">
                                                        {{ __('Popular') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ __('categories') }}</h2>
            <a href="{{ route('categories.all') }}" class="px-3 py-1.5 md:px-4 md:py-2 backdrop-blur-md bg-white/40 dark:bg-black/20 hover:bg-white/60 dark:hover:bg-black/30 rounded-full text-xs md:text-sm font-semibold text-gray-700 dark:text-gray-300 border border-white/30 dark:border-white/10 btn-hover shadow-sm">{{ __('all') }}</a>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-4 gap-3 md:gap-4">
            @foreach($categories as $category)
            <a href="{{ route('places.by-category', $category->slug) }}{{ request('region') ? '?region=' . urlencode(request('region')) : '' }}" class="relative stagger-item">
                <div class="flex flex-col items-center gap-1.5 md:gap-2 w-full cursor-pointer transition-all duration-300 hover:scale-110 ripple">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                        @if($category->icon)
                            @if(Str::endsWith($category->icon, '.png'))
                                <img src="{{ asset('size-512/images/' . $category->icon) }}" alt="{{ $category->localized_name }}" class="w-full h-full object-contain">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-3xl sm:text-4xl">
                                    {{ $category->icon }}
                                </div>
                            @endif
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 rounded-2xl flex items-center justify-center text-white text-xl sm:text-2xl font-bold">
                                {{ substr($category->localized_name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <span class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 text-center leading-tight">{{ $category->localized_name }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Popular Places Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ __('popular_places_title') }}</h2>
            <a href="{{ route('places.popular') }}" class="px-3 py-1.5 md:px-4 md:py-2 backdrop-blur-md bg-white/40 dark:bg-black/20 hover:bg-white/60 dark:hover:bg-black/30 rounded-full text-xs md:text-sm font-semibold text-gray-700 dark:text-gray-300 border border-white/30 dark:border-white/10 btn-hover shadow-sm">{{ __('all') }}</a>
        </div>

        <!-- Horizontal Scrollable Cards -->
        <div class="overflow-x-auto scrollbar-hide -mx-4 px-4">
            <div class="flex gap-3 md:gap-4 pb-2">
                @forelse($popularPlaces ?? [] as $place)
                <a href="{{ route('places.show', $place->slug) }}" class="flex-shrink-0 w-48 sm:w-56 fade-in">
                    <div class="backdrop-blur-xl bg-white/40 dark:bg-black/20 rounded-2xl overflow-hidden border border-white/30 dark:border-white/10 shadow-lg card-hover">
                        <!-- Place Image -->
                        <div class="relative h-28 sm:h-32 overflow-hidden">
                            @if($place->image_url)
                            <img src="{{ asset('storage/' . $place->image_url) }}" 
                                 alt="{{ $place->name }}" 
                                 class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500">
                                <svg class="w-14 h-14 text-white opacity-40" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        </div>
                        
                        <!-- Place Info -->
                        <div class="p-2.5 sm:p-3">
                            <h3 class="font-bold text-xs sm:text-sm text-gray-900 dark:text-white mb-1.5 sm:mb-2 line-clamp-1">{{ $place->name }}</h3>
                            <div class="flex items-center gap-1 sm:gap-1.5 text-[10px] sm:text-xs text-gray-600 dark:text-gray-300 mb-1.5 sm:mb-2">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="line-clamp-1">{{ $place->location->name ?? __('tashkent') }}</span>
                            </div>
                            <div class="flex items-center gap-0.5 sm:gap-1">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @if($place->reviews_count > 0)
                                    <span class="font-bold text-xs sm:text-sm text-gray-900 dark:text-white">{{ number_format($place->average_rating, 1) }}</span>
                                    <span class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">({{ $place->reviews_count }})</span>
                                @else
                                    <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ __('No reviews yet') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <p class="text-gray-600 dark:text-gray-400">{{ __('No popular places found.') }}</p>
                @endforelse
            </div>
        </div>
    </div>
    </div>
</x-glass-layout>
