<x-admin-layout>
    <div class="mb-6">
        <a href="{{ route('admin.subcategories.brands.index', $subcategory) }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 flex items-center gap-2 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            {{ __('Back to Brands') }}
        </a>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Create Brand') }}</h2>
    </div>

    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500">
        <strong class="text-gray-900 dark:text-white">{{ __('Creating brand for') }}:</strong> 
        <span class="text-gray-700 dark:text-gray-300">{{ $subcategory->category->name }}</span> → 
        <span class="text-gray-700 dark:text-gray-300">{{ $subcategory->name }}</span>
    </div>

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 max-w-2xl">
        <form action="{{ route('admin.subcategories.brands.store', $subcategory) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <!-- Language Tabs -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-4" aria-label="Tabs">
                        <button type="button" onclick="switchLanguage('uz')" class="lang-tab active border-b-2 border-indigo-500 py-2 px-1 text-sm font-medium text-indigo-600 dark:text-indigo-400" data-lang="uz">
                            🇺🇿 Uzbek
                        </button>
                        <button type="button" onclick="switchLanguage('ru')" class="lang-tab border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300" data-lang="ru">
                            🇷🇺 Russian
                        </button>
                        <button type="button" onclick="switchLanguage('en')" class="lang-tab border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300" data-lang="en">
                            🇬🇧 English
                        </button>
                    </nav>
                </div>

                <!-- Default Name (required) -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Brand Name') }} *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Uzbek Name -->
                <div class="lang-content" data-lang="uz">
                    <label for="name_uz" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Brand Name (Uzbek)') }}</label>
                    <input type="text" name="name_uz" id="name_uz" value="{{ old('name_uz') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    @error('name_uz')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Russian Name -->
                <div class="lang-content hidden" data-lang="ru">
                    <label for="name_ru" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Brand Name (Russian)') }}</label>
                    <input type="text" name="name_ru" id="name_ru" value="{{ old('name_ru') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    @error('name_ru')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- English Name -->
                <div class="lang-content hidden" data-lang="en">
                    <label for="name_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Brand Name (English)') }}</label>
                    <input type="text" name="name_en" id="name_en" value="{{ old('name_en') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    @error('name_en')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon Upload -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Brand Icon') }} *</label>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ __('Supported formats: SVG, PNG, JPG/JPEG (Max: 2MB). Non-SVG images will be resized to 512x512px.') }}</p>
                    <input type="file" name="icon" id="icon" accept="image/svg+xml,image/png,image/jpeg" onchange="previewIcon(this)" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    <!-- Icon Preview -->
                    <div id="iconPreview" class="mt-4 hidden">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Preview') }}:</p>
                        <img id="preview" src="" alt="Icon preview" class="w-32 h-32 object-contain rounded-lg border border-gray-300 dark:border-gray-600">
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition-colors duration-200">
                        {{ __('Create Brand') }}
                    </button>
                    <a href="{{ route('admin.subcategories.brands.index', $subcategory) }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg shadow-sm transition-colors duration-200">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function switchLanguage(lang) {
            // Update tab styles
            document.querySelectorAll('.lang-tab').forEach(tab => {
                if (tab.dataset.lang === lang) {
                    tab.classList.add('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
                    tab.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
                } else {
                    tab.classList.remove('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
                    tab.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
                }
            });

            // Show/hide content
            document.querySelectorAll('.lang-content').forEach(content => {
                if (content.dataset.lang === lang) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });
        }

        function previewIcon(input) {
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('iconPreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
</x-admin-layout>
