<x-glass-layout>
    <!-- Modern Hero Banner -->
    <div class="relative w-full h-96 rounded-3xl overflow-hidden mb-10 shadow-xl" x-data="bannerSlider()">
        <!-- Image Slides -->
        <template x-for="(image, index) in images" :key="index">
            <div x-show="currentSlide === index"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-700"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0">
                <img :src="image" :alt="'Banner ' + (index + 1)" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
            </div>
        </template>
        
        <!-- Content Overlay -->
        <div class="absolute inset-0 flex items-center justify-center text-center px-4 z-10">
            <div class="animate-fade-in">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-3">Discover Amazing Places</h1>
                <p class="text-lg text-white/90">Find the best spots around you</p>
            </div>
        </div>
        
        <!-- Indicators -->
        <div class="absolute bottom-6 right-6 z-20 flex gap-2">
            <template x-for="(image, index) in images" :key="index">
                <button @click="currentSlide = index; resetAutoplay()" 
                        class="h-1 rounded-full transition-all"
                        :class="currentSlide === index ? 'w-8 bg-white' : 'w-4 bg-white/50'">
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
                    }, 4000);
                },
                resetAutoplay() {
                    clearInterval(this.autoplayInterval);
                    this.startAutoplay();
                },
                nextSlide() {
                    this.currentSlide = (this.currentSlide + 1) % this.images.length;
                }
            }
        }
    </script>

    <!-- Search Bar -->
    <div class="mb-10 px-4">
        <div class="max-w-2xl mx-auto">
            <div class="card">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" placeholder="{{ __('search_placeholder') }}" class="flex-1 bg-transparent border-none focus:ring-0 text-gray-900 dark:text-white placeholder-gray-400">
                    <button class="btn btn-primary">
                        {{ __('search') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="mb-10">
        <div class="flex justify-between items-center mb-6 px-2">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('categories') }}</h2>
            <a href="{{ route('categories.all') }}" class="text-brand-600 dark:text-brand-400 font-medium hover:text-brand-700 dark:hover:text-brand-300">{{ __('see_all') }} →</a>
        </div>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
            @forelse($categories as $category)
                <a href="#" class="card card-hover group text-center">
                    <div class="w-16 h-16 mx-auto mb-3 rounded-2xl bg-gradient-to-br from-brand-100 to-accent-100 dark:from-brand-900/20 dark:to-accent-900/20 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
                        {{ $category->icon ?? '📍' }}
                    </div>
                    <h3 class="font-semibold text-sm text-gray-900 dark:text-white">{{ $category->name }}</h3>
                </a>
            @empty
                @foreach([
                    ['icon' => '🏫', 'name' => 'Schools'],
                    ['icon' => '🧸', 'name' => 'Kindergarten'],
                    ['icon' => '🏥', 'name' => 'Clinics'],
                    ['icon' => '🍔', 'name' => 'Food'],
                    ['icon' => '🏋️', 'name' => 'Gyms']
                ] as $demo)
                <a href="#" class="card card-hover group text-center">
                    <div class="w-16 h-16 mx-auto mb-3 rounded-2xl bg-gradient-to-br from-brand-100 to-accent-100 dark:from-brand-900/20 dark:to-accent-900/20 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
                        {{ $demo['icon'] }}
                    </div>
                    <h3 class="font-semibold text-sm text-gray-900 dark:text-white">{{ $demo['name'] }}</h3>
                </a>
                @endforeach
            @endforelse
        </div>
    </div>

    <!-- Popular Places Section -->
    <div class="mb-10">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('popular_places') }}</h2>
            <a href="#" class="text-brand-600 dark:text-brand-400 font-medium hover:text-brand-700 dark:hover:text-brand-300">{{ __('see_all') }} →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($popularPlaces as $place)
                <div class="card p-0 overflow-hidden card-hover group">
                    <div class="relative h-48">
                        <img src="{{ $place->image_url ?? 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1074&q=80' }}" alt="{{ $place->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        <div class="absolute top-3 right-3">
                            <span class="badge bg-white/90 dark:bg-gray-900/90 text-gray-900 dark:text-white">
                                {{ $place->category->name ?? 'Restaurant' }}
                            </span>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ $place->name }}</h3>
                        <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-4">
                            <svg class="w-4 h-4 mr-1.5 text-brand-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $place->location->name ?? 'Tashkent' }}
                        </div>
                        <button class="btn btn-primary w-full">
                            {{ __('view_details') }}
                        </button>
                    </div>
                </div>
            @empty
                <!-- Demo Place -->
                <div class="card p-0 overflow-hidden card-hover group">
                    <div class="relative h-48">
                        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" alt="Place" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        <div class="absolute top-3 right-3">
                            <span class="badge bg-white/90 dark:bg-gray-900/90 text-gray-900 dark:text-white">
                                Restaurant
                            </span>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Osh Markazi</h3>
                        <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-4">
                            <svg class="w-4 h-4 mr-1.5 text-brand-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            Chilanzar, Tashkent
                        </div>
                        <button class="btn btn-primary w-full">
                            {{ __('view_details') }}
                        </button>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-glass-layout>
