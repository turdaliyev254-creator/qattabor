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
            <a href="#" class="flex flex-col items-center gap-4 p-6 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all">
                <div class="w-24 h-24 rounded-3xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center p-4">
                    <img src="{{ asset('size-512/images/sofa.png') }}" alt="Mebel" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">Mebel</span>
            </a>

            <!-- Hayvonot bog'i -->
            <a href="#" class="flex flex-col items-center gap-4 p-6 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all">
                <div class="w-24 h-24 rounded-3xl bg-orange-50 dark:bg-orange-900/30 flex items-center justify-center p-4">
                    <img src="{{ asset('size-512/images/lion.png') }}" alt="Hayvonot bog'i" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">Hayvonot bog'i</span>
            </a>

            <!-- Supermarket -->
            <a href="#" class="flex flex-col items-center gap-4 p-6 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all">
                <div class="w-24 h-24 rounded-3xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center p-4">
                    <img src="{{ asset('size-512/images/supermarket.png') }}" alt="Supermarket" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">Supermarket</span>
            </a>

            <!-- SPA -->
            <a href="#" class="flex flex-col items-center gap-4 p-6 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all">
                <div class="w-24 h-24 rounded-3xl bg-yellow-50 dark:bg-yellow-900/30 flex items-center justify-center p-4">
                    <img src="{{ asset('size-512/images/spa.png') }}" alt="SPA" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">SPA</span>
            </a>

            <!-- Foto Studio -->
            <a href="#" class="flex flex-col items-center gap-4 p-6 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all">
                <div class="w-24 h-24 rounded-3xl bg-gray-50 dark:bg-gray-700 flex items-center justify-center p-4">
                    <img src="{{ asset('size-512/images/camera.png') }}" alt="Foto Studio" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">Foto Studio</span>
            </a>

            <!-- O'yingoh -->
            <a href="#" class="flex flex-col items-center gap-4 p-6 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all">
                <div class="w-24 h-24 rounded-3xl bg-red-50 dark:bg-red-900/30 flex items-center justify-center p-4">
                    <img src="{{ asset('size-512/images/playground.png') }}" alt="O'yingoh" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">O'yingoh</span>
            </a>

            <!-- Avtosalon -->
            <a href="#" class="flex flex-col items-center gap-4 p-6 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all">
                <div class="w-24 h-24 rounded-3xl bg-pink-50 dark:bg-pink-900/30 flex items-center justify-center p-4">
                    <img src="{{ asset('size-512/images/car.png') }}" alt="Avtosalon" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">Avtosalon</span>
            </a>

            <!-- Dacha -->
            <a href="#" class="flex flex-col items-center gap-4 p-6 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all">
                <div class="w-24 h-24 rounded-3xl bg-green-50 dark:bg-green-900/30 flex items-center justify-center p-4">
                    <img src="{{ asset('size-512/images/house.png') }}" alt="Dacha" class="w-full h-full object-contain">
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">Dacha</span>
            </a>
        </div>
    </div>
</x-glass-layout>
