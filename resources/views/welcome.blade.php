<x-glass-layout>
    <!-- Beautiful Banner Slider with Auto-change -->
    <div class="relative w-full h-80 md:h-[500px] rounded-3xl overflow-hidden mb-12 mt-0 shadow-2xl" x-data="bannerSlider()">
        <!-- Glassmorphism Gradient Overlays -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent backdrop-blur-sm z-10"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-900/30 to-purple-900/30 backdrop-blur-[2px] z-10"></div>
        
        <!-- Image Slides -->
        <template x-for="(image, index) in images" :key="index">
            <div x-show="currentSlide === index"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-110"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-1000"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-105"
                 class="absolute inset-0">
                <img :src="image" :alt="'Banner ' + (index + 1)" class="w-full h-full object-cover animate-ken-burns">
            </div>
        </template>
        
        <!-- Slide Indicators -->
        <div class="absolute bottom-8 right-8 z-30 flex gap-2">
            <template x-for="(image, index) in images" :key="index">
                <button @click="currentSlide = index; resetAutoplay()" 
                        class="relative w-3 h-3 rounded-full transition-all duration-300"
                        :class="currentSlide === index ? 'w-8 bg-white shadow-lg' : 'bg-white/50 hover:bg-white/80'">
                </button>
            </template>
        </div>
    </div>
    
    <script>
        function bannerSlider() {
            return {
                currentSlide: 0,
                autoplayInterval: null,
                images: [
                    'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80',
                    'https://images.unsplash.com/photo-1549144511-f099e773c147?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80',
                    'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80',
                    'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80',
                    'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80'
                ],
                init() {
                    this.startAutoplay();
                },
                startAutoplay() {
                    this.autoplayInterval = setInterval(() => {
                        this.nextSlide();
                    }, 3000);
                },
                resetAutoplay() {
                    clearInterval(this.autoplayInterval);
                    this.startAutoplay();
                },
                nextSlide() {
                    this.currentSlide = (this.currentSlide + 1) % this.images.length;
                },
                previousSlide() {
                    this.currentSlide = (this.currentSlide - 1 + this.images.length) % this.images.length;
                    this.resetAutoplay();
                }
            }
        }
    </script>
    
    <style>
        @keyframes ken-burns {
            0% { transform: scale(1); }
            100% { transform: scale(1.1); }
        }
        .animate-ken-burns {
            animation: ken-burns 10s ease-out infinite alternate;
        }
        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
        }
        .animation-delay-200 {
            animation-delay: 0.2s;
            opacity: 0;
        }
    </style>

    <!-- Search Bar with Glassmorphism -->
    <div class="relative mt-8 mb-12 px-4 z-30">
        <div class="relative max-w-2xl mx-auto">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/20 to-purple-500/20 rounded-3xl blur-xl"></div>
            <div class="relative backdrop-blur-3xl bg-white/70 dark:bg-gray-800/70 p-2 rounded-3xl flex items-center shadow-2xl border border-white/60 dark:border-gray-700/60">
                <div class="p-3 text-gray-500 dark:text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" placeholder="{{ __('search_placeholder') }}" class="w-full bg-transparent border-none focus:ring-0 text-gray-800 dark:text-white placeholder-gray-500 text-lg h-12">
                <button class="backdrop-blur-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-2xl font-medium transition-all duration-300 shadow-lg shadow-indigo-500/40 hover:shadow-indigo-500/60 hover:scale-105">
                    {{ __('search') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="mb-12">
        <div class="flex justify-between items-end mb-6 px-2">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('categories') }}</h2>
            <a href="#" class="text-indigo-600 dark:text-indigo-400 font-medium hover:underline">{{ __('see_all') }}</a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($categories as $category)
                <a href="#" class="relative group block">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-3xl blur-md group-hover:blur-lg transition-all duration-300"></div>
                    <div class="relative backdrop-blur-2xl bg-white/60 dark:bg-gray-900/60 p-6 rounded-3xl flex flex-col items-center justify-center gap-4 group-hover:bg-white/70 dark:group-hover:bg-gray-900/70 transition-all duration-300 border border-white/50 dark:border-gray-700/50 shadow-xl group-hover:shadow-2xl group-hover:-translate-y-2">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-100/80 to-white/80 dark:from-indigo-900/80 dark:to-gray-800/80 backdrop-blur-xl flex items-center justify-center text-4xl shadow-lg group-hover:scale-110 transition-transform duration-300 border border-white/40">
                            {{ $category->icon ?? '📍' }}
                        </div>
                        <span class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ $category->name }}</span>
                    </div>
                </a>
            @empty
                <!-- Demo Categories if DB is empty -->
                <a href="#" class="relative group block">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-3xl blur-md group-hover:blur-lg transition-all duration-300"></div>
                    <div class="relative backdrop-blur-2xl bg-white/60 dark:bg-gray-900/60 p-6 rounded-3xl flex flex-col items-center justify-center gap-4 group-hover:bg-white/70 dark:group-hover:bg-gray-900/70 transition-all duration-300 border border-white/50 dark:border-gray-700/50 shadow-xl group-hover:shadow-2xl group-hover:-translate-y-2">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-100/80 to-white/80 dark:from-blue-900/80 dark:to-gray-800/80 backdrop-blur-xl flex items-center justify-center text-4xl shadow-lg group-hover:scale-110 transition-transform duration-300 border border-white/40">🏫</div>
                        <span class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ __('school') }}</span>
                    </div>
                </a>
                <a href="#" class="relative group block">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-3xl blur-md group-hover:blur-lg transition-all duration-300"></div>
                    <div class="relative backdrop-blur-2xl bg-white/60 dark:bg-gray-900/60 p-6 rounded-3xl flex flex-col items-center justify-center gap-4 group-hover:bg-white/70 dark:group-hover:bg-gray-900/70 transition-all duration-300 border border-white/50 dark:border-gray-700/50 shadow-xl group-hover:shadow-2xl group-hover:-translate-y-2">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-green-100/80 to-white/80 dark:from-green-900/80 dark:to-gray-800/80 backdrop-blur-xl flex items-center justify-center text-4xl shadow-lg group-hover:scale-110 transition-transform duration-300 border border-white/40">🧸</div>
                        <span class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ __('kindergarten') }}</span>
                    </div>
                </a>
                <a href="#" class="relative group block">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-500/20 to-pink-500/20 rounded-3xl blur-md group-hover:blur-lg transition-all duration-300"></div>
                    <div class="relative backdrop-blur-2xl bg-white/60 dark:bg-gray-900/60 p-6 rounded-3xl flex flex-col items-center justify-center gap-4 group-hover:bg-white/70 dark:group-hover:bg-gray-900/70 transition-all duration-300 border border-white/50 dark:border-gray-700/50 shadow-xl group-hover:shadow-2xl group-hover:-translate-y-2">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-red-100/80 to-white/80 dark:from-red-900/80 dark:to-gray-800/80 backdrop-blur-xl flex items-center justify-center text-4xl shadow-lg group-hover:scale-110 transition-transform duration-300 border border-white/40">🏥</div>
                        <span class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ __('clinic') }}</span>
                    </div>
                </a>
                <a href="#" class="relative group block">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-500/20 to-amber-500/20 rounded-3xl blur-md group-hover:blur-lg transition-all duration-300"></div>
                    <div class="relative backdrop-blur-2xl bg-white/60 dark:bg-gray-900/60 p-6 rounded-3xl flex flex-col items-center justify-center gap-4 group-hover:bg-white/70 dark:group-hover:bg-gray-900/70 transition-all duration-300 border border-white/50 dark:border-gray-700/50 shadow-xl group-hover:shadow-2xl group-hover:-translate-y-2">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-orange-100/80 to-white/80 dark:from-orange-900/80 dark:to-gray-800/80 backdrop-blur-xl flex items-center justify-center text-4xl shadow-lg group-hover:scale-110 transition-transform duration-300 border border-white/40">🍔</div>
                        <span class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ __('food') }}</span>
                    </div>
                </a>
                <a href="#" class="relative group block">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 to-fuchsia-500/20 rounded-3xl blur-md group-hover:blur-lg transition-all duration-300"></div>
                    <div class="relative backdrop-blur-2xl bg-white/60 dark:bg-gray-900/60 p-6 rounded-3xl flex flex-col items-center justify-center gap-4 group-hover:bg-white/70 dark:group-hover:bg-gray-900/70 transition-all duration-300 border border-white/50 dark:border-gray-700/50 shadow-xl group-hover:shadow-2xl group-hover:-translate-y-2">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-purple-100/80 to-white/80 dark:from-purple-900/80 dark:to-gray-800/80 backdrop-blur-xl flex items-center justify-center text-4xl shadow-lg group-hover:scale-110 transition-transform duration-300 border border-white/40">🏋️</div>
                        <span class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ __('gym') }}</span>
                    </div>
                </a>
            @endforelse
        </div>
    </div>

    <!-- Popular Places Section -->
    <div class="mb-12">
        <div class="flex justify-between items-end mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('popular_places') }}</h2>
            <a href="#" class="text-indigo-600 dark:text-indigo-400 font-medium hover:underline">{{ __('see_all') }}</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($popularPlaces as $place)
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500/30 to-purple-500/30 rounded-3xl blur-lg group-hover:blur-xl transition-all duration-300"></div>
                    <div class="relative backdrop-blur-2xl bg-white/70 dark:bg-gray-900/70 rounded-3xl overflow-hidden border border-white/60 dark:border-gray-700/60 shadow-2xl group-hover:shadow-3xl transition-all duration-300">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $place->image_url ?? 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1074&q=80' }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute top-4 right-4 backdrop-blur-xl bg-white/40 dark:bg-gray-900/40 border border-white/40 rounded-full px-4 py-1.5 text-xs font-bold text-white shadow-lg">
                                {{ $place->category->name ?? 'Restaurant' }}
                            </div>
                        </div>
                        <div class="p-6 backdrop-blur-xl bg-white/30 dark:bg-gray-900/30">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $place->name }}</h3>
                            <div class="flex items-center text-gray-600 dark:text-gray-300 mb-4 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $place->location->name ?? 'Tashkent' }}
                            </div>
                            <button class="w-full py-3 rounded-xl backdrop-blur-xl bg-gradient-to-r from-indigo-600/90 to-purple-600/90 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold shadow-lg shadow-indigo-500/40 transition-all duration-300 hover:scale-[1.02] border border-white/20">
                                {{ __('view_details') }}
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Demo Place -->
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500/30 to-purple-500/30 rounded-3xl blur-lg group-hover:blur-xl transition-all duration-300"></div>
                    <div class="relative backdrop-blur-2xl bg-white/70 dark:bg-gray-900/70 rounded-3xl overflow-hidden border border-white/60 dark:border-gray-700/60 shadow-2xl group-hover:shadow-3xl transition-all duration-300">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" alt="Place" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute top-4 right-4 backdrop-blur-xl bg-white/40 dark:bg-gray-900/40 border border-white/40 rounded-full px-4 py-1.5 text-xs font-bold text-white shadow-lg">
                                Restaurant
                            </div>
                        </div>
                        <div class="p-6 backdrop-blur-xl bg-white/30 dark:bg-gray-900/30">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Osh Markazi</h3>
                            <div class="flex items-center text-gray-600 dark:text-gray-300 mb-4 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Chilanzar, Tashkent
                            </div>
                            <button class="w-full py-3 rounded-xl backdrop-blur-xl bg-gradient-to-r from-indigo-600/90 to-purple-600/90 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold shadow-lg shadow-indigo-500/40 transition-all duration-300 hover:scale-[1.02] border border-white/20">
                                {{ __('view_details') }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-glass-layout>
