<x-admin-layout>
    <div class="min-h-screen bg-gradient-warm p-6 space-y-8">
        <div class="glass-card p-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('admin.telegram.index') }}" class="text-warm-gray-600 hover:text-warm-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="heading-large text-warm-gray-900 dark:text-white">{{ __('Statistics') }}</h1>
            </div>
        </div>

        <!-- Total Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="glass-card p-6">
                <h3 class="text-sm text-warm-gray-500 mb-2">{{ __('Total Sent') }}</h3>
                <p class="text-3xl font-bold text-green-600">{{ number_format($totalSent) }}</p>
            </div>
            <div class="glass-card p-6">
                <h3 class="text-sm text-warm-gray-500 mb-2">{{ __('Total Failed') }}</h3>
                <p class="text-3xl font-bold text-red-600">{{ number_format($totalFailed) }}</p>
            </div>
        </div>

        <!-- Users by Region -->
        <div class="glass-card p-8">
            <h2 class="text-xl font-bold text-warm-gray-900 dark:text-white mb-6">{{ __('Users by Region') }}</h2>
            <div class="space-y-4">
                @foreach($usersByRegion as $region)
                    <div class="flex items-center justify-between p-4 bg-warm-gray-50 dark:bg-warm-gray-800 rounded-lg">
                        <span class="text-warm-gray-900 dark:text-white">{{ $region->name }}</span>
                        <span class="font-bold text-blue-600">{{ number_format($region->count) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Broadcasts -->
        <div class="glass-card p-8">
            <h2 class="text-xl font-bold text-warm-gray-900 dark:text-white mb-6">{{ __('Recent Broadcasts') }}</h2>
            <div class="space-y-4">
                @foreach($recentBroadcasts as $broadcast)
                    <div class="p-4 bg-warm-gray-50 dark:bg-warm-gray-800 rounded-lg">
                        <p class="text-warm-gray-900 dark:text-white line-clamp-1">{{ $broadcast->caption }}</p>
                        <div class="flex items-center gap-4 mt-2 text-sm text-warm-gray-500">
                            <span>{{ __('Sent') }}: {{ number_format($broadcast->sent_count) }}</span>
                            <span>{{ __('Failed') }}: {{ number_format($broadcast->failed_count) }}</span>
                            <span>{{ $broadcast->sent_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-admin-layout>
