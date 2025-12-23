<x-glass-layout>
    <div class="mb-4">
        <a href="javascript:history.back()" class="inline-flex items-center text-blue-600 dark:text-blue-400 mb-2 hover:underline">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            {{ __('back') }}
        </a>
    </div>

    <!-- Image Carousel -->
    <div class="mb-6 -mx-4" x-data="{ 
        currentImage: 0,
        images: {{ Js::from($place->image_url ? [$place->image_url] : []) }}
    }">
        <div class="relative overflow-hidden rounded-2xl">
            <template x-if="images.length > 0">
                <div>
                    <img :src="images[currentImage]" 
                         alt="{{ $place->name }}" 
                         class="w-full h-72 object-cover">
                    
                    <!-- Navigation Arrows -->
                    <template x-if="images.length > 1">
                        <div>
                            <button @click="currentImage = currentImage > 0 ? currentImage - 1 : images.length - 1"
                                    class="absolute left-2 top-1/2 -translate-y-1/2 p-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-full shadow-lg hover:bg-white dark:hover:bg-gray-800 transition-colors">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button @click="currentImage = currentImage < images.length - 1 ? currentImage + 1 : 0"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 p-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-full shadow-lg hover:bg-white dark:hover:bg-gray-800 transition-colors">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </template>
            
            <template x-if="images.length === 0">
                <div class="w-full h-72 flex items-center justify-center bg-gradient-to-br from-blue-500 to-purple-600">
                    <svg class="w-24 h-24 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </template>

            <!-- Image Counter -->
            <template x-if="images.length > 1">
                <div class="absolute bottom-4 right-4 px-3 py-1 bg-black/60 backdrop-blur-sm rounded-full text-white text-sm">
                    <span x-text="currentImage + 1"></span> / <span x-text="images.length"></span>
                </div>
            </template>

            <!-- Save Button -->
            @auth
                <div x-data="{ 
                    isSaved: {{ $isSaved ? 'true' : 'false' }},
                    async toggleSave() {
                        try {
                            if (this.isSaved) {
                                await axios.delete('{{ route('places.unsave', $place) }}');
                            } else {
                                await axios.post('{{ route('places.save', $place) }}');
                            }
                            this.isSaved = !this.isSaved;
                        } catch (error) {
                            console.error('Error toggling save:', error);
                        }
                    }
                }" class="absolute top-4 right-4">
                    <button @click="toggleSave()" 
                            class="p-3 bg-white dark:bg-gray-800 rounded-full shadow-lg hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" :class="isSaved ? 'text-red-500' : 'text-gray-400'" :fill="isSaved ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                </div>
            @endauth
        </div>

        <!-- Image Dots -->
        <template x-if="images.length > 1">
            <div class="flex justify-center gap-1.5 mt-3">
                <template x-for="(image, index) in images" :key="index">
                    <button @click="currentImage = index" 
                            class="h-1.5 rounded-full transition-all duration-300"
                            :class="currentImage === index ? 'bg-blue-600 w-8' : 'bg-gray-300 dark:bg-gray-600 w-1.5'">
                    </button>
                </template>
            </div>
        </template>
    </div>

    <!-- Place Info -->
    <div class="mb-6">
        <div class="flex items-start justify-between mb-2">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $place->name }}</h1>
                @if($place->subcategory)
                    <a href="{{ route('places.by-subcategory', [$place->category->slug, $place->subcategory->slug]) }}" 
                       class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        {{ $place->subcategory->name }}
                    </a>
                @elseif($place->category)
                    <a href="{{ route('places.by-category', $place->category->slug) }}" 
                       class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        {{ $place->category->name }}
                    </a>
                @endif
            </div>
            
            @if($place->is_popular)
                <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full">{{ __('popular') }}</span>
            @endif
        </div>

        @if($place->description)
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $place->description }}</p>
        @endif
    </div>

    <!-- Contact Information -->
    @if($place->phone || $place->website || $place->address)
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 mb-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ __('contact_info') }}</h2>
            
            @if($place->phone)
                <div class="flex items-center gap-3 mb-3">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('phone') }}</p>
                        <a href="tel:{{ $place->phone }}" class="text-gray-900 dark:text-white font-medium hover:text-blue-600 dark:hover:text-blue-400">{{ $place->phone }}</a>
                    </div>
                </div>
            @endif

            @if($place->website)
                <div class="flex items-center gap-3 mb-3">
                    <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('website') }}</p>
                        <a href="{{ $place->website }}" target="_blank" class="text-gray-900 dark:text-white font-medium hover:text-blue-600 dark:hover:text-blue-400 break-all">{{ $place->website }}</a>
                    </div>
                </div>
            @endif

            @if($place->address)
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('address') }}</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $place->address }}</p>
                        @if($place->location)
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $place->location->name }}</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Map -->
    @if($place->latitude && $place->longitude)
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ __('location_on_map') }}</h2>
            <div id="place-map" class="w-full h-64 rounded-xl overflow-hidden shadow-lg"></div>
        </div>

        <script src="https://api-maps.yandex.ru/2.1/?apikey=&lang=en_US" type="text/javascript"></script>
        <script>
            ymaps.ready(function() {
                const map = new ymaps.Map('place-map', {
                    center: [{{ $place->latitude }}, {{ $place->longitude }}],
                    zoom: 15,
                    controls: ['zoomControl', 'fullscreenControl']
                });

                const placemark = new ymaps.Placemark(
                    [{{ $place->latitude }}, {{ $place->longitude }}],
                    {
                        balloonContentHeader: '<strong>{{ $place->name }}</strong>',
                        balloonContentBody: '{{ $place->address }}',
                        hintContent: '{{ $place->name }}'
                    },
                    {
                        preset: 'islands#redDotIcon'
                    }
                );

                map.geoObjects.add(placemark);
            });
        </script>
    @endif

    <!-- Related Places -->
    @if($relatedPlaces->count() > 0)
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('related_places') }}</h2>
            <div class="grid grid-cols-2 gap-3">
                @foreach($relatedPlaces as $relatedPlace)
                    <a href="{{ route('places.show', $relatedPlace->slug) }}" class="block">
                        <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all">
                            <div class="relative h-32 overflow-hidden bg-gray-200 dark:bg-gray-700">
                                @if($relatedPlace->image_url)
                                    <img src="{{ $relatedPlace->image_url }}" 
                                         alt="{{ $relatedPlace->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-purple-600">
                                        <svg class="w-12 h-12 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-2">
                                <h3 class="font-semibold text-sm text-gray-900 dark:text-white line-clamp-1">{{ $relatedPlace->name }}</h3>
                                @if($relatedPlace->location)
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $relatedPlace->location->name }}</p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</x-glass-layout>
