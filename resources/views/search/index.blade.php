@extends('layouts.glass')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <!-- Header Section -->
    <div class="max-w-4xl mx-auto mb-12 text-center">
        <div class="relative inline-flex items-center justify-center mb-6">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 rounded-3xl blur-2xl opacity-20"></div>
            <div class="relative w-20 h-20 rounded-3xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-2xl">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
        <h1 class="text-4xl sm:text-5xl font-black mb-4">
            <span class="bg-gradient-to-r from-gray-900 via-blue-600 to-purple-600 dark:from-white dark:via-blue-400 dark:to-purple-400 bg-clip-text text-transparent">
                {{ __('AI-Powered Search') }}
            </span>
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
            {{ __('Find places, categories, and locations using natural language. Our AI understands what you\'re looking for.') }}
        </p>
    </div>

    <!-- Search Box -->
    <div class="max-w-4xl mx-auto mb-12">
        <form action="{{ route('search.index') }}" method="GET" class="relative" x-data="{
            searchQuery: '{{ $query }}',
            suggestions: [],
            aiSearching: false,
            aiResponse: null,
            suggestionTimeout: null,
            showAiModal: false,
            aiQuery: ''
        }">
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <div class="relative flex items-center bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="pl-6">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ $query }}"
                        x-model="searchQuery"
                        @input.debounce.300ms="
                            if (searchQuery.length >= 2) {
                                fetch('{{ route('search.autocomplete') }}?q=' + encodeURIComponent(searchQuery))
                                    .then(response => response.json())
                                    .then(data => { suggestions = data; })
                                    .catch(error => console.error('Error:', error));
                            } else {
                                suggestions = [];
                            }
                        "
                        placeholder="{{ __('Search for restaurants, cafes, parks, hotels...') }}"
                        class="flex-1 px-4 py-5 text-lg bg-transparent border-none focus:ring-0 focus:outline-none text-gray-900 dark:text-white placeholder-gray-400"
                        autocomplete="off"
                    >
                    <button 
                        type="submit"
                        class="m-2 px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-2xl transition-all transform hover:scale-105 shadow-lg"
                    >
                        {{ __('Search') }}
                    </button>
                </div>

                <!-- Autocomplete Suggestions -->
                <div 
                    x-show="suggestions.length > 0 && searchQuery.length > 1" 
                    x-transition
                    @click.away="suggestions = []"
                    class="absolute w-full mt-2 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden z-50"
                >
                    <template x-for="suggestion in suggestions" :key="suggestion.id">
                        <a 
                            :href="suggestion.url"
                            class="flex items-center gap-3 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors border-b border-gray-100 dark:border-gray-700 last:border-0"
                        >
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center flex-shrink-0">
                                <svg x-show="suggestion.type === 'place'" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <svg x-show="suggestion.type === 'category'" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900 dark:text-white truncate" x-text="suggestion.name"></p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate" x-text="suggestion.category || suggestion.type"></p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </template>
                </div>
            </div>

            <!-- AI Search Button -->
            <div class="flex justify-center mt-6">
                <button 
                    type="button"
                    @click="showAiModal = true; aiQuery = ''; aiResponse = null;"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white font-semibold rounded-2xl transition-all shadow-lg transform hover:scale-105"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>{{ __('Ask AI Assistant') }}</span>
                </button>
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
                                            alert('{{ __('Please enter at least 2 characters') }}');
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
                                                aiResponse = '{{ __('AI assistant is currently unavailable. Please try the regular search.') }}';
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            aiSearching = false;
                                            aiResponse = '{{ __('Sorry, there was an error processing your request.') }}';
                                        });
                                    "
                                    :disabled="aiSearching || aiQuery.length < 2"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white font-semibold rounded-2xl transition-all shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <svg class="w-5 h-5" :class="{ 'animate-spin': aiSearching }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <span x-text="aiSearching ? '{{ __('AI Thinking...') }}' : '{{ __('Search with AI') }}'"></span>
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

            <!-- AI Response -->
            <div x-show="aiResponse" x-transition class="mt-6 p-6 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-2xl border border-purple-200 dark:border-purple-800">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-purple-900 dark:text-purple-300 mb-1">{{ __('AI Assistant') }}</p>
                        <p class="text-gray-700 dark:text-gray-300" x-text="aiResponse"></p>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if($query)
        <!-- Results Section -->
        <div class="max-w-6xl mx-auto">
            <!-- Results Summary -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('Search Results') }} 
                    <span class="text-gray-500 dark:text-gray-400 font-normal">
                        {{ __('for') }} "{{ $query }}"
                    </span>
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('Found') }} 
                    {{ $results['places']->count() + $results['categories']->count() + $results['subcategories']->count() + $results['locations']->count() }} 
                    {{ __('results') }}
                </p>
            </div>

            <!-- Places Results -->
            @if($results['places']->count() > 0)
                <div class="mb-12">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-500 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        {{ __('Places') }} ({{ $results['places']->count() }})
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($results['places'] as $place)
                            <a href="{{ route('places.show', $place->slug) }}" class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all transform hover:-translate-y-1">
                                <div class="aspect-video bg-gradient-to-br from-blue-500 to-purple-600 relative">
                                    @if($place->image_url)
                                        <img src="{{ $place->image_url }}" alt="{{ $place->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-16 h-16 text-white/50" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @endif
                                    @if($place->is_popular)
                                        <div class="absolute top-3 right-3 px-3 py-1 bg-yellow-400 text-yellow-900 text-xs font-bold rounded-full">
                                            ⭐ {{ __('Popular') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <h4 class="font-bold text-lg text-gray-900 dark:text-white mb-2 line-clamp-1">{{ $place->name }}</h4>
                                    @if($place->description)
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">{{ $place->description }}</p>
                                    @endif
                                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg">{{ $place->category->name }}</span>
                                        @if($place->location)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ $place->location->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Categories Results -->
            @if($results['categories']->count() > 0)
                <div class="mb-12">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-purple-500 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                            </svg>
                        </div>
                        {{ __('Categories') }} ({{ $results['categories']->count() }})
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($results['categories'] as $category)
                            <a href="{{ route('places.by-category', $category->slug) }}" class="group p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all transform hover:-translate-y-1 text-center">
                                <div class="text-4xl mb-3">{{ $category->icon }}</div>
                                <h4 class="font-bold text-gray-900 dark:text-white mb-1">{{ $category->name }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $category->places_count }} {{ __('places') }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Subcategories Results -->
            @if($results['subcategories']->count() > 0)
                <div class="mb-12">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-pink-500 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                        </div>
                        {{ __('Subcategories') }} ({{ $results['subcategories']->count() }})
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($results['subcategories'] as $subcategory)
                            <a href="{{ route('places.by-subcategory', [$subcategory->category->slug, $subcategory->slug]) }}" class="group p-5 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all transform hover:-translate-y-1">
                                <div class="flex items-center gap-3 mb-2">
                                    @if($subcategory->icon)
                                        <span class="text-2xl">{{ $subcategory->icon }}</span>
                                    @endif
                                    <h4 class="font-bold text-gray-900 dark:text-white flex-1">{{ $subcategory->name }}</h4>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $subcategory->category->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $subcategory->places_count }} {{ __('places') }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- No Results -->
            @if($results['places']->count() == 0 && $results['categories']->count() == 0 && $results['subcategories']->count() == 0 && $results['locations']->count() == 0)
                <div class="text-center py-16">
                    <div class="w-24 h-24 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('No results found') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('Try searching with different keywords or use the AI assistant for better results.') }}</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-2xl hover:shadow-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        {{ __('Go to Home') }}
                    </a>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
