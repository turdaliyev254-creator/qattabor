<x-glass-layout>
    <div class="mb-8 flex items-start justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Place Owner Dashboard') }}</h1>
            <p class="text-gray-600 dark:text-gray-400">{{ __('Manage your places and view statistics') }}</p>
        </div>
        <a href="{{ route('owner.export-activity') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            {{ __('Export Activity') }}
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="backdrop-blur-xl bg-white/60 dark:bg-black/30 rounded-2xl border border-white/50 dark:border-white/10 shadow-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $stats['total_places'] }}</div>
            <div class="text-sm text-gray-600 dark:text-gray-400">Total Places</div>
        </div>

        <div class="backdrop-blur-xl bg-white/60 dark:bg-black/30 rounded-2xl border border-white/50 dark:border-white/10 shadow-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ number_format($stats['total_views']) }}</div>
            <div class="text-sm text-gray-600 dark:text-gray-400">Total Views</div>
        </div>

        <div class="backdrop-blur-xl bg-white/60 dark:bg-black/30 rounded-2xl border border-white/50 dark:border-white/10 shadow-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $stats['total_saves'] }}</div>
            <div class="text-sm text-gray-600 dark:text-gray-400">Total Saves</div>
        </div>

        <div class="backdrop-blur-xl bg-white/60 dark:bg-black/30 rounded-2xl border border-white/50 dark:border-white/10 shadow-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $stats['total_comments'] }}</div>
            <div class="text-sm text-gray-600 dark:text-gray-400">Total Comments</div>
        </div>
    </div>

    <!-- Clicks Breakdown -->
    <div class="backdrop-blur-xl bg-white/60 dark:bg-black/30 rounded-2xl border border-white/50 dark:border-white/10 shadow-xl p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Clicks Breakdown</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_phone_clicks']) }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Phone Clicks</div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_website_clicks']) }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Website Clicks</div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_social_clicks']) }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Social Clicks</div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Places -->
    <div class="backdrop-blur-xl bg-white/60 dark:bg-black/30 rounded-2xl border border-white/50 dark:border-white/10 shadow-xl p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">My Places</h2>
        <div class="space-y-4">
            @foreach($ownedPlaces as $place)
                <div class="backdrop-blur-md bg-white/40 dark:bg-black/20 rounded-xl border border-white/30 dark:border-white/10 p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $place->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $place->category->name }} • {{ $place->location->name }}</p>
                            
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                                <div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Views</div>
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($place->views_count) }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Comments</div>
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $place->comments->count() }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Saves</div>
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $place->savedByUsers()->count() }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Phone Clicks</div>
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($place->phone_clicks) }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Website Clicks</div>
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($place->website_clicks) }}</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('places.show', $place->slug) }}" class="ml-4 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm transition-colors">
                            View Place
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Comments -->
    <div class="backdrop-blur-xl bg-white/60 dark:bg-black/30 rounded-2xl border border-white/50 dark:border-white/10 shadow-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Recent Comments</h2>
            @if($stats['pending_comments'] > 0)
                <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 rounded-full text-sm font-semibold">
                    {{ $stats['pending_comments'] }} Pending Admin Approval
                </span>
            @endif
        </div>
        
        @if($recentComments->count() > 0)
            <div class="space-y-4">
                @foreach($recentComments as $comment)
                    <div class="backdrop-blur-md bg-white/40 dark:bg-black/20 rounded-xl border border-white/30 dark:border-white/10 p-4">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">•</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">On: <a href="{{ route('places.show', $comment->place->slug) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ $comment->place->name }}</a></p>
                                <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
                            </div>
                            <span class="ml-4 px-3 py-1 rounded-full text-xs font-semibold {{ $comment->is_approved ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' }}">
                                {{ $comment->is_approved ? 'Approved' : 'Pending' }}
                            </span>
                        </div>
                        
                        @if($comment->is_approved && !$comment->isReply())
                            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                <form action="{{ route('owner.comments.reply', $comment) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    <input type="text" name="content" placeholder="Reply to this comment..." class="flex-1 px-4 py-2 bg-white/60 dark:bg-black/30 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">Reply</button>
                                </form>
                            </div>
                        @endif

                        @if($comment->replies->count() > 0)
                            <div class="mt-3 ml-6 space-y-2">
                                @foreach($comment->replies as $reply)
                                    <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border-l-4 border-indigo-500">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="font-semibold text-indigo-900 dark:text-indigo-300">{{ $reply->user->name }}</span>
                                            <span class="px-2 py-0.5 bg-indigo-100 dark:bg-indigo-900/40 text-indigo-800 dark:text-indigo-300 rounded text-xs font-semibold">Owner</span>
                                        </div>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $reply->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 dark:text-gray-400 py-8">No comments yet.</p>
        @endif
    </div>
</x-glass-layout>
