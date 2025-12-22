<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Card -->
            <div class="card animate-fade-in">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-brand-500 to-accent-500 flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __("Welcome back!") }}</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-0.5">{{ __("You're logged in and ready to explore.") }}</p>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Total Places -->
                <div class="card card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Total Places</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">1,234</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-100 to-brand-200 dark:from-brand-900/20 dark:to-brand-800/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div class="card card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Categories</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">48</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-accent-100 to-accent-200 dark:from-accent-900/20 dark:to-accent-800/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Saved -->
                <div class="card card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Saved</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">56</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900/20 dark:to-green-800/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
