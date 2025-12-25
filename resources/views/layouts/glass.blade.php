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

    <!-- Telegram Web App Script -->
    <script src="https://telegram.org/js/telegram-web-app.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-full bg-gradient-to-br from-blue-50/50 via-white to-purple-50/30 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <div x-data="{ open: false }" class="min-h-screen flex flex-col relative overflow-hidden">
        <!-- Subtle Background Pattern -->
        <div class="absolute inset-0 bg-grid-pattern opacity-[0.015] dark:opacity-[0.05]"></div>

        <!-- Header -->
        <header class="fixed top-0 w-full z-50 transition-all duration-300 backdrop-blur-2xl bg-white/60 dark:bg-gray-900/60 border-b border-white/20 dark:border-gray-700/30 shadow-lg shadow-gray-200/20 dark:shadow-gray-900/40" id="navbar">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-20 items-center justify-between">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl blur-sm opacity-50 group-hover:opacity-75 transition-opacity"></div>
                                <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg transform group-hover:scale-105 transition-transform">
                                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-2xl font-black tracking-tight">
                                    <span class="bg-gradient-to-r from-gray-900 via-blue-600 to-purple-600 dark:from-white dark:via-blue-400 dark:to-purple-400 bg-clip-text text-transparent">QattaBor</span>
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 font-medium -mt-1">{{ __('Discover places') }}</span>
                            </div>
                        </a>
                    </div>

                    <!-- Right Side: Location & Burger Menu -->
                    <div class="flex items-center gap-4">
                        <!-- Location Selector -->
                        <div x-data="{ locationOpen: false }" class="relative">
                            <button @click="locationOpen = !locationOpen" class="flex items-center gap-2.5 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-800/80 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-2xl transition-all backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50">
                                <div class="w-5 h-5 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span id="current-location" class="font-semibold">Toshkent</span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform" :class="locationOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="locationOpen" 
                                 @click.away="locationOpen = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                 class="absolute right-0 mt-3 w-96 bg-white/95 dark:bg-gray-800/95 backdrop-blur-2xl rounded-3xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 p-6 max-h-[520px] overflow-y-auto z-50"
                                 style="display: none;">
                                <div class="flex items-center justify-between mb-5">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('select_region') }}</h3>
                                    <button @click="locationOpen = false" class="p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="grid grid-cols-2 gap-2.5" id="location-buttons">
                                    <button onclick="changeLocation('Toshkent')" data-location="Toshkent" class="location-btn px-4 py-3.5 text-sm text-center font-semibold text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-600 dark:hover:text-blue-400 transition-all border border-transparent hover:border-blue-200 dark:hover:border-blue-800">{{ __('Toshkent') }}</button>
                                    <button onclick="changeLocation('Toshkent viloyati')" data-location="Toshkent viloyati" class="location-btn px-4 py-3.5 text-sm text-center font-semibold text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-600 dark:hover:text-blue-400 transition-all border border-transparent hover:border-blue-200 dark:hover:border-blue-800">{{ __('Toshkent viloyati') }}</button>
                                    <button onclick="changeLocation('Fargona')" data-location="Fargona" class="location-btn px-4 py-3.5 text-sm text-center font-semibold text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-600 dark:hover:text-blue-400 transition-all border border-transparent hover:border-blue-200 dark:hover:border-blue-800">{{ __("Farg'ona") }}</button>
                                    <button onclick="changeLocation('Qoqon')" data-location="Qoqon" class="location-btn px-4 py-3.5 text-sm text-center font-semibold text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-600 dark:hover:text-blue-400 transition-all border border-transparent hover:border-blue-200 dark:hover:border-blue-800">{{ __("Qo'qon") }}</button>
                                    <button onclick="changeLocation('Namangan')" data-location="Namangan" class="location-btn px-4 py-3.5 text-sm text-center font-semibold text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-600 dark:hover:text-blue-400 transition-all border border-transparent hover:border-blue-200 dark:hover:border-blue-800">{{ __('Namangan') }}</button>
                                    <button onclick="changeLocation('Samarqand')" data-location="Samarqand" class="location-btn px-4 py-3.5 text-sm text-center font-semibold text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-600 dark:hover:text-blue-400 transition-all border border-transparent hover:border-blue-200 dark:hover:border-blue-800">{{ __('Samarqand') }}</button>
                                    <button onclick="changeLocation('Buxoro')" data-location="Buxoro" class="location-btn px-4 py-3.5 text-sm text-center font-semibold text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-600 dark:hover:text-blue-400 transition-all border border-transparent hover:border-blue-200 dark:hover:border-blue-800">{{ __('Buxoro') }}</button>
                                    <button onclick="changeLocation('Andijon')" data-location="Andijon" class="location-btn px-4 py-3.5 text-sm text-center font-semibold text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-600 dark:hover:text-blue-400 transition-all border border-transparent hover:border-blue-200 dark:hover:border-blue-800">{{ __('Andijon') }}</button>
                                    <button onclick="changeLocation('Navoi')" data-location="Navoi" class="location-btn px-4 py-3.5 text-sm text-center font-semibold text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-600 dark:hover:text-blue-400 transition-all border border-transparent hover:border-blue-200 dark:hover:border-blue-800">{{ __('Navoi') }}</button>
                                    <button onclick="changeLocation('Xorazm')" data-location="Xorazm" class="location-btn px-4 py-3.5 text-sm text-center font-semibold text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-600 dark:hover:text-blue-400 transition-all border border-transparent hover:border-blue-200 dark:hover:border-blue-800">{{ __('Xorazm') }}</button>
                                    <button onclick="changeLocation('Surxondaryo')" data-location="Surxondaryo" class="location-btn px-4 py-3.5 text-sm text-center font-semibold text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-600 dark:hover:text-blue-400 transition-all border border-transparent hover:border-blue-200 dark:hover:border-blue-800">{{ __('Surxondaryo') }}</button>
                                    <button onclick="changeLocation('Qashqadaryo')" data-location="Qashqadaryo" class="location-btn px-4 py-3.5 text-sm text-center font-semibold text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-600 dark:hover:text-blue-400 transition-all border border-transparent hover:border-blue-200 dark:hover:border-blue-800">{{ __('Qashqadaryo') }}</button>
                                    <button onclick="changeLocation('Jizzax')" data-location="Jizzax" class="location-btn px-4 py-3.5 text-sm text-center font-semibold text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-600 dark:hover:text-blue-400 transition-all border border-transparent hover:border-blue-200 dark:hover:border-blue-800">{{ __('Jizzax') }}</button>
                                </div>
                            </div>
                        </div>

                        <!-- Burger Menu -->
                        <button @click="open = !open" class="p-3 rounded-2xl bg-gray-100/80 dark:bg-gray-800/80 hover:bg-gray-200 dark:hover:bg-gray-700 transition-all backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 group">
                            <svg class="w-6 h-6 text-gray-700 dark:text-gray-200 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
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
             class="fixed inset-0 z-40 bg-black bg-opacity-50">
        </div>

        <!-- Side Menu (Right Side) -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed top-0 right-0 h-full w-80 bg-gradient-to-b from-white via-blue-50/30 to-purple-50/30 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 shadow-2xl z-50 overflow-y-auto backdrop-blur-xl">
            
            <div class="p-6 h-full flex flex-col">
                <!-- Header with Logo and Close -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3 group">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl blur-sm opacity-50 group-hover:opacity-75 transition-opacity"></div>
                            <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xl font-black">
                                <span class="bg-gradient-to-r from-gray-900 via-blue-600 to-purple-600 dark:from-white dark:via-blue-400 dark:to-purple-400 bg-clip-text text-transparent">QattaBor</span>
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 font-medium -mt-0.5">{{ __('Discover places') }}</span>
                        </div>
                    </div>
                    <button @click="open = false" class="p-2.5 rounded-xl bg-gray-100/80 dark:bg-gray-800/80 hover:bg-gray-200 dark:hover:bg-gray-700 transition-all backdrop-blur-sm">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                @auth
                <!-- Profile Section -->
                <div class="mb-6 p-5 bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800/80 dark:to-gray-800/60 rounded-3xl border border-blue-100/50 dark:border-gray-700/50 backdrop-blur-sm shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></div>
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-gray-900 dark:text-white text-lg">Kabinet</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">+998 90 ...</div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
                @endauth

                <!-- Dark Mode Toggle -->
                <div class="mb-6 p-5 bg-gradient-to-br from-orange-50 to-yellow-50 dark:from-gray-800/80 dark:to-gray-800/60 rounded-3xl border border-orange-100/50 dark:border-gray-700/50 backdrop-blur-sm shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-orange-400 to-yellow-500 dark:from-blue-500 dark:to-purple-600 flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <svg class="w-6 h-6 text-white hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-gray-900 dark:text-white text-sm">{{ __('Theme') }}</div>
                                <div id="mode-text" class="text-xs text-gray-600 dark:text-gray-400 font-medium">{{ __('Light mode') }}</div>
                            </div>
                        </div>
                        <button onclick="toggleDarkMode()" 
                                id="dark-mode-toggle"
                                class="relative inline-flex h-8 w-14 items-center rounded-full transition-all bg-gray-300 dark:bg-gradient-to-r dark:from-blue-500 dark:to-purple-600 shadow-inner dark:shadow-lg">
                            <span id="toggle-slider" class="inline-block h-6 w-6 transform rounded-full bg-white transition-transform translate-x-1 dark:translate-x-7 shadow-md"></span>
                        </button>
                    </div>
                </div>

                <!-- Menu Items -->
                <nav class="space-y-2 flex-1">
                    <a href="{{ route('search.index') }}" class="group flex items-center gap-4 px-4 py-4 text-gray-700 dark:text-gray-200 bg-white/50 dark:bg-gray-800/50 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 dark:hover:from-gray-700/50 dark:hover:to-gray-700/50 rounded-2xl transition-all border border-transparent hover:border-purple-200/50 dark:hover:border-gray-600 backdrop-blur-sm hover:shadow-md">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-purple-100 to-pink-100 dark:from-gray-700 dark:to-gray-700 flex items-center justify-center group-hover:scale-110 group-hover:shadow-lg transition-all">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <span class="font-semibold flex-1">{{ __('Search') }}</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 dark:group-hover:text-purple-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    <a href="#" class="group flex items-center gap-4 px-4 py-4 text-gray-700 dark:text-gray-200 bg-white/50 dark:bg-gray-800/50 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-700/50 dark:hover:to-gray-700/50 rounded-2xl transition-all border border-transparent hover:border-blue-200/50 dark:hover:border-gray-600 backdrop-blur-sm hover:shadow-md">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-100 to-purple-100 dark:from-gray-700 dark:to-gray-700 flex items-center justify-center group-hover:scale-110 group-hover:shadow-lg transition-all">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="font-semibold flex-1">{{ __('About us') }}</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    
                    <a href="#" class="group flex items-center gap-4 px-4 py-4 text-gray-700 dark:text-gray-200 bg-white/50 dark:bg-gray-800/50 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-700/50 dark:hover:to-gray-700/50 rounded-2xl transition-all border border-transparent hover:border-blue-200/50 dark:hover:border-gray-600 backdrop-blur-sm hover:shadow-md">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-green-100 to-emerald-100 dark:from-gray-700 dark:to-gray-700 flex items-center justify-center group-hover:scale-110 group-hover:shadow-lg transition-all">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <span class="font-semibold flex-1">{{ __('Contact') }}</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 dark:group-hover:text-green-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    
                    <a href="#" class="group flex items-center gap-4 px-4 py-4 text-gray-700 dark:text-gray-200 bg-white/50 dark:bg-gray-800/50 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-700/50 dark:hover:to-gray-700/50 rounded-2xl transition-all border border-transparent hover:border-blue-200/50 dark:hover:border-gray-600 backdrop-blur-sm hover:shadow-md">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-purple-100 to-pink-100 dark:from-gray-700 dark:to-gray-700 flex items-center justify-center group-hover:scale-110 group-hover:shadow-lg transition-all">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <span class="font-semibold flex-1">{{ __('News') }}</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 dark:group-hover:text-purple-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </nav>

                <!-- Language Switcher and Auth Buttons -->
                <div class="mt-auto pt-3 space-y-3">
                    <div class="p-4 bg-white/60 dark:bg-gray-800/60 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-sm">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 text-center mb-3">{{ __('language_label') }}</p>
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="changeLang('UZB')" id="lang-uzb" class="flex-1 px-4 py-2.5 text-sm font-bold rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-600 hover:text-white dark:hover:from-blue-500 dark:hover:to-purple-600 transition-all shadow-sm hover:shadow-md hover:scale-105">
                                UZB
                            </button>
                            <button onclick="changeLang('RUS')" id="lang-rus" class="flex-1 px-4 py-2.5 text-sm font-bold rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-600 hover:text-white dark:hover:from-blue-500 dark:hover:to-purple-600 transition-all shadow-sm hover:shadow-md hover:scale-105">
                                RUS
                            </button>
                            <button onclick="changeLang('ENG')" id="lang-eng" class="flex-1 px-4 py-2.5 text-sm font-bold rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-600 hover:text-white dark:hover:from-blue-500 dark:hover:to-purple-600 transition-all shadow-sm hover:shadow-md hover:scale-105">
                                ENG
                            </button>
                        </div>
                    </div>

                    @auth
                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-3 px-5 py-4 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-bold rounded-2xl transition-all shadow-lg hover:shadow-xl hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            {{ __('logout') }}
                        </button>
                    </form>
                    @endauth

                    @guest
                    <!-- Login Button -->
                    <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-3 px-5 py-4 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold rounded-2xl transition-all shadow-lg hover:shadow-xl hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Kirish
                    </a>
                    @endguest
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-grow pt-28 pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full z-10">
            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>

        <!-- Bottom Navigation Bar -->
        <div class="fixed bottom-0 left-0 right-0 backdrop-blur-2xl bg-white/60 dark:bg-gray-900/60 border-t border-white/20 dark:border-gray-700/30 z-30 shadow-2xl shadow-gray-200/20 dark:shadow-gray-900/40">
            <div class="grid grid-cols-3 h-16">
                <!-- Home Button -->
                <a href="{{ route('home') }}" class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('home') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400' }} hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="text-xs font-medium">{{ __('home') }}</span>
                </a>

                <!-- Saved Button -->
                <a href="{{ route('places.saved') }}" class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('places.saved') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400' }} hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                    <span class="text-xs font-medium">{{ __('saved') }}</span>
                </a>

                <!-- Map Button -->
                <a href="{{ route('map.index') }}" class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('map.index') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400' }} hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
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
                const modeText = document.getElementById('mode-text');
                if (modeText) modeText.textContent = @json(__('Light mode'));
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                const modeText = document.getElementById('mode-text');
                if (modeText) modeText.textContent = @json(__('Dark mode'));
            }
        }

        // Initialize dark mode on page load
        (function() {
            const theme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (theme === 'dark' || (!theme && prefersDark)) {
                document.documentElement.classList.add('dark');
                const modeText = document.getElementById('mode-text');
                if (modeText) modeText.textContent = @json(__('Dark mode'));
            }
        })();

        function changeLang(lang) {
            let locale = 'en';
            if (lang === 'RUS') locale = 'ru';
            else if (lang === 'UZB') locale = 'uz';
            else if (lang === 'ENG') locale = 'en';
            
            // Create a form and submit it
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/language/${locale}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
            
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
        
        function changeLocation(location) {
            // Store selected location in session storage
            sessionStorage.setItem('selectedLocation', location);
            const locationEl = document.getElementById('current-location');
            if (locationEl) {
                locationEl.textContent = location;
            }

            // Update active location button styling
            const locationButtons = document.querySelectorAll('.location-btn');
            locationButtons.forEach(btn => {
                const btnLocation = btn.getAttribute('data-location');
                if (btnLocation === location) {
                    // Active button - gradient background
                    btn.classList.remove('text-gray-700', 'dark:text-gray-300', 'bg-gray-100/80', 'dark:bg-gray-700/80', 'hover:bg-blue-50', 'hover:text-blue-600', 'dark:hover:bg-gray-600', 'dark:hover:text-blue-400', 'border-transparent', 'hover:border-blue-200', 'dark:hover:border-blue-800');
                    btn.classList.add('text-white', 'bg-gradient-to-br', 'from-blue-500', 'to-purple-600', 'shadow-lg', 'border-blue-400');
                    btn.style.fontWeight = '700';
                } else {
                    // Inactive buttons
                    btn.classList.remove('text-white', 'bg-gradient-to-br', 'from-blue-500', 'to-purple-600', 'shadow-lg', 'border-blue-400');
                    btn.classList.add('text-gray-700', 'dark:text-gray-300', 'bg-gray-100/80', 'dark:bg-gray-700/80', 'hover:bg-blue-50', 'hover:text-blue-600', 'dark:hover:bg-gray-600', 'dark:hover:text-blue-400', 'border-transparent', 'hover:border-blue-200', 'dark:hover:border-blue-800');
                    btn.style.fontWeight = '600';
                }
            });
            
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

            // Update active language button
            const langButtons = {
                'uz': document.getElementById('lang-uzb'),
                'ru': document.getElementById('lang-rus'),
                'en': document.getElementById('lang-eng')
            };

            // Remove active class from all buttons
            Object.values(langButtons).forEach(btn => {
                if (btn) {
                    btn.classList.remove('bg-blue-600', 'text-white', 'font-semibold');
                    btn.classList.add('text-gray-600', 'dark:text-gray-400');
                }
            });

            // Add active class to current language button
            const activeBtn = langButtons[locale] || langButtons['uz'];
            if (activeBtn) {
                activeBtn.classList.remove('text-gray-600', 'dark:text-gray-400');
                activeBtn.classList.add('bg-blue-600', 'text-white', 'font-semibold');
            }
            
            // Restore selected location from session storage
            const savedLocation = sessionStorage.getItem('selectedLocation');
            if (savedLocation) {
                const locationEl = document.getElementById('current-location');
                if (locationEl) {
                    locationEl.textContent = savedLocation;
                }
                // Set active location button
                changeLocation(savedLocation);
            } else {
                // Set default location to Toshkent
                changeLocation('Toshkent');
            }
        });

        // Telegram Web App Initialization
        if (window.Telegram && window.Telegram.WebApp) {
            const tg = window.Telegram.WebApp;
            
            // Expand to full screen
            tg.expand();
            
            // Enable closing confirmation to prevent accidental closure
            tg.enableClosingConfirmation();
            
            // Set header color to match app theme
            tg.setHeaderColor('#ffffff');
            tg.setBackgroundColor('#ffffff');
            
            // Ready the app
            tg.ready();
            
            console.log('Telegram Web App initialized successfully');
            console.log('isExpanded:', tg.isExpanded);
            console.log('viewportHeight:', tg.viewportHeight);
        }
    </script>
</body>
</html>