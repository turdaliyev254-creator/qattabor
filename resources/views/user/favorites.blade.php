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
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('my_favorites') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $favorites->total() }} {{ __('places') }}</p>
            </div>
        </div>

        @if($favorites->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($favorites as $saved)
                @php $place = $saved->place; @endphp
                <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:scale-105 group">
                    <a href="{{ route('places.show', $place->slug) }}" class="block">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    {{ $place->name }}
                                </h3>
                                <form action="{{ route('places.unsave', $place) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-500 hover:text-red-700 text-2xl transition-colors"
                                            onclick="return confirm('{{ __('remove_from_favorites') }}?')">
                                        ❤️
                                    </button>
                                </form>
                            </div>
                            
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
                            <p class="text-sm text-gray-500 dark:text-gray-500 mb-3">
                                {{ Str::limit($place->address, 60) }}
                            </p>
                            @endif
                            
                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-500 pt-3 border-t border-gray-200 dark:border-gray-700">
                                <span>{{ __('saved') }} {{ $saved->created_at->diffForHumans() }}</span>
                                @if($place->views_count > 0)
                                <span>👁️ {{ $place->views_count }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $favorites->links() }}
        </div>
        @else
        <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-12 text-center">
            <div class="text-6xl mb-4">💔</div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('no_favorites_yet') }}</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('start_exploring_and_save_your_favorite_places') }}</p>
            <a href="{{ route('home') }}" 
               class="inline-block px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full hover:shadow-xl transition-all duration-300 hover:scale-105 font-semibold">
                {{ __('explore_places') }}
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
