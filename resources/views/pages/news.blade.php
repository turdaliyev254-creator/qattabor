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
                {{ __('Latest') }} <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">{{ __('News') }}</span>
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('Stay updated with the latest from QattaBor') }}</p>
        </div>

        <!-- News Content -->
        <div class="fade-in-up">
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-8">
                <div class="prose prose-lg dark:prose-invert max-w-none">
                    {!! nl2br(e($content ?? __('Stay tuned for the latest news and updates!'))) !!}
                </div>
            </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ __('January 8, 2026') }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ __('1000+ Places Added') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('Our database has grown to over 1000 verified places across Uzbekistan, making it easier than ever to discover new locations.') }}
                    </p>
                    <a href="#" class="text-green-600 dark:text-green-400 font-semibold hover:underline">
                        {{ __('Read more') }} →
                    </a>
                </div>
            </article>

            <!-- News Article 3 -->
            <article class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="h-48 bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center">
                    <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ __('January 5, 2026') }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ __('User Dashboard Redesigned') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('We\'ve completely redesigned the user dashboard with a modern glass-morphism design for a better user experience.') }}
                    </p>
                    <a href="#" class="text-purple-600 dark:text-purple-400 font-semibold hover:underline">
                        {{ __('Read more') }} →
                    </a>
                </div>
            </article>
        </div>

        <!-- Newsletter Section -->
        <div class="mt-12 backdrop-blur-xl bg-gradient-to-r from-blue-500/20 to-purple-600/20 dark:from-blue-600/30 dark:to-purple-700/30 rounded-3xl shadow-xl border border-blue-200/50 dark:border-blue-700/50 p-8 text-center fade-in-up">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">{{ __('Subscribe to our Newsletter') }}</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('Get the latest updates and news delivered to your inbox') }}</p>
            <form action="#" method="POST" class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                @csrf
                <input type="email" name="email" placeholder="{{ __('Enter your email') }}" class="flex-1 px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-xl transition-all duration-300 hover:scale-105">
                    {{ __('Subscribe') }}
                </button>
            </form>
        </div>
    </div>
</x-glass-layout>
