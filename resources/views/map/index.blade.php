<x-glass-layout>
    <div class="mb-4">
        <a href="{{ route('home') }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 mb-2 hover:underline">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            {{ __('back') }}
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('map') }}</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $places->count() }} {{ __('places') }}</p>
    </div>

    <!-- Map Container -->
    <div id="map" class="w-full h-[calc(100vh-220px)] rounded-xl overflow-hidden shadow-lg"></div>

    <script src="https://api-maps.yandex.ru/2.1/?apikey=&lang=en_US" type="text/javascript"></script>
    <script>
        const places = @json($places);
        
        ymaps.ready(function() {
            // Center on Fergana, Uzbekistan
            const map = new ymaps.Map('map', {
                center: [40.3864, 71.7864],
                zoom: 12,
                controls: ['zoomControl', 'searchControl', 'typeSelector', 'fullscreenControl']
            });

            // Create clusterer for better performance with many markers
            const clusterer = new ymaps.Clusterer({
                preset: 'islands#invertedVioletClusterIcons',
                groupByCoordinates: false,
                clusterDisableClickZoom: false,
                clusterHideIconOnBalloonOpen: false,
                geoObjectHideIconOnBalloonOpen: false
            });

            const placemarks = [];

            // Add markers for each place
            places.forEach(place => {
                if (place.latitude && place.longitude) {
                    const placemark = new ymaps.Placemark(
                        [parseFloat(place.latitude), parseFloat(place.longitude)],
                        {
                            balloonContentHeader: `<strong>${place.name}</strong>`,
                            balloonContentBody: `
                                <div class="p-2">
                                    ${place.subcategory ? `<p class="text-sm text-blue-600 mb-1">${place.subcategory.name}</p>` : ''}
                                    ${place.description ? `<p class="text-sm mb-2">${place.description.substring(0, 100)}...</p>` : ''}
                                    ${place.address ? `<p class="text-sm text-gray-600 mb-2"><strong>Address:</strong> ${place.address}</p>` : ''}
                                    <a href="/places/${place.slug}" class="inline-block px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">View Details</a>
                                </div>
                            `,
                            hintContent: place.name
                        },
                        {
                            preset: 'islands#dotIcon',
                            iconColor: place.is_popular ? '#FF0000' : '#1E88E5'
                        }
                    );

                    placemarks.push(placemark);
                }
            });

            // Add all placemarks to clusterer
            clusterer.add(placemarks);
            map.geoObjects.add(clusterer);

            // Auto-fit map to show all markers
            if (placemarks.length > 0) {
                map.setBounds(clusterer.getBounds(), {
                    checkZoomRange: true,
                    zoomMargin: 50
                });
            }
        });
    </script>
</x-glass-layout>
