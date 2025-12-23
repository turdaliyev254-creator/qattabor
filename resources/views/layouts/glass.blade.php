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
<body class="font-sans antialiased h-full bg-gradient-to-br from-blue-50/50 via-white to-purple-50/30 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <div x-data="{ open: false }" class="min-h-screen flex flex-col relative overflow-hidden">
        <!-- Subtle Background Pattern -->
        <div class="absolute inset-0 bg-grid-pattern opacity-[0.015] dark:opacity-[0.05]"></div>

        <!-- Header -->
        <header class="fixed top-0 w-full z-50 transition-all duration-300 bg-white/80 dark:from-gray-900/95 dark:to-gray-800/95 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-700/50" id="navbar">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-xl">Q</span>
                            </div>
                            <span class="text-xl font-bold">
                                <span class="text-gray-900 dark:text-white">Qatta</span><span class="text-blue-600 dark:text-blue-400">Bor</span>
                            </span>
                        </a>
                    </div>

                    <!-- Right Side: Location & Burger Menu -->
                    <div class="flex items-center gap-3">
                        <!-- Location Selector -->
                        <div x-data="{ locationOpen: false }" class="relative">
                            <button @click="locationOpen = !locationOpen" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span id="current-location" class="font-medium">Toshkent</span>
                            </button>
                            <div x-show="locationOpen" 
                                 @click.away="locationOpen = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-700 p-6 max-h-[500px] overflow-y-auto z-50"
                                 style="display: none;">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Hududni tanlang</h3>
                                <div class="grid grid-cols-2 gap-3">
                                    <button onclick="changeLocation('Toshkent')" class="px-4 py-3 text-sm text-center font-medium text-white bg-gray-900 dark:bg-white dark:text-gray-900 rounded-2xl hover:opacity-90 transition-opacity">Toshkent</button>
                                    <button onclick="changeLocation('Toshkent viloyati')" class="px-4 py-3 text-sm text-center font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Toshkent viloyati</button>
                                    <button onclick="changeLocation('Farg\'ona')" class="px-4 py-3 text-sm text-center font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Farg'ona</button>
                                    <button onclick="changeLocation('Qo\'qon')" class="px-4 py-3 text-sm text-center font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Qo'qon</button>
                                    <button onclick="changeLocation('Namangan')" class="px-4 py-3 text-sm text-center font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Namangan</button>
                                    <button onclick="changeLocation('Samarqand')" class="px-4 py-3 text-sm text-center font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Samarqand</button>
                                    <button onclick="changeLocation('Buxoro')" class="px-4 py-3 text-sm text-center font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Buxoro</button>
                                    <button onclick="changeLocation('Andijon')" class="px-4 py-3 text-sm text-center font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Andijon</button>
                                    <button onclick="changeLocation('Navoi')" class="px-4 py-3 text-sm text-center font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Navoi</button>
                                    <button onclick="changeLocation('Xorazm')" class="px-4 py-3 text-sm text-center font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Xorazm</button>
                                    <button onclick="changeLocation('Surxondaryo')" class="px-4 py-3 text-sm text-center font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Surxondaryo</button>
                                    <button onclick="changeLocation('Qashqadaryo')" class="px-4 py-3 text-sm text-center font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Qashqadaryo</button>
                                    <button onclick="changeLocation('Jizzax')" class="px-4 py-3 text-sm text-center font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Jizzax</button>
                                </div>
                            </div>
                        </div>

                        <!-- Burger Menu -->
                        <button @click="open = !open" class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                            <svg class="w-6 h-6 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
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

        <!-- Side Menu (Right Side) -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed top-0 right-0 h-full w-80 bg-white dark:bg-gray-900 shadow-2xl z-50 overflow-y-auto"
             style="display: none;">
            
            <div class="p-6 h-full flex flex-col">
                <!-- Header with Logo and Close -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-xl">Q</span>
                        </div>
                        <span class="text-xl font-bold">
                            <span class="text-gray-900 dark:text-white">Qatta</span><span class="text-blue-600 dark:text-blue-400">Bor</span>
                        </span>
                    </div>
                    <button @click="open = false" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                @auth
                <!-- Profile Section -->
                <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-2xl">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900 dark:to-purple-900 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900 dark:text-white">Kabinet</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">+998 90 ...</div>
                        </div>
                    </div>
                </div>
                @endauth

                <!-- Dark Mode Toggle -->
                <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-500 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <span id="mode-text" class="font-medium text-gray-700 dark:text-gray-300">Kunduzgi</span>
                        </div>
                        <button onclick="toggleDarkMode()" 
                                id="dark-mode-toggle"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors bg-gray-300 dark:bg-blue-600">
                            <span id="toggle-slider" class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform translate-x-1 dark:translate-x-6"></span>
                        </button>
                    </div>
                </div>

                <!-- Menu Items -->
                <nav class="space-y-2 flex-1">
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition-colors">
                        <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Biz haqimizda</span>
                        <svg class="w-4 h-4 ml-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition-colors">
                        <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Aloqa</span>
                        <svg class="w-4 h-4 ml-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition-colors">
                        <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Yangiliklar</span>
                        <svg class="w-4 h-4 ml-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </nav>

                <!-- Language Switcher at Bottom -->
                <div class="mt-auto pt-6 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 text-center mb-2">Til: <span id="current-lang">UZB</span></p>
                    <div class="flex items-center justify-center gap-3 mb-4">
                        <button onclick="changeLang('UZB')" class="px-6 py-2 text-sm font-semibold rounded-full bg-blue-600 text-white">
                            UZB
                        </button>
                        <button onclick="changeLang('RUS')" class="px-6 py-2 text-sm font-medium rounded-full text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                            RUS
                        </button>
                        <button onclick="changeLang('ENG')" class="px-6 py-2 text-sm font-medium rounded-full text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                            ENG
                        </button>
                    </div>

                    @auth
                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 text-red-600 dark:text-red-400 font-semibold hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Chiqish
                        </button>
                    </form>
                    @endauth

                    @guest
                    <!-- Login Button -->
                    <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 text-blue-600 dark:text-blue-400 font-semibold hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Kirish
                    </a>
                    @endguest
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-grow pt-20 pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full z-10">
            {{ $slot }}
        </main>

        <!-- Bottom Navigation Bar -->
        <div class="fixed bottom-0 left-0 right-0 bg-white/90 dark:bg-gray-900/80 backdrop-blur-xl border-t border-gray-200/50 dark:border-gray-700/50 z-50 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
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
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 16px 0 rgba(31, 38, 135, 0.05);
        }
        .dark .glass-card {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .bg-grid-pattern {
            background-image: 
                linear-gradient(rgba(100, 100, 100, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(100, 100, 100, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
    
    <script>
        // Dark Mode Toggle Function
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            
            if (isDark) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                document.getElementById('mode-text').textContent = 'Kunduzgi';
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                document.getElementById('mode-text').textContent = 'Tungi';
            }
        }

        // Initialize dark mode on page load
        (function() {
            const theme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (theme === 'dark' || (!theme && prefersDark)) {
                document.documentElement.classList.add('dark');
                const modeText = document.getElementById('mode-text');
                if (modeText) modeText.textContent = 'Tungi';
            }
        })();

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
                    const langEl = document.getElementById('current-lang');
                    if (langEl) {
                        langEl.textContent = lang;
                    }
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
            let langDisplay = 'UZB';
            if (locale === 'ru') langDisplay = 'RUS';
            else if (locale === 'en') langDisplay = 'ENG';
            
            const langEl = document.getElementById('current-lang');
            if (langEl) {
                langEl.textContent = langDisplay;
            }
            
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