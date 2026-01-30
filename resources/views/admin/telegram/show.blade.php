<x-admin-layout>
    <div class="min-h-screen bg-gradient-warm p-6 space-y-8">
        <!-- Header -->
        <div class="glass-card p-8 animate-fade-in">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.telegram.index') }}" class="text-warm-gray-600 hover:text-warm-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <h1 class="heading-large text-warm-gray-900 dark:text-white">{{ __('Broadcast Details') }}</h1>
                </div>
                @if($broadcast->status === 'draft')
                    <form action="{{ route('admin.telegram.send', $broadcast) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            {{ __('Send Broadcast') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Broadcast Info -->
        <div class="glass-card p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-warm-gray-500 mb-2">{{ __('Status') }}</h3>
                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ $broadcast->getStatusBadgeClass() }}">
                        {{ __(ucfirst($broadcast->status)) }}
                    </span>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-warm-gray-500 mb-2">{{ __('Created By') }}</h3>
                    <p class="text-warm-gray-900 dark:text-white">{{ $broadcast->creator->name }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-warm-gray-500 mb-2">{{ __('Target Users') }}</h3>
                    <p class="text-warm-gray-900 dark:text-white font-bold">{{ number_format($targetUserCount) }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-warm-gray-500 mb-2">{{ __('Target Regions') }}</h3>
                    <p class="text-warm-gray-900 dark:text-white">{{ $broadcast->getTargetRegionNames() }}</p>
                </div>
                @if($broadcast->sent_at)
                    <div>
                        <h3 class="text-sm font-medium text-warm-gray-500 mb-2">{{ __('Sent') }}</h3>
                        <p class="text-green-600 font-bold">{{ number_format($broadcast->sent_count) }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-warm-gray-500 mb-2">{{ __('Failed') }}</h3>
                        <p class="text-red-600 font-bold">{{ number_format($broadcast->failed_count) }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Caption -->
        <div class="glass-card p-8">
            <h3 class="text-lg font-bold text-warm-gray-900 dark:text-white mb-4">{{ __('Caption') }}</h3>
            <p class="text-warm-gray-700 dark:text-warm-gray-300 whitespace-pre-wrap">{{ $broadcast->caption }}</p>
        </div>

        <!-- Links -->
        @if(!empty($broadcast->links))
            <div class="glass-card p-8">
                <h3 class="text-lg font-bold text-warm-gray-900 dark:text-white mb-4">{{ __('Social Links') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($broadcast->links as $key => $value)
                        @if($value)
                            <div class="flex items-center gap-3 p-4 bg-warm-gray-50 dark:bg-warm-gray-800 rounded-lg">
                                <span class="text-2xl">
                                    @if($key === 'tg') ✈️
                                    @elseif($key === 'inst') 📸
                                    @elseif($key === 'fb') 🔵
                                    @elseif($key === 'yt') 🎬
                                    @elseif($key === 'tel') 📞
                                    @elseif($key === 'web') 🌐
                                    @endif
                                </span>
                                <div>
                                    <p class="text-xs text-warm-gray-500">{{ __(ucfirst($key)) }}</p>
                                    <p class="text-sm text-warm-gray-900 dark:text-white">{{ $value }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-admin-layout>
