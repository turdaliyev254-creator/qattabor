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
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('my_reviews') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $reviews->total() }} {{ __('comments') }}</p>
            </div>
        </div>

        @if($reviews->count() > 0)
        <div class="space-y-6">
            @foreach($reviews as $review)
                <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-6 hover:shadow-2xl transition-all duration-300">
                    <!-- Comment Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <a href="{{ route('places.show', $review->place->slug) }}" 
                               class="text-lg font-bold text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                {{ $review->place->name }}
                            </a>
                            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">
                                {{ $review->created_at->format('d M Y, H:i') }} • {{ $review->created_at->diffForHumans() }}
                            </p>
                        </div>
                        
                        @if($review->status === 'pending')
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full text-xs font-semibold">
                            {{ __('pending_approval') }}
                        </span>
                        @elseif($review->status === 'approved')
                        <span class="px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-full text-xs font-semibold">
                            {{ __('approved') }}
                        </span>
                        @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 rounded-full text-xs font-semibold">
                            {{ __('rejected') }}
                        </span>
                        @endif
                    </div>

                    <!-- Comment Content -->
                    <div class="backdrop-blur-md bg-white/40 dark:bg-gray-700/40 rounded-2xl p-4 border border-white/30 dark:border-gray-600/30">
                        @if($review->parent)
                        <div class="mb-3 pb-3 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-500 mb-1">{{ __('replying_to') }}:</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 italic">
                                "{{ Str::limit($review->parent->comment, 80) }}"
                            </p>
                        </div>
                        @endif
                        
                        <p class="text-gray-900 dark:text-white">{{ $review->comment }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $reviews->links() }}
        </div>
        @else
        <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-12 text-center">
            <div class="text-6xl mb-4">💬</div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('no_reviews_yet') }}</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('share_your_experience_by_leaving_reviews') }}</p>
            <a href="{{ route('home') }}" 
               class="inline-block px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full hover:shadow-xl transition-all duration-300 hover:scale-105 font-semibold">
                {{ __('explore_places') }}
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
