<x-glass-layout>
    <div class="container mx-auto px-4 py-12 max-w-4xl">
        <!-- Hero Section -->
        <div class="text-center mb-12 fade-in-down">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-br from-green-500 to-emerald-600 shadow-2xl mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-4">
                {{ __('Contact') }} <span class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Us</span>
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('We\'d love to hear from you') }}</p>
        </div>

        <!-- Contact Cards -->
        <div class="grid md:grid-cols-2 gap-6 mb-8 fade-in-up">
            <!-- Email Card -->
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-6 hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Email') }}</h3>
                <a href="mailto:{{ $contact['email'] ?? 'info@qattabor.uz' }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                    {{ $contact['email'] ?? 'info@qattabor.uz' }}
                </a>
            </div>

            <!-- Phone Card -->
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-6 hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Phone') }}</h3>
                <a href="tel:{{ $contact['phone'] ?? '+998901234567' }}" class="text-green-600 dark:text-green-400 hover:underline">
                    {{ $contact['phone'] ?? '+998 90 123 45 67' }}
                </a>
            </div>

            <!-- Location Card -->
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-6 hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Address') }}</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ $contact['address_' . app()->getLocale()] ?? $contact['address_en'] ?? 'Tashkent, Uzbekistan' }}
                </p>
            </div>

            <!-- Social Media Card -->
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-6 hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-pink-500 to-red-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Social Media') }}</h3>
                <div class="flex gap-3">
                    @if(!empty($contact['facebook']))
                    <a href="{{ $contact['facebook'] }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    @endif
                    @if(!empty($contact['instagram']))
                    <a href="{{ $contact['instagram'] }}" target="_blank" class="text-pink-600 dark:text-pink-400 hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    @endif
                    @if(!empty($contact['telegram']))
                    <a href="{{ $contact['telegram'] }}" target="_blank" class="text-blue-500 dark:text-blue-400 hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-8 fade-in-up">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ __('Send us a message') }}</h2>
            <form action="#" method="POST" class="space-y-6">
                @csrf
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Name') }}</label>
                        <input type="text" id="name" name="name" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Email') }}</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required>
                    </div>
                </div>
                <div>
                    <label for="subject" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Subject') }}</label>
                    <input type="text" id="subject" name="subject" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required>
                </div>
                <div>
                    <label for="message" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Message') }}</label>
                    <textarea id="message" name="message" rows="5" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required></textarea>
                </div>
                <button type="submit" class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-xl transition-all duration-300 hover:scale-105">
                    {{ __('Send Message') }}
                </button>
            </form>
        </div>
    </div>
</x-glass-layout>
