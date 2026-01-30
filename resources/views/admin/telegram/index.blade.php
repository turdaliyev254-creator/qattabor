<x-admin-layout>
    <div class="min-h-screen bg-gradient-warm p-6 space-y-8">
        <!-- Header -->
        <div class="glass-card p-8 animate-fade-in">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div>
                    <h1 class="heading-large text-warm-gray-900 dark:text-white mb-2">{{ __('Telegram Bot') }}</h1>
                    <p class="text-warm-gray-600 dark:text-warm-gray-400">{{ __('Manage broadcasts and bot statistics') }}</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.telegram.webhook') }}" class="btn btn-secondary hover-lift">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ __('Webhook Settings') }}
                    </a>
                    <a href="{{ route('admin.telegram.statistics') }}" class="btn btn-secondary hover-lift">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        {{ __('Statistics') }}
                    </a>
                    <a href="{{ route('admin.telegram.create') }}" class="btn btn-primary hover-lift">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('Create Broadcast') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="glass-card p-6 hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-warm-gray-600 dark:text-warm-gray-400">{{ __('Total Users') }}</p>
                        <p class="text-3xl font-bold text-warm-gray-900 dark:text-white mt-2">{{ $stats['total_users'] }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-xl">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6 hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-warm-gray-600 dark:text-warm-gray-400">{{ __('Verified Users') }}</p>
                        <p class="text-3xl font-bold text-warm-gray-900 dark:text-white mt-2">{{ $stats['verified_users'] }}</p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-xl">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6 hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-warm-gray-600 dark:text-warm-gray-400">{{ __('Total Broadcasts') }}</p>
                        <p class="text-3xl font-bold text-warm-gray-900 dark:text-white mt-2">{{ $stats['total_broadcasts'] }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-xl">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6 hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-warm-gray-600 dark:text-warm-gray-400">{{ __('Completed') }}</p>
                        <p class="text-3xl font-bold text-warm-gray-900 dark:text-white mt-2">{{ $stats['completed_broadcasts'] }}</p>
                    </div>
                    <div class="p-3 bg-orange-100 dark:bg-orange-900 rounded-xl">
                        <svg class="w-8 h-8 text-orange-600 dark:text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Broadcasts List -->
        <div class="glass-card p-8">
            <h2 class="text-2xl font-bold text-warm-gray-900 dark:text-white mb-6">{{ __('Broadcasts') }}</h2>
            
            @if($broadcasts->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-warm-gray-200 dark:border-warm-gray-700">
                                <th class="text-left py-4 px-4 text-sm font-semibold text-warm-gray-700 dark:text-warm-gray-300">{{ __('Caption') }}</th>
                                <th class="text-left py-4 px-4 text-sm font-semibold text-warm-gray-700 dark:text-warm-gray-300">{{ __('Target Regions') }}</th>
                                <th class="text-center py-4 px-4 text-sm font-semibold text-warm-gray-700 dark:text-warm-gray-300">{{ __('Status') }}</th>
                                <th class="text-center py-4 px-4 text-sm font-semibold text-warm-gray-700 dark:text-warm-gray-300">{{ __('Sent') }}</th>
                                <th class="text-center py-4 px-4 text-sm font-semibold text-warm-gray-700 dark:text-warm-gray-300">{{ __('Failed') }}</th>
                                <th class="text-right py-4 px-4 text-sm font-semibold text-warm-gray-700 dark:text-warm-gray-300">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-warm-gray-200 dark:divide-warm-gray-700">
                            @foreach($broadcasts as $broadcast)
                                <tr class="hover:bg-warm-gray-50 dark:hover:bg-warm-gray-800 transition-colors">
                                    <td class="py-4 px-4">
                                        <p class="text-sm text-warm-gray-900 dark:text-white line-clamp-2">{{ Str::limit($broadcast->caption, 60) }}</p>
                                        <p class="text-xs text-warm-gray-500 mt-1">{{ $broadcast->created_at->diffForHumans() }}</p>
                                    </td>
                                    <td class="py-4 px-4">
                                        <p class="text-sm text-warm-gray-700 dark:text-warm-gray-300">{{ $broadcast->getTargetRegionNames() }}</p>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $broadcast->getStatusBadgeClass() }}">
                                            {{ __(ucfirst($broadcast->status)) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <p class="text-sm font-medium text-warm-gray-900 dark:text-white">{{ $broadcast->sent_count }}</p>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <p class="text-sm font-medium text-warm-gray-900 dark:text-white">{{ $broadcast->failed_count }}</p>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.telegram.show', $broadcast) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            @if($broadcast->status === 'draft')
                                                <form action="{{ route('admin.telegram.destroy', $broadcast) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $broadcasts->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-warm-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-warm-gray-500 dark:text-warm-gray-400">{{ __('No broadcasts found.') }}</p>
                    <a href="{{ route('admin.telegram.create') }}" class="btn btn-primary mt-4 inline-flex items-center">
                        {{ __('Create Broadcast') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
