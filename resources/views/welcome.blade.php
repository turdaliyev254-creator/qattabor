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

    <!-- Hero Banner Carousel -->
    <div class="relative mb-8 -mx-4" x-data="{ 
        currentSlide: 0,
        slides: [
            {
                image: 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80'
            },
            {
                image: 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80'
            },
            {
                image: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80'
            }
        ],
        autoplay: null,
        init() {
            this.autoplay = setInterval(() => {
                this.currentSlide = (this.currentSlide + 1) % this.slides.length;
            }, 3000);
        }
    }">
        <div class="relative overflow-hidden">
            <div class="flex transition-transform duration-500 ease-out"
                 :style="`transform: translateX(-${currentSlide * 90}%)`">
                <template x-for="(slide, index) in slides" :key="index">
                    <div class="flex-shrink-0 w-[90%] px-2">
                        <div class="relative h-48 rounded-3xl overflow-hidden shadow-lg cursor-pointer">
                            <img :src="slide.image" 
                                 alt="Banner" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        
        <!-- Carousel dots -->
        <div class="flex justify-center gap-1.5 mt-4">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="currentSlide = index" 
                        class="h-1.5 rounded-full transition-all duration-300"
                        :class="currentSlide === index ? 'bg-blue-600 w-8' : 'bg-gray-300 dark:bg-gray-600 w-1.5'">
                </button>
            </template>
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
            <a href="#" class="flex flex-col items-center gap-2">
                <div class="w-16 h-16 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    <img src="{{ asset('size-512/images/sofa.png') }}" alt="Mebel" class="w-full h-full object-contain">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">Mebel</span>
            </a>

            <!-- Hayvonot bog'i -->
            <a href="#" class="flex flex-col items-center gap-2">
                <div class="w-16 h-16 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    <img src="{{ asset('size-512/images/lion.png') }}" alt="Hayvonot bog'i" class="w-full h-full object-contain">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">Hayvonot bog'i</span>
            </a>

            <!-- Supermarket -->
            <a href="#" class="flex flex-col items-center gap-2">
                <div class="w-16 h-16 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    <img src="{{ asset('size-512/images/supermarket.png') }}" alt="Supermarket" class="w-full h-full object-contain">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">Supermarket</span>
            </a>

            <!-- SPA -->
            <a href="#" class="flex flex-col items-center gap-2">
                <div class="w-16 h-16 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    <img src="{{ asset('size-512/images/spa.png') }}" alt="SPA" class="w-full h-full object-contain">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">SPA</span>
            </a>

            <!-- Foto Studio -->
            <a href="#" class="flex flex-col items-center gap-2">
                <div class="w-16 h-16 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    <img src="{{ asset('size-512/images/camera.png') }}" alt="Foto Studio" class="w-full h-full object-contain">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">Foto Studio</span>
            </a>

            <!-- O'yingoh -->
            <a href="#" class="flex flex-col items-center gap-2">
                <div class="w-16 h-16 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    <img src="{{ asset('size-512/images/playground.png') }}" alt="O'yingoh" class="w-full h-full object-contain">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">O'yingoh</span>
            </a>

            <!-- Avtosalon -->
            <a href="#" class="flex flex-col items-center gap-2">
                <div class="w-16 h-16 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    <img src="{{ asset('size-512/images/car.png') }}" alt="Avtosalon" class="w-full h-full object-contain">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">Avtosalon</span>
            </a>

            <!-- Dacha -->
            <a href="#" class="flex flex-col items-center gap-2">
                <div class="w-16 h-16 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    <img src="{{ asset('size-512/images/house.png') }}" alt="Dacha" class="w-full h-full object-contain">
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">Dacha</span>
            </a>
        </div>
    </div>

    <!-- Popular Places Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Mashhur joylar</h2>
            <a href="#" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">Barchasi</a>
        </div>

        <!-- Popular Places Horizontal Scroll -->
        <div class="overflow-x-auto scrollbar-hide -mx-4 px-4">
            <div class="flex gap-3">
                @forelse($popularPlaces ?? [] as $place)
                <a href="#" class="flex-shrink-0 w-56 group">
                    <div class="bg-gray-800 dark:bg-gray-700 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all border border-gray-700 dark:border-gray-600">
                        <!-- Image -->
                        <div class="relative h-36 overflow-hidden bg-gray-700">
                            <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                 alt="{{ $place->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                 onerror="this.style.display='none'">
                            <div class="absolute top-2 right-2">
                                <button class="p-1.5 bg-white/90 backdrop-blur-sm rounded-full hover:bg-white transition-colors">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-3 bg-gray-800 dark:bg-gray-700">
                            <h3 class="font-semibold text-base text-white mb-1.5 line-clamp-1">{{ $place->name }}</h3>
                            <div class="flex items-center gap-1.5 text-xs text-gray-300 mb-1.5">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="line-clamp-1">{{ $place->location->name ?? 'Toshkent' }}</span>
                            </div>
                            <div class="flex items-center gap-0.5">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="font-semibold text-sm text-white">4.8</span>
                                <span class="text-xs text-gray-400">(120)</span>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <!-- Sample Places when no data -->
                @for($i = 1; $i <= 5; $i++)
                <a href="#" class="flex-shrink-0 w-56 group">
                    <div class="bg-gray-800 dark:bg-gray-700 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all border border-gray-700 dark:border-gray-600">
                        <!-- Image -->
                        <div class="relative h-36 overflow-hidden bg-gray-700">
                            <img src="https://images.unsplash.com/photo-{{ 1517248135467 + ($i * 10000) }}-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                 alt="Place {{ $i }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                 onerror="this.style.display='none'">
                            <div class="absolute top-2 right-2">
                                <button class="p-1.5 bg-white/90 backdrop-blur-sm rounded-full hover:bg-white transition-colors">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-3 bg-gray-800 dark:bg-gray-700">
                            <h3 class="font-semibold text-base text-white mb-1.5 line-clamp-1">Mashhur Joy {{ $i }}</h3>
                            <div class="flex items-center gap-1.5 text-xs text-gray-300 mb-1.5">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="line-clamp-1">Toshkent</span>
                            </div>
                            <div class="flex items-center gap-0.5">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="font-semibold text-sm text-white">4.{{ 5 + $i }}</span>
                                <span class="text-xs text-gray-400">({{ 50 + ($i * 20) }})</span>
                            </div>
                        </div>
                    </div>
                </a>
                @endfor
                @endforelse
            </div>
        </div>
    </div>
</x-glass-layout>
