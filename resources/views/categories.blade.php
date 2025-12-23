<x-glass-layout>
    <div class="max-w-7xl mx-auto min-h-screen py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Kategoriyalar</h1>
            <p class="text-gray-600 dark:text-gray-400">Barcha kategoriyalarni ko'ring</p>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-6">
            <!-- Mebel -->
            <a href="#" class="flex flex-col items-center gap-3">
                <div class="w-20 h-20 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    <img src="{{ asset('size-512/images/sofa.png') }}" alt="Mebel" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">Mebel</span>
            </a>

            <!-- Hayvonot bog'i -->
            <a href="#" class="flex flex-col items-center gap-3">
                <div class="w-20 h-20 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    <img src="{{ asset('size-512/images/lion.png') }}" alt="Hayvonot bog'i" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">Hayvonot bog'i</span>
            </a>

            <!-- Supermarket -->
            <a href="#" class="flex flex-col items-center gap-3">
                <div class="w-20 h-20 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    <img src="{{ asset('size-512/images/supermarket.png') }}" alt="Supermarket" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">Supermarket</span>
            </a>

            <!-- SPA -->
            <a href="#" class="flex flex-col items-center gap-3">
                <div class="w-20 h-20 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    <img src="{{ asset('size-512/images/spa.png') }}" alt="SPA" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">SPA</span>
            </a>

            <!-- Foto Studio -->
            <a href="#" class="flex flex-col items-center gap-3">
                <div class="w-20 h-20 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    <img src="{{ asset('size-512/images/camera.png') }}" alt="Foto Studio" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">Foto Studio</span>
            </a>

            <!-- O'yingoh -->
            <a href="#" class="flex flex-col items-center gap-3">
                <div class="w-20 h-20 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    <img src="{{ asset('size-512/images/playground.png') }}" alt="O'yingoh" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">O'yingoh</span>
            </a>

            <!-- Avtosalon -->
            <a href="#" class="flex flex-col items-center gap-3">
                <div class="w-20 h-20 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    <img src="{{ asset('size-512/images/car.png') }}" alt="Avtosalon" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">Avtosalon</span>
            </a>

            <!-- Dacha -->
            <a href="#" class="flex flex-col items-center gap-3">
                <div class="w-20 h-20 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    <img src="{{ asset('size-512/images/house.png') }}" alt="Dacha" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">Dacha</span>
            </a>
        </div>
    </div>
</x-glass-layout>
