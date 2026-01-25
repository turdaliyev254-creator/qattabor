<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'QattaBor') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Telegram Web App Script -->
    <script src="https://telegram.org/js/telegram-web-app.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Page Transition Styles -->
    <style>
        body {
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.4s ease-out, transform 0.4s ease-out;
        }
        body.loaded {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="font-sans antialiased h-full bg-gradient-to-br from-blue-50/50 via-white to-purple-50/30 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <script>
        // Remove loading state when page is fully loaded
        window.addEventListener('load', function() {
            document.body.classList.add('loaded');
        });
    </script>
    <div x-data="{ open: false }" class="min-h-screen flex flex-col relative overflow-hidden">
        <!-- Subtle Background Pattern -->
        <div class="absolute inset-0 bg-grid-pattern opacity-[0.015] dark:opacity-[0.05]"></div>

        <!-- Header -->
        <header class="fixed top-0 w-full z-50 transition-all duration-300 backdrop-blur-2xl bg-white/60 dark:bg-gray-900/60 border-b border-white/20 dark:border-gray-700/30 shadow-lg shadow-gray-200/20 dark:shadow-gray-900/40" id="navbar">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-20 items-center justify-between">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 group" onclick="return navigateWithLocation(event, '{{ route('home') }}')">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl blur-sm opacity-50 group-hover:opacity-75 transition-opacity"></div>
                                <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg transform group-hover:scale-105 transition-transform">
                                    <x-application-logo class="w-7 h-7 text-white" />
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
                                    <x-application-logo class="w-3 h-3 text-white" />
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
                                 class="absolute right-0 mt-3 w-64 lg:w-80 bg-white/95 dark:bg-gray-800/95 backdrop-blur-2xl rounded-3xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 p-4 lg:p-6 max-h-[400px] lg:max-h-[520px] overflow-y-auto z-[70]"
                                 style="display: none;">
                                <div class="flex items-center justify-between mb-4 lg:mb-5">
                                    <h3 class="text-base lg:text-lg font-bold text-gray-900 dark:text-white">{{ __('select_region') }}</h3>
                                    <button @click="locationOpen = false" class="p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="grid grid-cols-2 gap-2 lg:gap-2.5" id="location-buttons">
                                    @foreach($regions as $region)
                                        <button onclick="changeLocation('{{ $region->localized_name }}')" data-location="{{ $region->localized_name }}" class="location-btn px-3 lg:px-4 py-2.5 lg:py-3.5 text-xs lg:text-sm text-center font-semibold text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-600 dark:hover:text-blue-400 transition-all border border-transparent hover:border-blue-200 dark:hover:border-blue-800">{{ $region->localized_name }}</button>
                                    @endforeach
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
             class="fixed top-0 right-0 h-full w-80 bg-gradient-to-b from-white via-blue-50/30 to-purple-50/30 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 shadow-2xl z-50 overflow-y-auto overscroll-contain backdrop-blur-xl"
             style="-webkit-overflow-scrolling: touch;">
            
            <div class="p-6 h-full flex flex-col">
                <!-- Header with Logo and Close -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3 group">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl blur-sm opacity-50 group-hover:opacity-75 transition-opacity"></div>
                            <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                                <x-application-logo class="w-7 h-7 text-white" />
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
                <a href="{{ route('dashboard') }}" class="block mb-6 p-5 bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800/80 dark:to-gray-800/60 rounded-3xl border border-blue-100/50 dark:border-gray-700/50 backdrop-blur-sm shadow-sm hover:shadow-md transition-all cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" 
                                     class="w-14 h-14 rounded-2xl object-cover shadow-lg">
                            @else
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></div>
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-gray-900 dark:text-white text-lg">{{ auth()->user()->name }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">{{ Str::mask(auth()->user()->phone, '*', 7) }}</div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
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
                    <a href="{{ route('about') }}" class="group flex items-center gap-3 px-3 py-3 text-gray-700 dark:text-gray-200 bg-white/50 dark:bg-gray-800/50 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-700/50 dark:hover:to-gray-700/50 rounded-xl transition-all border border-transparent hover:border-blue-200/50 dark:hover:border-gray-600 backdrop-blur-sm hover:shadow-md">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-100 to-purple-100 dark:from-gray-700 dark:to-gray-700 flex items-center justify-center group-hover:scale-110 group-hover:shadow-lg transition-all">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="font-semibold flex-1 text-sm">{{ __('About us') }}</span>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    
                    <a href="{{ route('contact') }}" class="group flex items-center gap-3 px-3 py-3 text-gray-700 dark:text-gray-200 bg-white/50 dark:bg-gray-800/50 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-700/50 dark:hover:to-gray-700/50 rounded-xl transition-all border border-transparent hover:border-blue-200/50 dark:hover:border-gray-600 backdrop-blur-sm hover:shadow-md">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-green-100 to-emerald-100 dark:from-gray-700 dark:to-gray-700 flex items-center justify-center group-hover:scale-110 group-hover:shadow-lg transition-all">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <span class="font-semibold flex-1 text-sm">{{ __('Contact') }}</span>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-green-600 dark:group-hover:text-green-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    
                    <a href="{{ route('news') }}" class="group flex items-center gap-3 px-3 py-3 text-gray-700 dark:text-gray-200 bg-white/50 dark:bg-gray-800/50 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-700/50 dark:hover:to-gray-700/50 rounded-xl transition-all border border-transparent hover:border-blue-200/50 dark:hover:border-gray-600 backdrop-blur-sm hover:shadow-md">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-purple-100 to-pink-100 dark:from-gray-700 dark:to-gray-700 flex items-center justify-center group-hover:scale-110 group-hover:shadow-lg transition-all">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <span class="font-semibold flex-1 text-sm">{{ __('News') }}</span>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-purple-600 dark:group-hover:text-purple-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </nav>

                <!-- Language Switcher and Auth Buttons -->
                <div class="mt-auto pt-3 space-y-3">
                    <div class="p-3 bg-white/60 dark:bg-gray-800/60 rounded-xl border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-sm">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 text-center mb-2">{{ __('language_label') }}</p>
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="changeLang('UZB')" id="lang-uzb" class="flex-1 px-3 py-2 text-xs font-bold rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-600 hover:text-white dark:hover:from-blue-500 dark:hover:to-purple-600 transition-all shadow-sm hover:shadow-md hover:scale-105">
                                UZB
                            </button>
                            <button onclick="changeLang('RUS')" id="lang-rus" class="flex-1 px-3 py-2 text-xs font-bold rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-600 hover:text-white dark:hover:from-blue-500 dark:hover:to-purple-600 transition-all shadow-sm hover:shadow-md hover:scale-105">
                                RUS
                            </button>
                            <button onclick="changeLang('ENG')" id="lang-eng" class="flex-1 px-3 py-2 text-xs font-bold rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-600 hover:text-white dark:hover:from-blue-500 dark:hover:to-purple-600 transition-all shadow-sm hover:shadow-md hover:scale-105">
                                ENG
                            </button>
                        </div>
                    </div>

                    @auth
                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-bold text-sm rounded-xl transition-all shadow-lg hover:shadow-xl hover:scale-105">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            {{ __('logout') }}
                        </button>
                    </form>
                    @endauth

                    @guest
                    <!-- Login Button -->
                    <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold text-sm rounded-xl transition-all shadow-lg hover:shadow-xl hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Kirish
                    </a>
                    @endguest
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-grow pt-28 pb-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full z-10">
            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>

        <!-- Geolocation Permission Modal -->
        <div id="geolocation-modal" x-data="{ show: false }" x-show="show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
             style="display: none;">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-md w-full p-8 relative">
                
                <!-- Icon -->
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Title -->
                <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-4">
                    {{ __('Detect Your Location') }}
                </h2>
                
                <!-- Description -->
                <p class="text-center text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                    {{ __('We would like to use your location to show you nearby places and relevant content for your region. Your privacy is important to us.') }}
                </p>
                
                <!-- Buttons -->
                <div class="space-y-3">
                    <button onclick="requestGeolocation()" 
                            class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold rounded-2xl transition-all shadow-lg hover:shadow-xl hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ __('Use My Location') }}
                    </button>
                    
                    <button onclick="showManualSelector()" 
                            class="w-full px-6 py-4 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-bold rounded-2xl transition-all">
                        {{ __('Choose Manually') }}
                    </button>
                </div>
                
                <!-- Privacy Note -->
                <p class="text-xs text-center text-gray-500 dark:text-gray-400 mt-6">
                    {{ __('Your location data is not stored and is only used for this session.') }}
                </p>
            </div>
        </div>

        <!-- Loading Spinner Modal -->
        <div id="loading-modal" x-data="{ show: false }" x-show="show" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
             style="display: none;">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 text-center">
                <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-blue-500 mx-auto mb-4"></div>
                <p class="text-gray-700 dark:text-gray-300 font-semibold">{{ __('Detecting your location...') }}</p>
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
        // Geolocation Functions
        let geolocationModalShown = false;

        function showGeolocationModal() {
            if (!geolocationModalShown) {
                const modal = document.getElementById('geolocation-modal');
                if (modal && modal.__x) {
                    modal.__x.$data.show = true;
                    geolocationModalShown = true;
                }
            }
        }

        function hideGeolocationModal() {
            const modal = document.getElementById('geolocation-modal');
            if (modal && modal.__x) {
                modal.__x.$data.show = false;
            }
        }

        function showLoadingModal() {
            const modal = document.getElementById('loading-modal');
            if (modal && modal.__x) {
                modal.__x.$data.show = true;
            }
        }

        function hideLoadingModal() {
            const modal = document.getElementById('loading-modal');
            if (modal && modal.__x) {
                modal.__x.$data.show = false;
            }
        }

        function requestGeolocation() {
            hideGeolocationModal();
            showLoadingModal();
            
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        detectRegionFromCoordinates(lat, lon);
                    },
                    function(error) {
                        hideLoadingModal();
                        console.log("Geolocation error:", error);
                        alert(@json(__('Could not access your location. Please select manually.')));
                        showManualSelector();
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                hideLoadingModal();
                alert(@json(__('Geolocation is not supported by your browser.')));
                showManualSelector();
            }
        }

        async function detectRegionFromCoordinates(lat, lon) {
            try {
                const response = await fetch('/api/detect-region', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ lat, lon })
                });
                
                const data = await response.json();
                hideLoadingModal();
                
                if (data.success && data.region) {
                    // Auto-select the detected region
                    selectInitialLocation(data.region, true);
                } else {
                    // Show manual selector if detection failed or outside Uzbekistan
                    if (data.message && data.message.includes('outside Uzbekistan')) {
                        alert(@json(__('You appear to be outside Uzbekistan. Please select a region manually.')));
                    }
                    showManualSelector();
                }
            } catch (error) {
                hideLoadingModal();
                console.error('Region detection error:', error);
                alert(@json(__('Could not detect region. Please select manually.')));
                showManualSelector();
            }
        }

        function showManualSelector() {
            hideGeolocationModal();
            // Trigger the location dropdown
            setTimeout(() => {
                const locationButton = document.querySelector('[x-data*="locationOpen"]');
                if (locationButton && locationButton.__x) {
                    locationButton.__x.$data.locationOpen = true;
                }
            }, 100);
        }

        function selectInitialLocation(location, isAutoDetected = false) {
            sessionStorage.setItem('selectedLocation', location);
            sessionStorage.setItem('locationAutoDetected', isAutoDetected ? 'true' : 'false');
            
            const locationEl = document.getElementById('current-location');
            if (locationEl) {
                locationEl.textContent = location;
            }
            
            // Update active button styling
            updateLocationButtonStyling(location);
            
            // Update URL and reload to apply filter
            const url = new URL(window.location);
            url.searchParams.set('region', location);
            window.location.href = url.toString();
        }

        function updateLocationButtonStyling(location) {
            const locationButtons = document.querySelectorAll('.location-btn');
            locationButtons.forEach(btn => {
                const btnLocation = btn.getAttribute('data-location');
                if (btnLocation === location) {
                    btn.classList.remove('text-gray-700', 'dark:text-gray-300', 'bg-gray-100/80', 'dark:bg-gray-700/80', 'hover:bg-blue-50', 'hover:text-blue-600', 'dark:hover:bg-gray-600', 'dark:hover:text-blue-400', 'border-transparent', 'hover:border-blue-200', 'dark:hover:border-blue-800');
                    btn.classList.add('text-white', 'bg-gradient-to-br', 'from-blue-500', 'to-purple-600', 'shadow-lg', 'border-blue-400');
                    btn.style.fontWeight = '700';
                }
            });
        }

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
        
        // Function to navigate with location parameter
        function navigateWithLocation(event, url) {
            const selectedLocation = sessionStorage.getItem('selectedLocation');
            if (selectedLocation) {
                event.preventDefault();
                const targetUrl = new URL(url, window.location.origin);
                targetUrl.searchParams.set('region', selectedLocation);
                window.location.href = targetUrl.toString();
                return false;
            }
            return true;
        }
        
        // Modified changeLocation function
        function changeLocation(location) {
            sessionStorage.setItem('selectedLocation', location);
            sessionStorage.setItem('locationAutoDetected', 'false'); // Manual override
            
            const locationEl = document.getElementById('current-location');
            if (locationEl) {
                locationEl.textContent = location;
            }

            updateLocationButtonStyling(location);
            
            const url = new URL(window.location);
            url.searchParams.set('region', location);
            window.location.href = url.toString();
        }
        
        // Enhanced DOMContentLoaded
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

            Object.values(langButtons).forEach(btn => {
                if (btn) {
                    btn.classList.remove('bg-blue-600', 'text-white', 'font-semibold');
                    btn.classList.add('text-gray-600', 'dark:text-gray-400');
                }
            });

            const activeBtn = langButtons[locale] || langButtons['uz'];
            if (activeBtn) {
                activeBtn.classList.remove('text-gray-600', 'dark:text-gray-400');
                activeBtn.classList.add('bg-blue-600', 'text-white', 'font-semibold');
            }
            
            // Location Detection Logic
            const urlParams = new URLSearchParams(window.location.search);
            const regionParam = urlParams.get('region');
            const savedLocation = sessionStorage.getItem('selectedLocation');
            const isAutoDetected = sessionStorage.getItem('locationAutoDetected') === 'true';
            
            // If no location is set, show geolocation modal
            if (!regionParam && !savedLocation) {
                // Show modal after a short delay for better UX
                setTimeout(() => {
                    showGeolocationModal();
                }, 500);
            } else {
                // Use existing location
                const currentLocation = regionParam || savedLocation;
                
                if (currentLocation) {
                    const locationEl = document.getElementById('current-location');
                    if (locationEl) {
                        locationEl.textContent = currentLocation;
                    }
                    updateLocationButtonStyling(currentLocation);
                    sessionStorage.setItem('selectedLocation', currentLocation);
                    
                    // Add region to URL if not present
                    if (!regionParam && currentLocation) {
                        const url = new URL(window.location);
                        url.searchParams.set('region', currentLocation);
                        window.history.replaceState({}, '', url.toString());
                    }
                }
            }
        });

        // Telegram Web App Initialization
        if (window.Telegram && window.Telegram.WebApp) {
            const tg = window.Telegram.WebApp;
            
            // Expand to full screen
            tg.expand();
            
            // Lock viewport height to prevent header bouncing
            tg.lockOrientation();
            
            // Disable vertical swipes to prevent app closure on scroll
            tg.disableVerticalSwipes();
            
            // Enable closing confirmation to prevent accidental closure
            tg.enableClosingConfirmation();
            
            // Set header color to match app theme
            tg.setHeaderColor('#ffffff');
            tg.setBackgroundColor('#ffffff');
            
            // Prevent body scroll and fix viewport
            document.body.style.overflow = 'hidden';
            document.documentElement.style.overflow = 'hidden';
            document.body.style.position = 'fixed';
            document.body.style.width = '100%';
            document.body.style.height = tg.viewportHeight + 'px';
            
            // Update height on viewport changes
            tg.onEvent('viewportChanged', function() {
                document.body.style.height = tg.viewportHeight + 'px';
            });
            
            // Ready the app
            tg.ready();
            
            console.log('Telegram Web App initialized successfully');
            console.log('isExpanded:', tg.isExpanded);
            console.log('viewportHeight:', tg.viewportHeight);
        }
    </script>

    <!-- Mobile Bottom Navigation -->
    <nav class="sticky bottom-0 left-0 right-0 z-30 lg:hidden mt-auto">
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-t border-gray-200/50 dark:border-gray-700/50 shadow-2xl mx-4 mb-4 rounded-full">
            <div class="grid grid-cols-3 h-16 px-4">
                <!-- Home -->
                <a href="{{ route('home') }}" class="flex flex-col items-center justify-center gap-1 {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-blue-600 dark:hover:text-blue-400 transition-colors btn-hover" onclick="return navigateWithLocation(event, '{{ route('home') }}')">
                    <svg class="w-6 h-6" fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-xs font-medium">{{ __('home') }}</span>
                </a>

                <!-- Saved -->
                <a href="{{ route('places.saved') }}" class="flex flex-col items-center justify-center gap-1 {{ request()->routeIs('places.saved') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-blue-600 dark:hover:text-blue-400 transition-colors btn-hover">
                    <svg class="w-6 h-6" fill="{{ request()->routeIs('places.saved') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                    <span class="text-xs font-medium">{{ __('saved') }}</span>
                </a>

                <!-- Map -->
                <a href="{{ route('map.index') }}" class="flex flex-col items-center justify-center gap-1 {{ request()->routeIs('map.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-blue-600 dark:hover:text-blue-400 transition-colors btn-hover">
                    <svg class="w-6 h-6" fill="{{ request()->routeIs('map.*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    <span class="text-xs font-medium">{{ __('map') }}</span>
                </a>
            </div>
        </div>
    </nav>

</body>
</html>