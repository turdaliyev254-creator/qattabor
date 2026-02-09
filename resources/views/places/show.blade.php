<x-glass-layout>
    <!-- Hero Section with Media Gallery (2GIS Style) -->
    <div class="relative -mx-4 -mt-6 mb-8" x-data="{ 
        currentMedia: 0,
        media: @json($mediaData ?? []),
        showFullscreen: false,
        showThumbnails: false,
        isPlaying: false,
        init() {
            this.$watch('showFullscreen', value => {
                if (value) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                    this.pauseVideo();
                }
            });
            this.$watch('currentMedia', () => {
                this.pauseVideo();
            });
        },
        isVideo(index) {
            return this.media[index] && this.media[index].type === 'video';
        },
        pauseVideo() {
            const videos = document.querySelectorAll('video');
            videos.forEach(v => {
                v.pause();
                v.currentTime = 0;
            });
            this.isPlaying = false;
        },
        playVideo() {
            const video = this.$refs.currentVideo;
            if (video) {
                video.play();
                this.isPlaying = true;
            }
        },
        prevMedia() {
            this.currentMedia = this.currentMedia > 0 ? this.currentMedia - 1 : this.media.length - 1;
        },
        nextMedia() {
            this.currentMedia = this.currentMedia < this.media.length - 1 ? this.currentMedia + 1 : 0;
        }
    }">
        <!-- Main Media Display -->
        <div class="relative h-[50vh] min-h-[400px] overflow-hidden bg-black">
            <template x-if="media.length > 0">
                <div class="relative h-full">
                    <!-- Media Container -->
                    <div @click="if(!isVideo(currentMedia)) showFullscreen = true" class="w-full h-full" :class="!isVideo(currentMedia) ? 'cursor-zoom-in' : ''">
                        <template x-for="(item, index) in media" :key="index">
                            <div x-show="currentMedia === index" class="w-full h-full">
                                <!-- Image -->
                                <template x-if="item.type === 'image'">
                                    <img :src="item.url" 
                                         alt="{{ $place->localized_name }}" 
                                         class="w-full h-full object-cover">
                                </template>
                                
                                <!-- Video -->
                                <template x-if="item.type === 'video'">
                                    <div class="relative w-full h-full flex items-center justify-center bg-black">
                                        <video x-ref="currentVideo"
                                               :src="item.url"
                                               class="max-w-full max-h-full"
                                               controls
                                               @play="isPlaying = true"
                                               @pause="isPlaying = false"
                                               preload="metadata">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>

                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none"></div>
                    
                    <!-- Navigation Arrows -->
                    <template x-if="media.length > 1">
                        <div>
                            <button @click="prevMedia()"
                                    class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 p-2 sm:p-3 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md rounded-full shadow-xl hover:bg-white dark:hover:bg-gray-900 transition-all hover:scale-110 z-10">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-800 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button @click="nextMedia()"
                                    class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 p-2 sm:p-3 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md rounded-full shadow-xl hover:bg-white dark:hover:bg-gray-900 transition-all hover:scale-110 z-10">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-800 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </template>

                    <!-- Media Counter & Thumbnails Toggle (2GIS Style) -->
                    <template x-if="media.length > 1">
                        <div class="absolute bottom-4 sm:bottom-6 right-4 sm:right-6 flex items-center gap-3 z-10">
                            <!-- Thumbnails Toggle Button -->
                            <button @click="showThumbnails = !showThumbnails"
                                    class="px-3 sm:px-4 py-2 bg-black/70 backdrop-blur-md rounded-lg text-white text-xs sm:text-sm font-medium hover:bg-black/80 transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                <span x-text="currentMedia + 1"></span> / <span x-text="media.length"></span>
                            </button>
                        </div>
                    </template>

                    <!-- Thumbnails Strip (2GIS Style) -->
                    <div x-show="showThumbnails && media.length > 1"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-4"
                         class="absolute bottom-16 sm:bottom-20 left-4 right-4 z-10"
                         style="display: none;">
                        <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
                            <template x-for="(item, index) in media" :key="index">
                                <button @click="currentMedia = index; showThumbnails = false"
                                        class="relative flex-shrink-0 w-20 h-20 sm:w-24 sm:h-24 rounded-lg overflow-hidden border-2 transition-all"
                                        :class="currentMedia === index ? 'border-white ring-2 ring-white/50' : 'border-white/30 hover:border-white/60'">
                                    <img :src="item.thumbnail" 
                                         :alt="'Thumbnail ' + (index + 1)"
                                         class="w-full h-full object-cover">
                                    
                                    <!-- Video Indicator -->
                                    <template x-if="item.type === 'video'">
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                            <div class="relative">
                                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                                <span x-show="item.duration" 
                                                      class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-xs text-white bg-black/70 px-1.5 py-0.5 rounded whitespace-nowrap"
                                                      x-text="item.duration"></span>
                                            </div>
                                        </div>
                                    </template>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
            
            <template x-if="media.length === 0">
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500">
                    <svg class="w-32 h-32 text-white opacity-30" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </template>

            <!-- Top Actions Bar -->
            <div class="absolute top-0 inset-x-0 p-4 sm:p-6 flex items-start justify-between z-10">
                <!-- Back Button -->
                <a href="{{ $place->subcategory_id ? route('places.by-subcategory', [$place->category->slug, $place->subcategory->slug]) : route('places.by-category', $place->category->slug) }}{{ request('region') ? '?region=' . urlencode(request('region')) : '' }}" class="inline-flex items-center gap-2 px-4 py-2.5 backdrop-blur-md bg-black/30 hover:bg-black/50 rounded-xl text-sm font-medium text-white shadow-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    {{ __('back') }}
                </a>

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
                    }">
                        <button @click="toggleSave()" 
                                class="p-3 backdrop-blur-md bg-black/30 hover:bg-black/50 rounded-xl shadow-lg transition-all">
                            <svg class="w-6 h-6" :class="isSaved ? 'text-red-500' : 'text-white'" :fill="isSaved ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Fullscreen Modal -->
        <div x-show="showFullscreen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="if(!isVideo(currentMedia)) showFullscreen = false"
             @keydown.escape.window="showFullscreen = false"
             class="fixed inset-0 z-[100] bg-black"
             style="display: none;">
            
            <!-- Close Button -->
            <button @click="showFullscreen = false" 
                    class="absolute top-4 right-4 p-3 bg-white/10 hover:bg-white/20 backdrop-blur-md rounded-full text-white transition-all z-20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Media Container -->
            <div class="w-full h-full flex items-center justify-center relative">
                <!-- Media Counter -->
                <template x-if="media.length > 1">
                    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 px-5 py-2.5 bg-white/20 backdrop-blur-md rounded-full text-white text-base font-semibold z-10">
                        <span x-text="currentMedia + 1"></span> / <span x-text="media.length"></span>
                    </div>
                </template>

                <!-- Navigation Arrows -->
                <template x-if="media.length > 1">
                    <div>
                        <button @click.stop="prevMedia()"
                                class="absolute left-4 top-1/2 -translate-y-1/2 p-4 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-full transition-all z-10">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button @click.stop="nextMedia()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 p-4 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-full transition-all z-10">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </template>

                <!-- Media Display -->
                <template x-for="(item, index) in media" :key="index">
                    <div x-show="currentMedia === index" @click.stop class="max-h-full max-w-full">
                        <!-- Image -->
                        <template x-if="item.type === 'image'">
                            <img :src="item.url" 
                                 alt="{{ $place->name }}" 
                                 class="max-h-screen max-w-full object-contain">
                        </template>
                        
                        <!-- Video -->
                        <template x-if="item.type === 'video'">
                            <video :src="item.url"
                                   class="max-h-screen max-w-full"
                                   controls
                                   preload="metadata">
                                Your browser does not support the video tag.
                            </video>
                        </template>
                    </div>
                </template>
            </div>
        </div>

        <!-- Place Title Overlay -->
        <div class="absolute bottom-0 inset-x-0 p-6 sm:p-8">
            <div class="max-w-4xl">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-3 drop-shadow-2xl">{{ $place->localized_name }}</h1>
                <div class="flex flex-wrap items-center gap-3">
                    @if($place->location)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 backdrop-blur-md bg-white/20 text-white rounded-lg text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            {{ $place->location->name }}
                        </span>
                    @endif

                    @if($place->rating > 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 backdrop-blur-md bg-yellow-500/90 text-white rounded-lg text-sm font-bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            {{ number_format($place->rating, 1) }}
                        </span>
                    @endif
                    
                    @if($place->is_popular)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 backdrop-blur-md bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg text-sm font-bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            {{ __('popular') }}
                        </span>
                    @endif
                </div>
                
                <!-- Image Thumbnails -->
                <template x-if="images.length > 1">
                    <div class="flex gap-2 mt-4">
                        <template x-for="(image, index) in images" :key="index">
                            <button @click="currentImage = index" 
                                    class="h-1.5 rounded-full transition-all duration-300"
                                    :class="currentImage === index ? 'bg-white w-8' : 'bg-white/40 w-1.5 hover:bg-white/60'">
                            </button>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 space-y-8">
        <!-- Quick Actions -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @if($place->phone)
                <a href="tel:{{ $place->phone }}" 
                   class="flex items-center justify-center gap-3 backdrop-blur-xl bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-2xl p-5 shadow-xl hover:shadow-2xl transition-all hover:scale-[1.02]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span class="font-semibold text-lg">{{ __('call') }}</span>
                </a>
            @endif

            @if($place->latitude && $place->longitude)
                <a href="{{ $place->navigate_link ?: 'yandexnavi://build_route_on_map?lat_to=' . $place->latitude . '&lon_to=' . $place->longitude }}" 
                   target="{{ $place->navigate_link ? '_blank' : '_self' }}"
                   class="flex items-center justify-center gap-3 backdrop-blur-xl bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-2xl p-5 shadow-xl hover:shadow-2xl transition-all hover:scale-[1.02]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    <span class="font-semibold text-lg">{{ __('navigate') }}</span>
                </a>
            @endif
        </div>

        <!-- Quick Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @if($place->address)
                <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-2xl p-5 border border-white/20 dark:border-gray-700/50 shadow-lg">
                    <div class="flex items-start gap-3">
                        <div class="p-2.5 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('Address') }}</div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-white line-clamp-2">{{ $place->address }}</div>
                        </div>
                    </div>
                </div>
            @endif
            
            @if($place->working_hours && is_array($place->working_hours))
                <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-2xl p-5 border border-white/20 dark:border-gray-700/50 shadow-lg">
                    <div class="flex items-start gap-3">
                        <div class="p-2.5 bg-green-100 dark:bg-green-900/30 rounded-xl">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Working Hours') }}</div>
                            <div class="space-y-1.5">
                                @php
                                    $dayNames = [
                                        'monday' => __('Monday'),
                                        'tuesday' => __('Tuesday'),
                                        'wednesday' => __('Wednesday'),
                                        'thursday' => __('Thursday'),
                                        'friday' => __('Friday'),
                                        'saturday' => __('Saturday'),
                                        'sunday' => __('Sunday')
                                    ];
                                    $today = strtolower(date('l'));
                                @endphp
                                @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                    @if(isset($place->working_hours[$day]) && $place->working_hours[$day]['enabled'])
                                        <div class="flex items-center justify-between text-sm {{ $today === $day ? 'font-bold text-green-600 dark:text-green-400' : 'text-gray-700 dark:text-gray-300' }}">
                                            <span>{{ $dayNames[$day] }}:</span>
                                            <span>{{ $place->working_hours[$day]['open'] }} - {{ $place->working_hours[$day]['close'] }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if($place->description)
            <!-- Description Section -->
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-2xl p-6 border border-white/20 dark:border-gray-700/50 shadow-lg">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ __('About') }}</h2>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $place->localized_description }}</p>
            </div>
        @endif

        <!-- Social Media Links -->
        @if($place->instagram || $place->telegram || $place->facebook || $place->youtube || $place->website)
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-2xl p-6 border border-white/20 dark:border-gray-700/50 shadow-lg">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-5">{{ __('social_media') }}</h2>
                
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                    @if($place->website)
                        <a href="{{ $place->website }}" target="_blank" 
                           class="flex flex-col items-center gap-2.5 p-4 rounded-xl bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white shadow-lg hover:shadow-xl transition-all hover:scale-105">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                            <span class="text-sm font-semibold">Website</span>
                        </a>
                    @endif
                    @if($place->instagram)
                        <a href="{{ $place->instagram }}" target="_blank" 
                           class="flex flex-col items-center gap-2.5 p-4 rounded-xl bg-gradient-to-br from-pink-500 via-purple-500 to-orange-500 hover:from-pink-600 hover:via-purple-600 hover:to-orange-600 text-white shadow-lg hover:shadow-xl transition-all hover:scale-105">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                            <span class="text-sm font-semibold">Instagram</span>
                        </a>
                    @endif

                    @if($place->telegram)
                        <a href="{{ $place->telegram }}" target="_blank" 
                           class="flex flex-col items-center gap-2.5 p-4 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 hover:from-blue-500 hover:to-blue-700 text-white shadow-lg hover:shadow-xl transition-all hover:scale-105">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                            </svg>
                            <span class="text-sm font-semibold">Telegram</span>
                        </a>
                    @endif

                    @if($place->facebook)
                        <a href="{{ $place->facebook }}" target="_blank" 
                           class="flex flex-col items-center gap-2.5 p-4 rounded-xl bg-gradient-to-br from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white shadow-lg hover:shadow-xl transition-all hover:scale-105">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            <span class="text-sm font-semibold">Facebook</span>
                        </a>
                    @endif

                    @if($place->youtube)
                        <a href="{{ $place->youtube }}" target="_blank" 
                           class="flex flex-col items-center gap-2.5 p-4 rounded-xl bg-gradient-to-br from-red-600 to-red-800 hover:from-red-700 hover:to-red-900 text-white shadow-lg hover:shadow-xl transition-all hover:scale-105">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                            <span class="text-sm font-semibold">YouTube</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif

        <!-- Map Section -->
        @if($place->latitude && $place->longitude)
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-2xl border border-white/20 dark:border-gray-700/50 shadow-lg overflow-hidden">
                <div class="p-6 pb-0">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ __('location_on_map') }}</h2>
                </div>
                <div id="place-map" class="w-full h-80"></div>
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
        <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-2xl p-6 border border-white/20 dark:border-gray-700/50 shadow-lg">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-5">{{ __('related_places') }}</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($relatedPlaces as $relatedPlace)
                    <a href="{{ route('places.show', $relatedPlace->slug) }}" class="group block">
                        <div class="backdrop-blur-xl bg-white/50 dark:bg-gray-900/50 rounded-xl overflow-hidden shadow-md hover:shadow-2xl border border-white/20 dark:border-gray-700/50 transition-all hover:scale-[1.02]">
                            <div class="relative h-40 overflow-hidden">
                                @if($relatedPlace->image_url)
                                    <img src="{{ $relatedPlace->image_url }}" 
                                         alt="{{ $relatedPlace->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500">
                                        <svg class="w-16 h-16 text-white opacity-30" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                            </div>
                            
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 dark:text-white line-clamp-2 mb-2">{{ $relatedPlace->name }}</h3>
                                @if($relatedPlace->location)
                                    <p class="text-xs text-gray-600 dark:text-gray-400 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        </svg>
                                        {{ $relatedPlace->location->name }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Reviews & Comments Section -->
    <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-2xl p-6 border border-white/20 dark:border-gray-700/50 shadow-lg">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Reviews') }}</h2>
            
            @if($place->rating > 0)
                <div class="flex items-center gap-4 px-6 py-4 bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-xl">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-gray-900 dark:text-white">{{ number_format($place->rating, 1) }}</div>
                        <div class="flex items-center gap-0.5 mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= round($place->rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $place->approvedComments()->whereNotNull('rating')->count() }} {{ __('reviews') }}</div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Write Review Form -->
        @auth
            <form method="POST" action="{{ route('comments.store', $place) }}" class="mb-8 p-6 bg-gray-50 dark:bg-gray-900/30 rounded-2xl border border-gray-200 dark:border-gray-700" x-data="{ rating: 0 }">
                @csrf
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-5">{{ __('Write a Review') }}</h3>
                
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                        {{ __('Your Rating') }}
                    </label>
                    <div class="flex gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    @click="rating = {{ $i }}"
                                    class="focus:outline-none transition-all hover:scale-110">
                                <svg class="w-12 h-12 transition-colors" 
                                     :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600 hover:text-yellow-200'"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" :value="rating" required>
                </div>

                <div class="mb-5">
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Your Review') }}
                    </label>
                    <textarea name="content" id="content" rows="4" required
                              class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                              placeholder="{{ __('Share your experience...') }}"></textarea>
                </div>

                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all hover:scale-105 shadow-lg">
                    {{ __('Submit Review') }}
                </button>
            </form>
        @else
            <div class="mb-8 p-8 bg-gray-50 dark:bg-gray-900/30 rounded-2xl border border-gray-200 dark:border-gray-700 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <p class="text-gray-600 dark:text-gray-400 mb-4 font-medium">{{ __('Please login to leave a review') }}</p>
                <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all hover:scale-105 shadow-lg">
                    {{ __('Login') }}
                </a>
            </div>
        @endauth

        <!-- Comments List -->
        <div class="space-y-5">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('Customer Reviews') }}</h3>
            
            @forelse($place->approvedComments()->whereNull('parent_id')->latest()->get() as $comment)
                <div class="p-6 bg-white dark:bg-gray-900/40 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white">{{ $comment->user->name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                                @if($comment->rating)
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $comment->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                @endif
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $comment->content }}</p>
                            
                            <!-- Replies -->
                            @if($comment->replies->count() > 0)
                                <div class="mt-5 space-y-3">
                                    @foreach($comment->replies as $reply)
                                        <div class="ml-4 p-4 bg-blue-50 dark:bg-blue-900/10 rounded-xl border-l-4 border-blue-500">
                                            <div class="flex items-start gap-3">
                                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center text-white font-bold text-sm shadow-md flex-shrink-0">
                                                    {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <span class="font-bold text-sm text-gray-900 dark:text-white">{{ $reply->user->name }}</span>
                                                        @if($reply->user_id === $place->owner_id)
                                                            <span class="px-2 py-0.5 bg-blue-600 text-white text-xs font-semibold rounded-full">{{ __('Owner') }}</span>
                                                        @endif
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $reply->content }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 text-gray-500 dark:text-gray-400">
                    <svg class="w-20 h-20 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="text-lg font-semibold mb-2">{{ __('No reviews yet') }}</p>
                    <p class="text-sm">{{ __('Be the first to review this place!') }}</p>
                </div>
            @endforelse
        </div>
    </div>
    </div>
</x-glass-layout>
