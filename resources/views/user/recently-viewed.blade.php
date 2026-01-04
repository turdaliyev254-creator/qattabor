@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-8">
    <div class="container mx-auto px-4 max-w-7xl">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:underline mb-4">
                ← {{ __('back_to_dashboard') }}
            </a>
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700/50 p-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('recently_viewed') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $places->count() }} {{ __('places') }}</p>
            </div>
        </div>

        @if($places->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($places as $place)
                <a href="{{ route('places.show', $place->slug) }}" 
                   class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-6 hover:shadow-2xl transition-all duration-300 hover:scale-105 group">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors mb-3">
                        {{ $place->name }}
                    </h3>
                    
                    @if($place->subcategory)
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                        {{ $place->category->name }} → {{ $place->subcategory->name }}
                    </p>
                    @else
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                        {{ $place->category->name }}
                    </p>
                    @endif
                    
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                        📍 {{ $place->location->name }}
                    </p>
                    
                    @if($place->address)
                    <p class="text-sm text-gray-500 dark:text-gray-500">
                        {{ Str::limit($place->address, 60) }}
                    </p>
                    @endif
                    
                    @if($place->views_count > 0)
                    <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                        <span class="text-xs text-gray-500 dark:text-gray-500">👁️ {{ $place->views_count }} {{ __('views') }}</span>
                    </div>
                    @endif
                </a>
            @endforeach
        </div>
        @else
        <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-12 text-center">
            <div class="text-6xl mb-4">👁️</div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('no_recently_viewed') }}</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('places_you_visit_will_appear_here') }}</p>
            <a href="{{ route('home') }}" 
               class="inline-block px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full hover:shadow-xl transition-all duration-300 hover:scale-105 font-semibold">
                {{ __('explore_places') }}
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
