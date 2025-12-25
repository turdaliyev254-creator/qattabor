<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex items-center justify-center relative overflow-hidden p-4">
            <!-- Animated Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 dark:from-blue-900 dark:via-purple-900 dark:to-pink-900"></div>
            <div class="absolute inset-0 backdrop-blur-3xl bg-white/30 dark:bg-black/30"></div>
            
            <!-- Floating Elements -->
            <div class="absolute top-20 left-20 w-72 h-72 bg-blue-400/30 dark:bg-blue-600/30 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-purple-400/30 dark:bg-purple-600/30 rounded-full blur-3xl animate-pulse delay-1000"></div>
            
            <!-- Back Button -->
            <div class="absolute top-6 left-6 z-20">
                <a href="/" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold backdrop-blur-md bg-white/20 dark:bg-black/20 text-gray-800 dark:text-white hover:bg-white/30 dark:hover:bg-black/30 border border-white/30 dark:border-white/10 shadow-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>{{ __('Back') }}</span>
                </a>
            </div>

            <!-- Language Switcher -->
            <div class="absolute top-6 right-6 z-20">
                <div class="flex gap-2">
                    <form action="{{ route('language.switch', 'en') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ app()->getLocale() == 'en' ? 'bg-white/90 dark:bg-white/20 text-blue-600 dark:text-white shadow-lg backdrop-blur-md border border-white/50' : 'backdrop-blur-md bg-white/20 dark:bg-black/20 text-gray-800 dark:text-white hover:bg-white/30 dark:hover:bg-black/30 border border-white/30 dark:border-white/10 shadow-md' }}">
                            EN
                        </button>
                    </form>
                    <form action="{{ route('language.switch', 'ru') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ app()->getLocale() == 'ru' ? 'bg-white/90 dark:bg-white/20 text-blue-600 dark:text-white shadow-lg backdrop-blur-md border border-white/50' : 'backdrop-blur-md bg-white/20 dark:bg-black/20 text-gray-800 dark:text-white hover:bg-white/30 dark:hover:bg-black/30 border border-white/30 dark:border-white/10 shadow-md' }}">
                            RU
                        </button>
                    </form>
                    <form action="{{ route('language.switch', 'uz') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ app()->getLocale() == 'uz' ? 'bg-white/90 dark:bg-white/20 text-blue-600 dark:text-white shadow-lg backdrop-blur-md border border-white/50' : 'backdrop-blur-md bg-white/20 dark:bg-black/20 text-gray-800 dark:text-white hover:bg-white/30 dark:hover:bg-black/30 border border-white/30 dark:border-white/10 shadow-md' }}">
                            UZ
                        </button>
                    </form>
                </div>
            </div>

            <div class="w-full max-w-sm relative z-10">
                <div class="backdrop-blur-xl bg-white/40 dark:bg-black/40 shadow-2xl rounded-2xl overflow-hidden border border-white/50 dark:border-white/10">
                    <!-- Header -->
                    <div class="backdrop-blur-md bg-gradient-to-r from-blue-600/80 to-purple-600/80 dark:from-blue-800/80 dark:to-purple-800/80 px-6 py-6 text-center border-b border-white/20">
                        <h2 class="text-2xl font-bold text-white mb-1 drop-shadow-lg">{{ __('Welcome back') }}</h2>
                        <p class="text-sm text-white/90 drop-shadow">{{ __('Sign in to continue') }}</p>
                    </div>
                    
                    <!-- Content -->
                    <div class="px-6 py-6 backdrop-blur-sm">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Initialize dark mode on page load based on main site preference
            (function() {
                const theme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                
                if (theme === 'dark' || (!theme && prefersDark)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>
    </body>
</html>
