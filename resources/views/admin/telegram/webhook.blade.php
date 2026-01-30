<x-admin-layout>
    <div class="min-h-screen bg-gradient-warm p-6 space-y-8">
        <div class="glass-card p-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('admin.telegram.index') }}" class="text-warm-gray-600 hover:text-warm-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="heading-large text-warm-gray-900 dark:text-white">{{ __('Webhook Settings') }}</h1>
            </div>
        </div>

        <!-- Current Webhook Info -->
        @if($webhookInfo)
            <div class="glass-card p-8">
                <h2 class="text-xl font-bold text-warm-gray-900 dark:text-white mb-6">{{ __('Current Webhook') }}</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm text-warm-gray-500 mb-2">{{ __('URL') }}</h3>
                        <p class="text-warm-gray-900 dark:text-white font-mono text-sm">{{ $webhookInfo['url'] ?? 'Not set' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm text-warm-gray-500 mb-2">{{ __('Pending Updates') }}</h3>
                        <p class="text-warm-gray-900 dark:text-white">{{ $webhookInfo['pending_update_count'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Set Webhook Form -->
        <div class="glass-card p-8">
            <h2 class="text-xl font-bold text-warm-gray-900 dark:text-white mb-6">{{ __('Set New Webhook') }}</h2>
            <form action="{{ route('admin.telegram.set-webhook') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-warm-gray-700 dark:text-warm-gray-300 mb-2">
                            {{ __('Webhook URL') }}
                        </label>
                        <input 
                            type="url" 
                            name="webhook_url" 
                            value="{{ config('services.telegram.webhook_url') }}"
                            class="w-full px-4 py-3 rounded-lg border border-warm-gray-300 dark:border-warm-gray-600 bg-white dark:bg-warm-gray-800 text-warm-gray-900 dark:text-white"
                            placeholder="https://yourdomain.com/api/telegram/webhook"
                            required
                        >
                        @error('webhook_url')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Set Webhook') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Instructions -->
        <div class="glass-card p-8">
            <h2 class="text-xl font-bold text-warm-gray-900 dark:text-white mb-4">{{ __('Instructions') }}</h2>
            <div class="prose dark:prose-invert max-w-none">
                <ol class="list-decimal list-inside space-y-2 text-warm-gray-700 dark:text-warm-gray-300">
                    <li>Make sure your webhook URL is publicly accessible via HTTPS</li>
                    <li>The webhook route should be: <code class="bg-warm-gray-100 dark:bg-warm-gray-800 px-2 py-1 rounded">/api/telegram/webhook</code></li>
                    <li>Add <code class="bg-warm-gray-100 dark:bg-warm-gray-800 px-2 py-1 rounded">TELEGRAM_WEBHOOK_URL</code> to your .env file</li>
                    <li>Test your bot by sending /start command</li>
                </ol>
            </div>
        </div>
    </div>
</x-admin-layout>
