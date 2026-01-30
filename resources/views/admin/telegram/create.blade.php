<x-admin-layout>
    <div class="min-h-screen bg-gradient-warm p-6 space-y-8">
        <!-- Header -->
        <div class="glass-card p-8 animate-fade-in">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('admin.telegram.index') }}" class="text-warm-gray-600 hover:text-warm-gray-900 dark:text-warm-gray-400 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="heading-large text-warm-gray-900 dark:text-white">{{ __('Create Broadcast') }}</h1>
            </div>
        </div>

        <!-- Create Form -->
        <form action="{{ route('admin.telegram.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Caption -->
            <div class="glass-card p-8">
                <h2 class="text-xl font-bold text-warm-gray-900 dark:text-white mb-4">{{ __('Caption') }}</h2>
                <textarea 
                    name="caption" 
                    rows="5" 
                    class="w-full px-4 py-3 rounded-lg border border-warm-gray-300 dark:border-warm-gray-600 bg-white dark:bg-warm-gray-800 text-warm-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="{{ __('Enter your broadcast message...') }}"
                    required
                >{{ old('caption') }}</textarea>
                @error('caption')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
                <p class="text-sm text-warm-gray-500 mt-2">{{ __('Maximum 1000 characters') }}</p>
            </div>

            <!-- Media Upload -->
            <div class="glass-card p-8">
                <h2 class="text-xl font-bold text-warm-gray-900 dark:text-white mb-4">{{ __('Media') }} ({{ __('Optional') }})</h2>
                <input 
                    type="file" 
                    name="media" 
                    accept="image/jpeg,image/jpg,image/png,video/mp4,video/quicktime"
                    class="w-full px-4 py-3 rounded-lg border border-warm-gray-300 dark:border-warm-gray-600 bg-white dark:bg-warm-gray-800 text-warm-gray-900 dark:text-white"
                >
                @error('media')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
                <p class="text-sm text-warm-gray-500 mt-2">{{ __('Supported formats: JPG, PNG, MP4, MOV. Max size: 20MB') }}</p>
            </div>

            <!-- Target Regions -->
            <div class="glass-card p-8">
                <h2 class="text-xl font-bold text-warm-gray-900 dark:text-white mb-4">{{ __('Target Regions') }}</h2>
                <div class="space-y-3">
                    <label class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                        <input 
                            type="checkbox" 
                            name="target_regions[]" 
                            value="all"
                            class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500"
                            onchange="toggleAllRegions(this)"
                            {{ is_array(old('target_regions')) && in_array('all', old('target_regions')) ? 'checked' : '' }}
                        >
                        <span class="ml-3 text-warm-gray-900 dark:text-white font-semibold">{{ __('All Regions') }}</span>
                    </label>

                    @foreach($regions as $region)
                        <label class="flex items-center p-4 bg-warm-gray-50 dark:bg-warm-gray-800 rounded-lg cursor-pointer hover:bg-warm-gray-100 dark:hover:bg-warm-gray-700 transition-colors region-checkbox">
                            <input 
                                type="checkbox" 
                                name="target_regions[]" 
                                value="{{ $region->id }}"
                                class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500"
                                {{ is_array(old('target_regions')) && in_array($region->id, old('target_regions')) ? 'checked' : '' }}
                            >
                            <span class="ml-3 text-warm-gray-900 dark:text-white">{{ $region->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('target_regions')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Social Links -->
            <div class="glass-card p-8">
                <h2 class="text-xl font-bold text-warm-gray-900 dark:text-white mb-4">{{ __('Social Links') }} ({{ __('Optional') }})</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-warm-gray-700 dark:text-warm-gray-300 mb-2">
                            ✈️ {{ __('Telegram') }}
                        </label>
                        <input 
                            type="text" 
                            name="links[tg]" 
                            value="{{ old('links.tg') }}"
                            placeholder="@username or t.me/username"
                            class="w-full px-4 py-3 rounded-lg border border-warm-gray-300 dark:border-warm-gray-600 bg-white dark:bg-warm-gray-800 text-warm-gray-900 dark:text-white"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-warm-gray-700 dark:text-warm-gray-300 mb-2">
                            📸 {{ __('Instagram') }}
                        </label>
                        <input 
                            type="text" 
                            name="links[inst]" 
                            value="{{ old('links.inst') }}"
                            placeholder="instagram.com/username"
                            class="w-full px-4 py-3 rounded-lg border border-warm-gray-300 dark:border-warm-gray-600 bg-white dark:bg-warm-gray-800 text-warm-gray-900 dark:text-white"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-warm-gray-700 dark:text-warm-gray-300 mb-2">
                            🔵 {{ __('Facebook') }}
                        </label>
                        <input 
                            type="text" 
                            name="links[fb]" 
                            value="{{ old('links.fb') }}"
                            placeholder="facebook.com/page"
                            class="w-full px-4 py-3 rounded-lg border border-warm-gray-300 dark:border-warm-gray-600 bg-white dark:bg-warm-gray-800 text-warm-gray-900 dark:text-white"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-warm-gray-700 dark:text-warm-gray-300 mb-2">
                            🎬 {{ __('Youtube') }}
                        </label>
                        <input 
                            type="text" 
                            name="links[yt]" 
                            value="{{ old('links.yt') }}"
                            placeholder="youtube.com/@channel"
                            class="w-full px-4 py-3 rounded-lg border border-warm-gray-300 dark:border-warm-gray-600 bg-white dark:bg-warm-gray-800 text-warm-gray-900 dark:text-white"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-warm-gray-700 dark:text-warm-gray-300 mb-2">
                            📞 {{ __('Phone') }}
                        </label>
                        <input 
                            type="text" 
                            name="links[tel]" 
                            value="{{ old('links.tel') }}"
                            placeholder="+998901234567"
                            class="w-full px-4 py-3 rounded-lg border border-warm-gray-300 dark:border-warm-gray-600 bg-white dark:bg-warm-gray-800 text-warm-gray-900 dark:text-white"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-warm-gray-700 dark:text-warm-gray-300 mb-2">
                            🌐 {{ __('Website') }}
                        </label>
                        <input 
                            type="text" 
                            name="links[web]" 
                            value="{{ old('links.web') }}"
                            placeholder="example.com"
                            class="w-full px-4 py-3 rounded-lg border border-warm-gray-300 dark:border-warm-gray-600 bg-white dark:bg-warm-gray-800 text-warm-gray-900 dark:text-white"
                        >
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('admin.telegram.index') }}" class="btn btn-secondary">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="btn btn-primary">
                    {{ __('Create Broadcast') }}
                </button>
            </div>
        </form>
    </div>

    <script>
        function toggleAllRegions(checkbox) {
            const regionCheckboxes = document.querySelectorAll('.region-checkbox input[type="checkbox"]');
            regionCheckboxes.forEach(cb => {
                cb.checked = checkbox.checked;
                cb.disabled = checkbox.checked;
            });
        }
    </script>
</x-admin-layout>
