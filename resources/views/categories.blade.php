<x-glass-layout>
    <div class="max-w-7xl mx-auto min-h-screen py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('home') }}" class="flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-gray-800 shadow-md hover:shadow-lg transition-shadow">
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('categories') }}</h1>
            </div>
            <p class="text-gray-600 dark:text-gray-400">{{ __('see_all') }} {{ __('categories') }}</p>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach($categories as $category)
            <div class="flex flex-col items-center gap-3 cursor-pointer hover:opacity-80 transition-opacity">
                <div class="w-20 h-20 flex items-center justify-center drop-shadow-lg hover:drop-shadow-xl transition-all">
                    @if($category->icon)
                        @if(Str::endsWith($category->icon, '.png'))
                            <img src="{{ asset('size-512/images/' . $category->icon) }}" alt="{{ $category->name }}" class="w-full h-full object-contain">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 rounded-2xl flex items-center justify-center text-white text-4xl">
                                {{ $category->icon }}
                            </div>
                        @endif
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 rounded-2xl flex items-center justify-center text-white text-2xl font-bold">
                            {{ substr($category->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <span class="text-base font-semibold text-gray-700 dark:text-gray-300 text-center">{{ __($category->name) }}</span>
            </div>
            @endforeach
        </div>
    </div>
</x-glass-layout>
