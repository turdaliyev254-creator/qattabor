<x-glass-layout>
    <!-- Banner Slider -->
    <div class="relative w-full h-80 md:h-[500px] rounded-b-3xl overflow-hidden shadow-2xl mb-12 group -mt-24">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-black/30 z-10"></div>
        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" alt="Banner" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        <div class="absolute bottom-0 left-0 p-8 z-20 w-full">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 drop-shadow-lg tracking-tight">Discover<br>Tashkent</h1>
            <div class="flex items-center gap-4">
                <p class="text-white/90 text-lg backdrop-blur-md bg-white/10 inline-block px-6 py-3 rounded-2xl border border-white/20 shadow-lg">Find the best places near you</p>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="relative -mt-20 mb-12 px-4 z-30">
        <div class="glass-card p-2 rounded-2xl flex items-center shadow-xl max-w-2xl mx-auto bg-white/60 dark:bg-gray-800/60 backdrop-blur-xl border border-white/40">
            <div class="p-3 text-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" placeholder="Search places, categories..." class="w-full bg-transparent border-none focus:ring-0 text-gray-800 dark:text-white placeholder-gray-500 text-lg h-12">
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-medium transition-colors shadow-lg shadow-indigo-500/30">
                Search
            </button>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="mb-12">
        <div class="flex justify-between items-end mb-6 px-2">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Categories</h2>
            <a href="#" class="text-indigo-600 dark:text-indigo-400 font-medium hover:underline">See All</a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($categories as $category)
                <a href="#" class="glass-card p-6 rounded-3xl flex flex-col items-center justify-center gap-4 hover:bg-white/50 dark:hover:bg-gray-800/50 transition-all duration-300 group border border-white/40 shadow-lg hover:shadow-xl hover:-translate-y-1">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-100 to-white dark:from-indigo-900 dark:to-gray-800 flex items-center justify-center text-4xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                        {{ $category->icon ?? '📍' }}
                    </div>
                    <span class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ $category->name }}</span>
                </a>
            @empty
                <!-- Demo Categories if DB is empty -->
                <a href="#" class="glass-card p-6 rounded-3xl flex flex-col items-center justify-center gap-4 hover:bg-white/50 dark:hover:bg-gray-800/50 transition-all duration-300 group border border-white/40 shadow-lg hover:shadow-xl hover:-translate-y-1">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-100 to-white dark:from-blue-900 dark:to-gray-800 flex items-center justify-center text-4xl shadow-inner group-hover:scale-110 transition-transform duration-300">🏫</div>
                    <span class="font-bold text-lg text-gray-800 dark:text-gray-100">School</span>
                </a>
                <a href="#" class="glass-card p-6 rounded-3xl flex flex-col items-center justify-center gap-4 hover:bg-white/50 dark:hover:bg-gray-800/50 transition-all duration-300 group border border-white/40 shadow-lg hover:shadow-xl hover:-translate-y-1">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-green-100 to-white dark:from-green-900 dark:to-gray-800 flex items-center justify-center text-4xl shadow-inner group-hover:scale-110 transition-transform duration-300">🧸</div>
                    <span class="font-bold text-lg text-gray-800 dark:text-gray-100">Kindergarten</span>
                </a>
                <a href="#" class="glass-card p-6 rounded-3xl flex flex-col items-center justify-center gap-4 hover:bg-white/50 dark:hover:bg-gray-800/50 transition-all duration-300 group border border-white/40 shadow-lg hover:shadow-xl hover:-translate-y-1">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-red-100 to-white dark:from-red-900 dark:to-gray-800 flex items-center justify-center text-4xl shadow-inner group-hover:scale-110 transition-transform duration-300">🏥</div>
                    <span class="font-bold text-lg text-gray-800 dark:text-gray-100">Clinic</span>
                </a>
                <a href="#" class="glass-card p-6 rounded-3xl flex flex-col items-center justify-center gap-4 hover:bg-white/50 dark:hover:bg-gray-800/50 transition-all duration-300 group border border-white/40 shadow-lg hover:shadow-xl hover:-translate-y-1">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-orange-100 to-white dark:from-orange-900 dark:to-gray-800 flex items-center justify-center text-4xl shadow-inner group-hover:scale-110 transition-transform duration-300">🍔</div>
                    <span class="font-bold text-lg text-gray-800 dark:text-gray-100">Food</span>
                </a>
                <a href="#" class="glass-card p-6 rounded-3xl flex flex-col items-center justify-center gap-4 hover:bg-white/50 dark:hover:bg-gray-800/50 transition-all duration-300 group border border-white/40 shadow-lg hover:shadow-xl hover:-translate-y-1">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-purple-100 to-white dark:from-purple-900 dark:to-gray-800 flex items-center justify-center text-4xl shadow-inner group-hover:scale-110 transition-transform duration-300">🏋️</div>
                    <span class="font-bold text-lg text-gray-800 dark:text-gray-100">Gym</span>
                </a>
            @endforelse
        </div>
    </div>

    <!-- Popular Places Section -->
    <div class="mb-12">
        <div class="flex justify-between items-end mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Popular Places</h2>
            <a href="#" class="text-indigo-600 dark:text-indigo-400 font-medium hover:underline">See All</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($popularPlaces as $place)
                <div class="glass-card rounded-3xl overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $place->image_url ?? 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1074&q=80' }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute top-4 right-4 bg-white/30 backdrop-blur-md border border-white/20 rounded-full px-3 py-1 text-xs font-bold text-white">
                            {{ $place->category->name ?? 'Restaurant' }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $place->name }}</h3>
                        <div class="flex items-center text-gray-600 dark:text-gray-300 mb-4 text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $place->location->name ?? 'Tashkent' }}
                        </div>
                        <button class="w-full py-3 rounded-xl bg-indigo-600/90 hover:bg-indigo-700 text-white font-semibold shadow-lg shadow-indigo-500/30 transition-all">
                            View Details
                        </button>
                    </div>
                </div>
            @empty
                <!-- Demo Place -->
                <div class="glass-card rounded-3xl overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" alt="Place" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute top-4 right-4 bg-white/30 backdrop-blur-md border border-white/20 rounded-full px-3 py-1 text-xs font-bold text-white">
                            Restaurant
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Osh Markazi</h3>
                        <div class="flex items-center text-gray-600 dark:text-gray-300 mb-4 text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Chilanzar, Tashkent
                        </div>
                        <button class="w-full py-3 rounded-xl bg-indigo-600/90 hover:bg-indigo-700 text-white font-semibold shadow-lg shadow-indigo-500/30 transition-all">
                            View Details
                        </button>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-glass-layout>
