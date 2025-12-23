<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="py-8 min-h-screen bg-gradient-warm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <!-- Enhanced Welcome Hero -->
            <div class="glass-card animate-fade-in relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(245,158,11,0.3) 1px, transparent 0); background-size: 20px 20px;"></div>
                </div>
                
                <div class="relative z-10 p-8">
                    <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center animate-glow">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="heading-large text-warm-gray-900 dark:text-white">{{ __("Welcome back!") }}</h1>
                                    <p class="text-warm-gray-600 dark:text-warm-gray-400 mt-1">{{ __("Ready to explore amazing places today?") }}</p>
                                </div>
                            </div>
                            
                            <!-- Quick Stats -->
                            <div class="grid grid-cols-3 gap-4 mt-6">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-primary-600 dark:text-primary-400">1,234</div>
                                    <div class="text-xs text-warm-gray-500">Places Visited</div>
                                </div>
                                <div class="text-center border-l border-r border-warm-gray-200 dark:border-warm-gray-700">
                                    <div class="text-2xl font-bold text-secondary-600 dark:text-secondary-400">89</div>
                                    <div class="text-xs text-warm-gray-500">Favorites</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-accent-500">15</div>
                                    <div class="text-xs text-warm-gray-500">Reviews</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button class="btn btn-primary hover-lift">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Discover Places
                            </button>
                            <button class="btn btn-secondary hover-lift">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                View Saved
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Places -->
                <div class="glass-card card-hover p-6 animate-fade-in animate-stagger-1 group">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-warm-gray-600 dark:text-warm-gray-400 mb-2">Total Places</p>
                            <p class="text-3xl font-bold text-warm-gray-900 dark:text-white mb-1">1,234</p>
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 mr-1 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                </svg>
                                <span class="text-secondary-600 dark:text-secondary-400 font-medium">+12.5%</span>
                                <span class="text-warm-gray-500 ml-1">from last month</span>
                            </div>
                        </div>
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/30 dark:to-primary-800/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div class="glass-card card-hover p-6 animate-fade-in animate-stagger-2 group">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-warm-gray-600 dark:text-warm-gray-400 mb-2">Categories</p>
                            <p class="text-3xl font-bold text-warm-gray-900 dark:text-white mb-1">48</p>
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 mr-1 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                </svg>
                                <span class="text-secondary-600 dark:text-secondary-400 font-medium">+8.2%</span>
                                <span class="text-warm-gray-500 ml-1">from last month</span>
                            </div>
                        </div>
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-secondary-100 to-secondary-200 dark:from-secondary-900/30 dark:to-secondary-800/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-secondary-600 dark:text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Saved Places -->
                <div class="glass-card card-hover p-6 animate-fade-in animate-stagger-3 group">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-warm-gray-600 dark:text-warm-gray-400 mb-2">Saved Places</p>
                            <p class="text-3xl font-bold text-warm-gray-900 dark:text-white mb-1">56</p>
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 mr-1 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                </svg>
                                <span class="text-accent-600 dark:text-accent-400 font-medium">+15.3%</span>
                                <span class="text-warm-gray-500 ml-1">from last month</span>
                            </div>
                        </div>
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-accent-100 to-accent-200 dark:from-accent-900/30 dark:to-accent-800/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Reviews Written -->
                <div class="glass-card card-hover p-6 animate-fade-in animate-stagger-4 group">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-warm-gray-600 dark:text-warm-gray-400 mb-2">Reviews Written</p>
                            <p class="text-3xl font-bold text-warm-gray-900 dark:text-white mb-1">23</p>
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 mr-1 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                </svg>
                                <span class="text-secondary-600 dark:text-secondary-400 font-medium">+4.8%</span>
                                <span class="text-warm-gray-500 ml-1">from last month</span>
                            </div>
                        </div>
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-yellow-100 to-yellow-200 dark:from-yellow-900/30 dark:to-yellow-800/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Activity -->
                <div class="lg:col-span-2">
                    <div class="glass-card animate-fade-in animate-stagger-5">
                        <!-- Header -->
                        <div class="p-6 border-b border-warm-gray-200 dark:border-warm-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="heading-medium text-warm-gray-900 dark:text-white">Recent Activity</h2>
                                    <p class="text-sm text-warm-gray-600 dark:text-warm-gray-400 mt-1">Your latest discoveries and interactions</p>
                                </div>
                                <button class="btn btn-secondary btn-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Activity List -->
                        <div class="divide-y divide-warm-gray-100 dark:divide-warm-gray-700">
                            @foreach([
                                ['action' => 'visited', 'place' => 'Coffee Culture Cafe', 'time' => '2 hours ago', 'icon' => 'coffee'],
                                ['action' => 'saved', 'place' => 'Green Fitness Center', 'time' => '5 hours ago', 'icon' => 'heart'],
                                ['action' => 'reviewed', 'place' => 'Osh Markazi Restaurant', 'time' => '1 day ago', 'icon' => 'star'],
                                ['action' => 'discovered', 'place' => 'Central Park', 'time' => '2 days ago', 'icon' => 'location']
                            ] as $index => $activity)
                            <div class="p-6 hover:bg-warm-gray-50 dark:hover:bg-warm-gray-800/50 transition-colors group animate-fade-in animate-stagger-{{ $index + 1 }}">
                                <div class="flex items-start gap-4">
                                    <!-- Activity Icon -->
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br 
                                        @if($activity['icon'] === 'coffee') from-amber-100 to-amber-200 dark:from-amber-900/30 dark:to-amber-800/30 @endif
                                        @if($activity['icon'] === 'heart') from-red-100 to-red-200 dark:from-red-900/30 dark:to-red-800/30 @endif
                                        @if($activity['icon'] === 'star') from-yellow-100 to-yellow-200 dark:from-yellow-900/30 dark:to-yellow-800/30 @endif
                                        @if($activity['icon'] === 'location') from-green-100 to-green-200 dark:from-green-900/30 dark:to-green-800/30 @endif
                                        flex items-center justify-center group-hover:scale-110 transition-transform">
                                        @if($activity['icon'] === 'coffee')
                                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM4 8a1 1 0 000 2h1v6h1a1 1 0 100-2V8H4z"/>
                                            </svg>
                                        @elseif($activity['icon'] === 'heart')
                                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                                            </svg>
                                        @elseif($activity['icon'] === 'star')
                                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    
                                    <!-- Activity Content -->
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-warm-gray-900 dark:text-white">
                                            You <span class="font-medium text-primary-600 dark:text-primary-400">{{ $activity['action'] }}</span>
                                            <span class="font-medium">{{ $activity['place'] }}</span>
                                        </p>
                                        <p class="text-xs text-warm-gray-500 mt-1">{{ $activity['time'] }}</p>
                                    </div>
                                    
                                    <!-- Action Button -->
                                    <button class="opacity-0 group-hover:opacity-100 transition-opacity btn btn-ghost btn-icon p-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- View All Button -->
                        <div class="p-6 border-t border-warm-gray-200 dark:border-warm-gray-700">
                            <button class="btn btn-secondary w-full hover-lift">
                                View All Activity
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Stats Card -->
                    <div class="glass-card animate-fade-in animate-stagger-6">
                        <div class="p-6 border-b border-warm-gray-200 dark:border-warm-gray-700">
                            <h3 class="heading-medium text-warm-gray-900 dark:text-white">Your Impact</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-warm-gray-600 dark:text-warm-gray-400">Profile Views</span>
                                <span class="text-lg font-semibold text-warm-gray-900 dark:text-white">892</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-warm-gray-600 dark:text-warm-gray-400">Review Likes</span>
                                <span class="text-lg font-semibold text-warm-gray-900 dark:text-white">156</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-warm-gray-600 dark:text-warm-gray-400">Followers</span>
                                <span class="text-lg font-semibold text-warm-gray-900 dark:text-white">43</span>
                            </div>
                        </div>
                    </div>

                    <!-- Recommended Places -->
                    <div class="glass-card animate-fade-in animate-stagger-7">
                        <div class="p-6 border-b border-warm-gray-200 dark:border-warm-gray-700">
                            <h3 class="heading-medium text-warm-gray-900 dark:text-white">Recommended for You</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            @foreach([
                                ['name' => 'Artisan Bakery', 'category' => 'Cafe', 'rating' => '4.8'],
                                ['name' => 'Urban Garden', 'category' => 'Park', 'rating' => '4.6'],
                                ['name' => 'Night Market', 'category' => 'Shopping', 'rating' => '4.7']
                            ] as $place)
                            <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-warm-gray-50 dark:hover:bg-warm-gray-800/50 transition-colors cursor-pointer group">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-100 to-secondary-100 dark:from-primary-900/30 dark:to-secondary-900/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-warm-gray-900 dark:text-white text-sm">{{ $place['name'] }}</h4>
                                    <p class="text-xs text-warm-gray-500">{{ $place['category'] }}</p>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-xs font-medium text-warm-gray-700 dark:text-warm-gray-300">{{ $place['rating'] }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Achievement Badge -->
                    <div class="glass-card bg-gradient-primary text-white animate-fade-in animate-stagger-8">
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center animate-glow">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            </div>
                            <h3 class="font-bold mb-2">Local Explorer</h3>
                            <p class="text-sm text-white/90">You've visited 25+ places this month!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>