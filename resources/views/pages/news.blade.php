<x-glass-layout>
    <div class="container mx-auto px-4 py-12 max-w-6xl">
        <!-- Hero Section -->
        <div class="text-center mb-12 fade-in-down">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-br from-purple-500 to-pink-600 shadow-2xl mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-4">
                {{ __('News') }}
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('Stay updated with the latest from QattaBor') }}</p>
        </div>

        <!-- News Content -->
        <div class="fade-in-up">
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-8 mb-8">
                <div class="prose prose-lg dark:prose-invert max-w-none">
                    {!! nl2br(e($content ?? __('Stay tuned for the latest news and updates!'))) !!}
                </div>
            </div>
        </div>

        <!-- Telegram Subscribe Section -->
        <div class="mt-12 backdrop-blur-xl bg-gradient-to-r from-blue-500/20 to-purple-600/20 dark:from-blue-600/30 dark:to-purple-700/30 rounded-3xl shadow-xl border border-blue-200/50 dark:border-blue-700/50 p-8 text-center fade-in-up">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg mb-4">
                <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">{{ __('Subscribe to our Newsletter') }}</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('Get the latest updates and news delivered to your inbox') }}</p>
            <a href="https://t.me/{{ App\Models\Setting::where('key', 'telegram_bot')->value('value') ?? 'qattabor_bot' }}" 
               target="_blank"
               class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl hover:shadow-xl transition-all duration-300 hover:scale-105">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
                </svg>
                {{ __('Subscribe') }}
            </a>
        </div>
    </div>
</x-glass-layout>
