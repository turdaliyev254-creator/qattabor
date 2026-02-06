<x-glass-layout>
    <div class="container mx-auto px-4 py-12 max-w-4xl">
        <!-- Hero Section -->
        <div class="text-center mb-12 fade-in-down">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-br from-blue-500 to-purple-600 shadow-2xl mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-4">
                {{ __('About') }}
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('Discover amazing places in Uzbekistan') }}</p>
        </div>

        <!-- Content Card -->
        <div class="space-y-6 fade-in-up">
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-8">
                <div class="prose prose-lg dark:prose-invert max-w-none">
                    {!! nl2br(e($content ?? __('Welcome to QattaBor - your guide to discovering amazing places!'))) !!}
                </div>
            </div>

            <!-- Contact CTA -->
            <div class="backdrop-blur-xl bg-gradient-to-r from-blue-500/20 to-purple-600/20 dark:from-blue-600/30 dark:to-purple-700/30 rounded-3xl shadow-xl border border-blue-200/50 dark:border-blue-700/50 p-8 text-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">{{ __('Have Questions?') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('Feel free to reach out to us anytime') }}</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-xl transition-all duration-300 hover:scale-105">
                    {{ __('Contact Us') }}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</x-glass-layout>
