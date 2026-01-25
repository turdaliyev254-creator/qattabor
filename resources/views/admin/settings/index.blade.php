@extends('layouts.admin')

@section('content')
    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ __('Site Settings') }}</h1>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- About Us Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">{{ __('About Us') }}</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="about_us_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('About Us (English)') }}
                        </label>
                        <textarea name="about_us_en" id="about_us_en" rows="6" 
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                        >{{ old('about_us_en', $aboutUs['en'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label for="about_us_uz" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('About Us (Uzbek)') }}
                        </label>
                        <textarea name="about_us_uz" id="about_us_uz" rows="6" 
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                        >{{ old('about_us_uz', $aboutUs['uz'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label for="about_us_ru" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('About Us (Russian)') }}
                        </label>
                        <textarea name="about_us_ru" id="about_us_ru" rows="6" 
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                        >{{ old('about_us_ru', $aboutUs['ru'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">{{ __('Contact Information') }}</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Phone') }}
                        </label>
                        <input type="text" name="contact_phone" id="contact_phone" 
                            value="{{ old('contact_phone', $contact['phone'] ?? '') }}"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>

                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Email') }}
                        </label>
                        <input type="email" name="contact_email" id="contact_email" 
                            value="{{ old('contact_email', $contact['email'] ?? '') }}"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>

                    <div class="md:col-span-2">
                        <label for="contact_address_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Address (English)') }}
                        </label>
                        <input type="text" name="contact_address_en" id="contact_address_en" 
                            value="{{ old('contact_address_en', $contact['address_en'] ?? '') }}"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>

                    <div class="md:col-span-2">
                        <label for="contact_address_uz" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Address (Uzbek)') }}
                        </label>
                        <input type="text" name="contact_address_uz" id="contact_address_uz" 
                            value="{{ old('contact_address_uz', $contact['address_uz'] ?? '') }}"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>

                    <div class="md:col-span-2">
                        <label for="contact_address_ru" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Address (Russian)') }}
                        </label>
                        <input type="text" name="contact_address_ru" id="contact_address_ru" 
                            value="{{ old('contact_address_ru', $contact['address_ru'] ?? '') }}"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>

                    <div>
                        <label for="contact_facebook" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Facebook URL') }}
                        </label>
                        <input type="url" name="contact_facebook" id="contact_facebook" 
                            value="{{ old('contact_facebook', $contact['facebook'] ?? '') }}"
                            placeholder="https://facebook.com/..."
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>

                    <div>
                        <label for="contact_instagram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Instagram URL') }}
                        </label>
                        <input type="url" name="contact_instagram" id="contact_instagram" 
                            value="{{ old('contact_instagram', $contact['instagram'] ?? '') }}"
                            placeholder="https://instagram.com/..."
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>

                    <div>
                        <label for="contact_telegram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Telegram URL') }}
                        </label>
                        <input type="url" name="contact_telegram" id="contact_telegram" 
                            value="{{ old('contact_telegram', $contact['telegram'] ?? '') }}"
                            placeholder="https://t.me/..."
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>
                </div>
            </div>

            <!-- News Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">{{ __('News') }}</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="news_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('News (English)') }}
                        </label>
                        <textarea name="news_en" id="news_en" rows="6" 
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                        >{{ old('news_en', $news['en'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label for="news_uz" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('News (Uzbek)') }}
                        </label>
                        <textarea name="news_uz" id="news_uz" rows="6" 
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                        >{{ old('news_uz', $news['uz'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label for="news_ru" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('News (Russian)') }}
                        </label>
                        <textarea name="news_ru" id="news_ru" rows="6" 
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                        >{{ old('news_ru', $news['ru'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition-colors duration-200">
                    {{ __('Save Settings') }}
                </button>
            </div>
        </form>
    </div>
@endsection
