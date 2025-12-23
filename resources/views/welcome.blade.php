<x-glass-layout>
    <!-- Search Bar -->
    <div class="mb-8">
        <div class="relative">
            <input type="text" 
                   placeholder="Nima qidiramiz..." 
                   class="w-full pl-12 pr-16 py-4 bg-white dark:bg-gray-800/90 backdrop-blur-xl border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <button class="absolute right-3 top-1/2 -translate-y-1/2 p-2 bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Hero Banner -->
    <div class="relative w-full h-96 rounded-3xl overflow-hidden mb-8 shadow-xl">
        <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" 
             alt="Modern house" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
        
        <!-- Carousel dots -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2">
            <div class="w-2 h-2 rounded-full bg-white"></div>
            <div class="w-2 h-2 rounded-full bg-white/50"></div>
            <div class="w-2 h-2 rounded-full bg-white/50"></div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Kategoriyalar</h2>
            <a href="{{ route('categories.all') }}" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">Barchasi</a>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-4 gap-4">
            <!-- Mebel -->
            <a href="#" class="flex flex-col items-center gap-3 p-4 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center p-3">
                    <img src="{{ asset('size-512/images/sofa.png') }}" alt="Mebel" class="w-full h-full object-contain">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">Mebel</span>
            </a>

            <!-- Hayvonot bog'i -->
            <a href="#" class="flex flex-col items-center gap-3 p-4 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all">
                <div class="w-16 h-16 rounded-2xl bg-orange-50 dark:bg-orange-900/30 flex items-center justify-center p-3">
                    <img src="{{ asset('size-512/images/lion.png') }}" alt="Hayvonot bog'i" class="w-full h-full object-contain">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">Hayvonot bog'i</span>
            </a>

            <!-- Supermarket -->
            <a href="#" class="flex flex-col items-center gap-3 p-4 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all">
                <div class="w-16 h-16 rounded-2xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center p-3">
                    <img src="{{ asset('size-512/images/supermarket.png') }}" alt="Supermarket" class="w-full h-full object-contain">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">Supermarket</span>
            </a>

            <!-- SPA -->
            <a href="#" class="flex flex-col items-center gap-3 p-4 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all">
                <div class="w-16 h-16 rounded-2xl bg-yellow-50 dark:bg-yellow-900/30 flex items-center justify-center p-3">
                    <img src="{{ asset('size-512/images/spa.png') }}" alt="SPA" class="w-full h-full object-contain">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">SPA</span>
            </a>

            <!-- Foto Studio -->
            <a href="#" class="flex flex-col items-center gap-3 p-4 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all">
                <div class="w-16 h-16 rounded-2xl bg-gray-50 dark:bg-gray-700 flex items-center justify-center p-3">
                    <img src="{{ asset('size-512/images/camera.png') }}" alt="Foto Studio" class="w-full h-full object-contain">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">Foto Studio</span>
            </a>

            <!-- O'yingoh -->
            <a href="#" class="flex flex-col items-center gap-3 p-4 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all">
                <div class="w-16 h-16 rounded-2xl bg-red-50 dark:bg-red-900/30 flex items-center justify-center p-3">
                    <img src="{{ asset('size-512/images/playground.png') }}" alt="O'yingoh" class="w-full h-full object-contain">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">O'yingoh</span>
            </a>

            <!-- Avtosalon -->
            <a href="#" class="flex flex-col items-center gap-3 p-4 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all">
                <div class="w-16 h-16 rounded-2xl bg-pink-50 dark:bg-pink-900/30 flex items-center justify-center p-3">
                    <img src="{{ asset('size-512/images/car.png') }}" alt="Avtosalon" class="w-full h-full object-contain">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">Avtosalon</span>
            </a>

            <!-- Dacha -->
            <a href="#" class="flex flex-col items-center gap-3 p-4 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all">
                <div class="w-16 h-16 rounded-2xl bg-green-50 dark:bg-green-900/30 flex items-center justify-center p-3">
                    <img src="{{ asset('size-512/images/house.png') }}" alt="Dacha" class="w-full h-full object-contain">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">Dacha</span>
            </a>
        </div>
    </div>
</x-glass-layout>
