<x-admin-layout>
    <div class="p-6">
        <div class="mb-6">
            <a href="{{ route('admin.pages.index') }}" class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                {{ __('Back to Pages') }}
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">{{ __('Edit Page') }}</h2>

            <form action="{{ route('admin.pages.update', $page) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- English Title -->
                <div>
                    <label for="title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Title (English)') }}</label>
                    <input type="text" name="title_en" id="title_en" value="{{ old('title_en', $page->title['en'] ?? '') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                    @error('title_en')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Uzbek Title -->
                <div>
                    <label for="title_uz" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Title (Uzbek)') }}</label>
                    <input type="text" name="title_uz" id="title_uz" value="{{ old('title_uz', $page->title['uz'] ?? '') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                    @error('title_uz')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Russian Title -->
                <div>
                    <label for="title_ru" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Title (Russian)') }}</label>
                    <input type="text" name="title_ru" id="title_ru" value="{{ old('title_ru', $page->title['ru'] ?? '') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                    @error('title_ru')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Slug') }}</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                    <p class="mt-1 text-xs text-gray-500">{{ __('URL-friendly identifier (e.g., about-us, contact)') }}</p>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- English Content -->
                <div>
                    <label for="content_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Content (English)') }}</label>
                    <textarea name="content_en" id="content_en" rows="10" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>{{ old('content_en', $page->content['en'] ?? '') }}</textarea>
                    @error('content_en')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Uzbek Content -->
                <div>
                    <label for="content_uz" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Content (Uzbek)') }}</label>
                    <textarea name="content_uz" id="content_uz" rows="10" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>{{ old('content_uz', $page->content['uz'] ?? '') }}</textarea>
                    @error('content_uz')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Russian Content -->
                <div>
                    <label for="content_ru" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Content (Russian)') }}</label>
                    <textarea name="content_ru" id="content_ru" rows="10" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>{{ old('content_ru', $page->content['ru'] ?? '') }}</textarea>
                    @error('content_ru')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Order') }}</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $page->order) }}" min="0" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-indigo-600 focus:ring-indigo-500">
                    <label for="is_active" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('Active') }}</label>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition-colors duration-200">
                        {{ __('Update Page') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
