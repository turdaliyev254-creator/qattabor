<x-admin-layout>
    <div class="min-h-screen bg-gradient-warm p-6 space-y-8">
        <!-- Enhanced Header -->
        <div class="glass-card p-8 animate-fade-in">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div>
                    <h1 class="heading-large text-warm-gray-900 dark:text-white mb-2">Admin Dashboard</h1>
                    <p class="text-warm-gray-600 dark:text-warm-gray-400">Manage your platform and monitor activity</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- Date Range Picker -->
                    <div class="glass-card p-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-warm-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm text-warm-gray-700 dark:text-warm-gray-300">Last 30 days</span>
                    </div>
                    
                    <!-- Export Button -->
                    <button class="btn btn-secondary hover-lift">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export
                    </button>
                </div>
            </div>
        </div>

        <!-- Enhanced Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Categories -->
            <div class="glass-card p-6 hover-lift group animate-fade-in animate-stagger-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/30 dark:to-primary-800/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-warm-gray-900 dark:text-white">{{ $stats['categories'] ?? 48 }}</div>
                        <div class="text-sm text-warm-gray-500 dark:text-warm-gray-400">Categories</div>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="mb-3">
                    <div class="flex justify-between text-xs text-warm-gray-600 dark:text-warm-gray-400 mb-1">
                        <span>Progress</span>
                        <span>85%</span>
                    </div>
                    <div class="w-full bg-warm-gray-200 dark:bg-warm-gray-700 rounded-full h-1.5">
                        <div class="bg-gradient-to-r from-primary-500 to-primary-600 h-1.5 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
                
                <!-- Change Indicator -->
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 mr-1 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    <span class="text-secondary-600 dark:text-secondary-400 font-medium">+8.2%</span>
                    <span class="text-warm-gray-500 ml-1">vs last month</span>
                </div>
            </div>

            <!-- Total Subcategories -->
            <div class="glass-card p-6 hover-lift group animate-fade-in animate-stagger-2">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-secondary-100 to-secondary-200 dark:from-secondary-900/30 dark:to-secondary-800/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-secondary-600 dark:text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-warm-gray-900 dark:text-white">{{ $stats['subcategories'] ?? 156 }}</div>
                        <div class="text-sm text-warm-gray-500 dark:text-warm-gray-400">Subcategories</div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="flex justify-between text-xs text-warm-gray-600 dark:text-warm-gray-400 mb-1">
                        <span>Active</span>
                        <span>92%</span>
                    </div>
                    <div class="w-full bg-warm-gray-200 dark:bg-warm-gray-700 rounded-full h-1.5">
                        <div class="bg-gradient-to-r from-secondary-500 to-secondary-600 h-1.5 rounded-full" style="width: 92%"></div>
                    </div>
                </div>
                
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 mr-1 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    <span class="text-secondary-600 dark:text-secondary-400 font-medium">+12.5%</span>
                    <span class="text-warm-gray-500 ml-1">vs last month</span>
                </div>
            </div>

            <!-- Total Places -->
            <div class="glass-card p-6 hover-lift group animate-fade-in animate-stagger-3">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-accent-100 to-accent-200 dark:from-accent-900/30 dark:to-accent-800/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-warm-gray-900 dark:text-white">{{ $stats['places'] ?? 1234 }}</div>
                        <div class="text-sm text-warm-gray-500 dark:text-warm-gray-400">Places</div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="flex justify-between text-xs text-warm-gray-600 dark:text-warm-gray-400 mb-1">
                        <span>Verified</span>
                        <span>78%</span>
                    </div>
                    <div class="w-full bg-warm-gray-200 dark:bg-warm-gray-700 rounded-full h-1.5">
                        <div class="bg-gradient-to-r from-accent-500 to-accent-600 h-1.5 rounded-full" style="width: 78%"></div>
                    </div>
                </div>
                
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 mr-1 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    <span class="text-secondary-600 dark:text-secondary-400 font-medium">+18.7%</span>
                    <span class="text-warm-gray-500 ml-1">vs last month</span>
                </div>
            </div>

            <!-- Total Users -->
            <div class="glass-card p-6 hover-lift group animate-fade-in animate-stagger-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/30 dark:to-purple-800/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-warm-gray-900 dark:text-white">{{ $stats['users'] ?? 892 }}</div>
                        <div class="text-sm text-warm-gray-500 dark:text-warm-gray-400">Users</div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="flex justify-between text-xs text-warm-gray-600 dark:text-warm-gray-400 mb-1">
                        <span>Active</span>
                        <span>94%</span>
                    </div>
                    <div class="w-full bg-warm-gray-200 dark:bg-warm-gray-700 rounded-full h-1.5">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-1.5 rounded-full" style="width: 94%"></div>
                    </div>
                </div>
                
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 mr-1 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    <span class="text-secondary-600 dark:text-secondary-400 font-medium">+24.3%</span>
                    <span class="text-warm-gray-500 ml-1">vs last month</span>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Activity -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Recent Places -->
                <div class="glass-card animate-fade-in animate-stagger-5">
                    <div class="p-6 border-b border-warm-gray-200 dark:border-warm-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="heading-medium text-warm-gray-900 dark:text-white">Recent Places</h2>
                                <p class="text-sm text-warm-gray-600 dark:text-warm-gray-400 mt-1">Latest additions to your platform</p>
                            </div>
                            <a href="{{ route('admin.places.index') }}" class="btn btn-secondary hover-lift">
                                View All
                            </a>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-warm-gray-50 dark:bg-warm-gray-800/50 text-xs uppercase font-medium text-warm-gray-500 dark:text-warm-gray-400">
                                <tr>
                                    <th class="px-6 py-4 rounded-l-lg">Place</th>
                                    <th class="px-6 py-4">Category</th>
                                    <th class="px-6 py-4">Location</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 rounded-r-lg text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-warm-gray-100 dark:divide-warm-gray-700">
                                @foreach([
                                    ['name' => 'Osh Markazi', 'category' => 'Restaurant', 'location' => 'Chilanzar', 'status' => 'active'],
                                    ['name' => 'Coffee Culture', 'category' => 'Cafe', 'location' => 'Yunusobod', 'status' => 'pending'],
                                    ['name' => 'Green Fitness', 'category' => 'Gym', 'location' => 'Mirzo Ulugbek', 'status' => 'active'],
                                    ['name' => 'Tech Shop', 'category' => 'Electronics', 'location' => 'Shaykhantahur', 'status' => 'active']
                                ] as $place)
                                <tr class="hover:bg-warm-gray-50 dark:hover:bg-warm-gray-800/50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-100 to-secondary-100 dark:from-primary-900/30 dark:to-secondary-900/30 flex items-center justify-center text-sm font-medium text-primary-600 dark:text-primary-400">
                                                {{ substr($place['name'], 0, 2) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-warm-gray-900 dark:text-white">{{ $place['name'] }}</div>
                                                <div class="text-xs text-warm-gray-500">Added 2 hours ago</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="badge badge-primary">{{ $place['category'] }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-warm-gray-600 dark:text-warm-gray-400">{{ $place['location'] }}</td>
                                    <td class="px-6 py-4">
                                        <span class="badge {{ $place['status'] === 'active' ? 'badge-secondary' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' }}">
                                            {{ ucfirst($place['status']) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button class="btn btn-ghost btn-icon p-2 hover:bg-primary-50 hover:text-primary-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </button>
                                            <button class="btn btn-ghost btn-icon p-2 hover:bg-secondary-50 hover:text-secondary-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Analytics Chart Placeholder -->
                <div class="glass-card p-6 animate-fade-in animate-stagger-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="heading-medium text-warm-gray-900 dark:text-white">Platform Growth</h3>
                            <p class="text-sm text-warm-gray-600 dark:text-warm-gray-400 mt-1">Places and users over time</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-primary-500"></div>
                                <span class="text-xs text-warm-gray-600 dark:text-warm-gray-400">Places</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-secondary-500"></div>
                                <span class="text-xs text-warm-gray-600 dark:text-warm-gray-400">Users</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Simulated Chart Area -->
                    <div class="h-64 bg-warm-gray-50 dark:bg-warm-gray-800/50 rounded-xl flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-primary-100 to-secondary-100 dark:from-primary-900/30 dark:to-secondary-900/30 flex items-center justify-center">
                                <svg class="w-8 h-8 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-warm-gray-600 dark:text-warm-gray-400">Analytics chart integration area</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="glass-card p-6 animate-fade-in animate-stagger-7">
                    <h3 class="heading-medium text-warm-gray-900 dark:text-white mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary w-full hover-lift text-left justify-start">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Category
                        </a>
                        <a href="{{ route('admin.places.create') }}" class="btn btn-secondary w-full hover-lift text-left justify-start">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            Add Place
                        </a>
                        <button class="btn btn-ghost w-full hover-lift text-left justify-start">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Generate Report
                        </button>
                    </div>
                </div>

                <!-- System Status -->
                <div class="glass-card p-6 animate-fade-in animate-stagger-8">
                    <h3 class="heading-medium text-warm-gray-900 dark:text-white mb-4">System Status</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-warm-gray-600 dark:text-warm-gray-400">Server Status</span>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-secondary-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-medium text-secondary-600 dark:text-secondary-400">Online</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-warm-gray-600 dark:text-warm-gray-400">Database</span>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-secondary-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-medium text-secondary-600 dark:text-secondary-400">Connected</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-warm-gray-600 dark:text-warm-gray-400">Cache</span>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-medium text-yellow-600 dark:text-yellow-400">Warming</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Notifications -->
                <div class="glass-card p-6 animate-fade-in animate-stagger-9">
                    <h3 class="heading-medium text-warm-gray-900 dark:text-white mb-4">Recent Notifications</h3>
                    <div class="space-y-3">
                        @foreach([
                            ['type' => 'success', 'message' => 'New place approved', 'time' => '5 min ago'],
                            ['type' => 'warning', 'message' => 'Category limit reached', 'time' => '1 hour ago'],
                            ['type' => 'info', 'message' => 'System backup completed', 'time' => '2 hours ago']
                        ] as $notification)
                        <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-warm-gray-50 dark:hover:bg-warm-gray-800/50 transition-colors">
                            <div class="w-8 h-8 rounded-lg 
                                @if($notification['type'] === 'success') bg-secondary-100 dark:bg-secondary-900/30 @endif
                                @if($notification['type'] === 'warning') bg-yellow-100 dark:bg-yellow-900/30 @endif
                                @if($notification['type'] === 'info') bg-primary-100 dark:bg-primary-900/30 @endif
                                flex items-center justify-center">
                                @if($notification['type'] === 'success')
                                    <svg class="w-4 h-4 text-secondary-600 dark:text-secondary-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                @elseif($notification['type'] === 'warning')
                                    <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-warm-gray-900 dark:text-white">{{ $notification['message'] }}</p>
                                <p class="text-xs text-warm-gray-500 mt-1">{{ $notification['time'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>