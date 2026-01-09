<x-admin-layout>
    <div class="mb-6">
        <a href="{{ route('admin.regions.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Regions
        </a>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Region: {{ $region->name }}</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 max-w-2xl">
        <form action="{{ route('admin.regions.update', $region) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name (Internal)</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $region->name) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name_uz" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name (Uzbek)</label>
                    <input type="text" name="name_uz" id="name_uz" value="{{ old('name_uz', $region->name_uz) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                    @error('name_uz')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name_ru" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name (Russian)</label>
                    <input type="text" name="name_ru" id="name_ru" value="{{ old('name_ru', $region->name_ru) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                    @error('name_ru')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name (English)</label>
                    <input type="text" name="name_en" id="name_en" value="{{ old('name_en', $region->name_en) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                    @error('name_en')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $region->slug) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Display Order</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $region->order) }}" min="0" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $region->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Active</span>
                    </label>
                </div>
            </div>

            <div class="pt-6 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 mt-6">
                <a href="{{ route('admin.regions.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition-colors duration-200">
                    Update Region
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
