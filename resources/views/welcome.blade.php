<x-glass-layout>
    <!-- Search Bar with Beautiful Glass Design -->
    <div class="mb-6 relative" x-data="{
        showAiModal: false,
        aiQuery: '',
        aiSearching: false,
        aiResponse: null,
        searchQuery: '',
        searchResults: [],
        showResults: false,
        searching: false,
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
                        class="flex-shrink-0 mr-1.5 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-xl transition-all shadow-lg shadow-blue-500/50 dark:shadow-blue-900/50 transform hover:scale-105 group"
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
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
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
            class="fixed inset-0 z-50 overflow-y-auto" 
            style="display: none;"
            @click.self="showAiModal = false"
        >
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>
            
            <!-- Modal Content -->
            <div class="flex items-center justify-center min-h-screen p-4">
                <div 
                    x-show="showAiModal"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-2xl w-full mx-auto"
                    @click.stop
                >
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('AI Assistant') }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Ask me anything about places') }}</p>
                            </div>
                        </div>
                        <button 
                            @click="showAiModal = false"
                            class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors"
                        >
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6">
                        <!-- Input Area -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('What are you looking for?') }}
                            </label>
                            <textarea
                                x-model="aiQuery"
                                rows="4"
                                placeholder="{{ __('Example: Find me a good restaurant for family dinner, Show me parks with playgrounds, I need a hotel near downtown...') }}"
                                class="w-full px-4 py-3 text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-2xl focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                                @keydown.escape="showAiModal = false"
                            ></textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <button
                                @click="
                                    if (aiQuery.length < 2) {
                                        alert({{ json_encode(__('Please enter at least 2 characters')) }});
                                        return;
                                    }
                                    aiSearching = true;
                                    aiResponse = null;
                                    fetch('{{ route('search.ai') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                        },
                                        body: JSON.stringify({ query: aiQuery })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        aiSearching = false;
                                        if (data.success && data.ai_interpretation) {
                                            aiResponse = data.ai_interpretation;
                                        } else {
                                            aiResponse = {{ json_encode(__('AI assistant is currently unavailable. Please try the regular search.')) }};
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        aiSearching = false;
                                        aiResponse = {{ json_encode(__('Sorry, there was an error processing your request.')) }};
                                    });
                                "
                                :disabled="aiSearching || aiQuery.length < 2"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white font-semibold rounded-2xl transition-all shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <svg class="w-5 h-5" :class="{ 'animate-spin': aiSearching }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span x-text="aiSearching ? {{ json_encode(__('AI Thinking...')) }} : {{ json_encode(__('Search with AI')) }}"></span>
                            </button>
                            <button
                                @click="showAiModal = false"
                                class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-2xl transition-all"
                            >
                                {{ __('Cancel') }}
                            </button>
                        </div>

                        <!-- AI Response -->
                        <div 
                            x-show="aiResponse" 
                            x-transition
                            class="mt-6 p-5 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-2xl border border-purple-200 dark:border-purple-800"
                        >
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-purple-900 dark:text-purple-300 mb-2">{{ __('AI Recommendation') }}</p>
                                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed" x-text="aiResponse"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Banner Carousel -->
    <div class="relative mb-8 -mx-4" x-data="{ 
        currentSlide: 0,
        slides: [
            {
                image: 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80'
            },
            {
                image: 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80'
            },
            {
                image: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80'
            }
        ],
        autoplay: null,
        init() {
            this.autoplay = setInterval(() => {
                this.currentSlide = (this.currentSlide + 1) % this.slides.length;
            }, 3000);
        }
    }">
        <div class="relative overflow-hidden">
            <div class="flex transition-transform duration-500 ease-out"
                 :style="`transform: translateX(-${currentSlide * 90}%)`">
                <template x-for="(slide, index) in slides" :key="index">
                    <div class="flex-shrink-0 w-[90%] px-2">
                        <div class="relative h-48 rounded-3xl overflow-hidden shadow-lg cursor-pointer">
                            <img :src="slide.image" 
                                 alt="Banner" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        
        <!-- Carousel dots -->
        <div class="flex justify-center gap-1.5 mt-4">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="currentSlide = index" 
                        class="h-1.5 rounded-full transition-all duration-300"
                        :class="currentSlide === index ? 'bg-blue-600 w-8' : 'bg-gray-300 dark:bg-gray-600 w-1.5'">
                </button>
            </template>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('categories') }}</h2>
            <a href="{{ route('categories.all') }}" class="px-4 py-2 backdrop-blur-md bg-white/40 dark:bg-black/20 hover:bg-white/60 dark:hover:bg-black/30 rounded-full text-sm font-semibold text-gray-700 dark:text-gray-300 border border-white/30 dark:border-white/10 transition-all hover:scale-105 shadow-sm">{{ __('all') }}</a>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-5 gap-4">
            @foreach($categories as $category)
            <a href="{{ route('places.by-category', $category->slug) }}" class="relative">
                <div class="flex flex-col items-center gap-2 w-full cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="w-16 h-16 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                        @if($category->icon)
                            @if(Str::endsWith($category->icon, '.png'))
                                <img src="{{ asset('size-512/images/' . $category->icon) }}" alt="{{ $category->name }}" class="w-full h-full object-contain">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-4xl">
                                    {{ $category->icon }}
                                </div>
                            @endif
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 rounded-2xl flex items-center justify-center text-white text-2xl font-bold">
                                {{ substr($category->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">{{ __($category->name) }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Popular Places Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('popular_places_title') }}</h2>
            <a href="{{ route('places.popular') }}" class="px-4 py-2 backdrop-blur-md bg-white/40 dark:bg-black/20 hover:bg-white/60 dark:hover:bg-black/30 rounded-full text-sm font-semibold text-gray-700 dark:text-gray-300 border border-white/30 dark:border-white/10 transition-all hover:scale-105 shadow-sm">{{ __('all') }}</a>
        </div>

        <!-- Horizontal Scrollable Cards -->
        <div class="overflow-x-auto scrollbar-hide -mx-4 px-4">
            <div class="flex gap-4 pb-2">
                @forelse($popularPlaces ?? [] as $place)
                <a href="{{ route('places.show', $place->slug) }}" class="flex-shrink-0 w-56">
                    <div class="backdrop-blur-xl bg-white/40 dark:bg-black/20 rounded-2xl overflow-hidden border border-white/30 dark:border-white/10 shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                        <!-- Place Image -->
                        <div class="relative h-32 overflow-hidden">
                            @if($place->image)
                            <img src="{{ asset('storage/' . $place->image) }}" 
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
                        <div class="p-3">
                            <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-2 line-clamp-1">{{ $place->name }}</h3>
                            <div class="flex items-center gap-1.5 text-xs text-gray-600 dark:text-gray-300 mb-2">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="line-clamp-1">{{ $place->location->name ?? __('tashkent') }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="font-bold text-sm text-gray-900 dark:text-white">4.8</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">(120)</span>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <!-- Sample Places -->
                @for($i = 1; $i <= 6; $i++)
                <a href="#" class="flex-shrink-0 w-56">
                    <div class="backdrop-blur-xl bg-white/40 dark:bg-black/20 rounded-2xl overflow-hidden border border-white/30 dark:border-white/10 shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                        <!-- Place Image -->
                        <div class="relative h-32 overflow-hidden bg-gradient-to-br from-blue-{{ 400 + ($i % 3) * 100 }} via-purple-{{ 400 + ($i % 2) * 100 }} to-pink-{{ 500 + ($i % 3) * 100 }}">
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-14 h-14 text-white opacity-40" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        </div>
                        
                        <!-- Place Info -->
                        <div class="p-3">
                            <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-2 line-clamp-1">{{ __('sample_place') }} {{ $i }}</h3>
                            <div class="flex items-center gap-1.5 text-xs text-gray-600 dark:text-gray-300 mb-2">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="line-clamp-1">{{ __('tashkent') }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="font-bold text-sm text-gray-900 dark:text-white">4.{{ 5 + ($i % 4) }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">({{ 50 + ($i * 15) }})</span>
                            </div>
                        </div>
                    </div>
                </a>
                @endfor
                @endforelse
            </div>
        </div>
    </div>
</x-glass-layout>
