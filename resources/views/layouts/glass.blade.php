<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'QattaBor') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-full bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <div x-data="{ open: false }" class="min-h-screen flex flex-col relative overflow-hidden">
        <!-- Background Blobs -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-yellow-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>

        <!-- Header -->
        <header class="fixed top-0 w-full z-50 transition-all duration-300 bg-white/70 dark:bg-gray-900/70 backdrop-blur-xl border-b border-white/20 shadow-sm" id="navbar">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-white/30 backdrop-blur-md border border-white/20 flex items-center justify-center shadow-lg">
                                <span class="text-indigo-600 dark:text-indigo-400">Q</span>
                            </div>
                            QattaBor
                        </a>
                    </div>

                    <!-- Right Side: Location & Burger Menu -->
                    <div class="flex items-center gap-3">
                        <!-- Location Selector -->
                        <div x-data="{ locationOpen: false }">
                            <button @click="locationOpen = !locationOpen" class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500/20 to-purple-500/20 backdrop-blur-xl border border-white/40 shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-300 group">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </button>
                            <div x-show="locationOpen" 
                                 @click.away="locationOpen = false"
                                 x-transition
                                 class="absolute mt-2 w-64 bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-white/20 p-3 max-h-96 overflow-y-auto z-50 right-0"
                                 style="display: none;">
                                <div class="space-y-1">
                                    <a href="#" onclick="changeLocation('Tashkent')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">📍 Tashkent</a>
                                    <a href="#" onclick="changeLocation('Andijan')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">📍 Andijan</a>
                                    <a href="#" onclick="changeLocation('Bukhara')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">📍 Bukhara</a>
                                    <a href="#" onclick="changeLocation('Fergana')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">📍 Fergana</a>
                                    <a href="#" onclick="changeLocation('Jizzakh')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">📍 Jizzakh</a>
                                    <a href="#" onclick="changeLocation('Namangan')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">📍 Namangan</a>
                                    <a href="#" onclick="changeLocation('Navoiy')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">📍 Navoiy</a>
                                    <a href="#" onclick="changeLocation('Nukus')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">📍 Nukus</a>
                                    <a href="#" onclick="changeLocation('Qashqadaryo')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">📍 Qashqadaryo</a>
                                    <a href="#" onclick="changeLocation('Samarkand')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">📍 Samarkand</a>
                                    <a href="#" onclick="changeLocation('Sirdaryo')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">📍 Sirdaryo</a>
                                    <a href="#" onclick="changeLocation('Surxondaryo')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">📍 Surxondaryo</a>
                                    <a href="#" onclick="changeLocation('Xorazm')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">📍 Xorazm</a>
                                </div>
                            </div>
                        </div>

                        <!-- Burger Menu -->
                        <button @click="open = !open" class="p-2 rounded-xl bg-white/30 backdrop-blur-md border border-white/20 shadow-sm hover:bg-white/40 transition-all">
                            <svg class="w-6 h-6 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Backdrop -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="open = false" 
             class="fixed inset-0 z-40 bg-black bg-opacity-50"
             style="display: none;">
        </div>

        <!-- Side Menu (Left Side) -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed top-0 left-0 h-full w-80 bg-white dark:bg-gray-900 shadow-2xl z-50 overflow-y-auto"
             style="display: none;">
            
            <div class="p-6">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('menu') }}</h2>
                    <button @click="open = false" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Language Selector -->
                <div class="mb-6" x-data="{ langOpen: false }">
                    <button @click="langOpen = !langOpen" class="w-full flex items-center justify-between px-4 py-3 text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                            </svg>
                            <span id="current-lang">English</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="langOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="langOpen" 
                         x-transition
                         class="mt-2 space-y-1 pl-4"
                         style="display: none;">
                        <a href="#" onclick="changeLang('English')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                            🇬🇧 English
                        </a>
                        <a href="#" onclick="changeLang('Русский')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                            🇷🇺 Русский
                        </a>
                        <a href="#" onclick="changeLang('O\'zbekcha')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                            🇺🇿 O'zbekcha
                        </a>
                    </div>
                </div>

                <nav class="space-y-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            {{ __('dashboard') }}
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ __('profile') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-3 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                {{ __('logout') }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            {{ __('login') }}
                        </a>
                        <a href="{{ route('register') }}" class="flex items-center px-4 py-3 text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            {{ __('register') }}
                        </a>
                    @endauth
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-grow pt-20 pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full z-10">
            {{ $slot }}
        </main>

        <!-- Bottom Navigation Bar -->
        <div class="fixed bottom-0 left-0 right-0 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-t border-white/20 dark:border-gray-700/50 z-50 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]">
            <div class="grid grid-cols-3 h-16">
                <!-- Home Button -->
                <a href="{{ route('home') }}" class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('home') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400' }} hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="text-xs font-medium">{{ __('home') }}</span>
                </a>

                <!-- Saved Button -->
                <a href="#" class="flex flex-col items-center justify-center space-y-1 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                    <span class="text-xs font-medium">{{ __('saved') }}</span>
                </a>

                <!-- Map Button -->
                <a href="#" class="flex flex-col items-center justify-center space-y-1 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    <span class="text-xs font-medium">{{ __('map') }}</span>
                </a>
            </div>
        </div>
    </div>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        }
        .dark .glass-card {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
    
    <script>
        function changeLang(lang) {
            let locale = 'en';
            if (lang === 'Русский') locale = 'ru';
            else if (lang === 'O\'zbekcha') locale = 'uz';
            
            // Send AJAX request to change locale
            fetch(`/language/${locale}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('current-lang').textContent = lang;
                    // Reload the page to apply new language
                    window.location.reload();
                }
            })
            .catch(error => console.error('Error changing language:', error));
        }
        
        function changeLocation(location) {
            // Store selected location in session storage
            sessionStorage.setItem('selectedLocation', location);
            const locationEl = document.getElementById('current-location');
            if (locationEl) {
                locationEl.textContent = location;
            }
            // TODO: Filter places by selected location
            // You can reload the page with location parameter or use AJAX to filter
            console.log('Location changed to:', location);
        }
        
        // Set initial language display based on current locale
        document.addEventListener('DOMContentLoaded', function() {
            const locale = '{{ app()->getLocale() }}';
            let langDisplay = 'English';
            if (locale === 'ru') langDisplay = 'Русский';
            else if (locale === 'uz') langDisplay = 'O\'zbekcha';
            document.getElementById('current-lang').textContent = langDisplay;
            
            // Restore selected location from session storage
            const savedLocation = sessionStorage.getItem('selectedLocation');
            if (savedLocation) {
                const locationEl = document.getElementById('current-location');
                if (locationEl) {
                    locationEl.textContent = savedLocation;
                }
            }
        });
    </script>
</body>
</html>