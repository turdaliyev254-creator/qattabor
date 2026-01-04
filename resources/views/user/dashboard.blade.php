@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-8">
    <div class="container mx-auto px-4 max-w-7xl">
        <!-- Header -->
        <div class="mb-8">
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700/50 p-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-4">
                        @if($user->avatar)
                            <img src="{{ asset('public/storage/' . $user->avatar) }}" alt="{{ $user->name }}" 
                                 class="w-20 h-20 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-lg">
                        @else
                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('my_dashboard') }}</h1>
                            <p class="text-gray-600 dark:text-gray-400">{{ __('welcome_back') }}, {{ $user->name }}!</p>
                        </div>
                    </div>
                    <a href="{{ route('user.profile.edit') }}" 
                       class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full hover:shadow-xl transition-all duration-300 hover:scale-105 font-semibold">
                        {{ __('edit_profile') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Favorites -->
            <a href="{{ route('user.favorites') }}" 
               class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-6 hover:shadow-2xl transition-all duration-300 hover:scale-105 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">{{ __('favorites') }}</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $favoritesCount }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-red-500 to-pink-600 flex items-center justify-center text-white text-2xl group-hover:scale-110 transition-transform">
                        ❤️
                    </div>
                </div>
            </a>

            <!-- Reviews -->
            <a href="{{ route('user.reviews') }}" 
               class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-6 hover:shadow-2xl transition-all duration-300 hover:scale-105 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">{{ __('my_reviews') }}</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $reviewsCount }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-2xl group-hover:scale-110 transition-transform">
                        💬
                    </div>
                </div>
            </a>

            <!-- Recently Viewed -->
            <a href="{{ route('user.recently-viewed') }}" 
               class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-6 hover:shadow-2xl transition-all duration-300 hover:scale-105 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">{{ __('recently_viewed') }}</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $recentPlaces->count() }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center text-white text-2xl group-hover:scale-110 transition-transform">
                        👁️
                    </div>
                </div>
            </a>
        </div>

        <!-- Latest Favorites -->
        @if($latestFavorites->count() > 0)
        <div class="mb-8">
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('latest_favorites') }}</h2>
                    <a href="{{ route('user.favorites') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold">
                        {{ __('view_all') }} →
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($latestFavorites as $saved)
                        @php $place = $saved->place; @endphp
                        <a href="{{ route('places.show', $place->slug) }}" 
                           class="backdrop-blur-md bg-white/40 dark:bg-gray-700/40 rounded-2xl p-4 border border-white/30 dark:border-gray-600/30 hover:shadow-xl transition-all duration-300 hover:scale-105 group">
                            <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                {{ $place->name }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                {{ $place->category->name }} • {{ $place->location->name }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                                {{ __('saved') }} {{ $saved->created_at->diffForHumans() }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Recently Viewed -->
        @if($recentPlaces->count() > 0)
        <div>
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('recently_viewed') }}</h2>
                    <a href="{{ route('user.recently-viewed') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold">
                        {{ __('view_all') }} →
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recentPlaces as $place)
                        <a href="{{ route('places.show', $place->slug) }}" 
                           class="backdrop-blur-md bg-white/40 dark:bg-gray-700/40 rounded-2xl p-4 border border-white/30 dark:border-gray-600/30 hover:shadow-xl transition-all duration-300 hover:scale-105 group">
                            <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                {{ $place->name }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                {{ $place->category->name }} • {{ $place->location->name }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
