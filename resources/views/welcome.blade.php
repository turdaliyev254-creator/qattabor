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

    <!-- Categories Section with Subcategories -->
    <div class="mb-8" x-data="{ openCategory: null }">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Kategoriyalar</h2>
            <a href="{{ route('categories.all') }}" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">Barchasi</a>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-5 gap-4">
            @foreach($categories as $category)
            <div class="relative">
                <div class="flex flex-col items-center gap-2 w-full cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="w-16 h-16 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                        @if($category->image)
                            <img src="{{ asset('size-512/images/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-contain">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 rounded-2xl flex items-center justify-center text-white text-2xl font-bold">
                                {{ substr($category->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">{{ $category->name }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Popular Places Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Mashhur joylar</h2>
            <a href="#" class="text-blue-600 dark:text-blue-400 text-xs font-medium hover:underline">Barchasi</a>
        </div>

        <!-- Horizontal Scrollable Cards -->
        <div class="overflow-x-auto scrollbar-hide -mx-4 px-4">
            <div class="flex gap-3 pb-2">
                @forelse($popularPlaces ?? [] as $place)
                <a href="#" class="flex-shrink-0 w-48">
                    <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all">
                        <!-- Place Image -->
                        <div class="relative h-28 overflow-hidden bg-gray-200 dark:bg-gray-700">
                            @if($place->image)
                            <img src="{{ asset('storage/' . $place->image) }}" 
                                 alt="{{ $place->name }}" 
                                 class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-purple-600">
                                <svg class="w-12 h-12 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Place Info -->
                        <div class="p-2">
                            <h3 class="font-semibold text-sm text-gray-900 dark:text-white mb-1 line-clamp-1">{{ $place->name }}</h3>
                            <div class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 mb-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="line-clamp-1">{{ $place->location->name ?? 'Toshkent' }}</span>
                            </div>
                            <div class="flex items-center gap-0.5">
                                <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="font-semibold text-xs text-gray-900 dark:text-white">4.8</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">(120)</span>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <!-- Sample Places -->
                @for($i = 1; $i <= 6; $i++)
                <a href="#" class="flex-shrink-0 w-48">
                    <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all">
                        <!-- Place Image -->
                        <div class="relative h-28 overflow-hidden bg-gradient-to-br from-blue-{{ 400 + ($i % 3) * 100 }} to-purple-{{ 500 + ($i % 2) * 100 }}">
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Place Info -->
                        <div class="p-2">
                            <h3 class="font-semibold text-sm text-gray-900 dark:text-white mb-1 line-clamp-1">Mashhur Joy {{ $i }}</h3>
                            <div class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 mb-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="line-clamp-1">Toshkent</span>
                            </div>
                            <div class="flex items-center gap-0.5">
                                <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="font-semibold text-xs text-gray-900 dark:text-white">4.{{ 5 + ($i % 4) }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">({{ 50 + ($i * 15) }})</span>
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
