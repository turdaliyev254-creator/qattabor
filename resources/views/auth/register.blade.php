<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-800 dark:text-white font-semibold mb-1.5 drop-shadow text-sm" />
            <x-text-input id="name" class="block mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-lg backdrop-blur-md bg-white/50 dark:bg-black/30 border border-white/50 dark:border-white/20 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/50 dark:focus:ring-blue-400/50 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 shadow-lg" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone')" class="text-gray-800 dark:text-white font-semibold mb-1.5 drop-shadow text-sm" />
            <x-text-input id="phone" class="block mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-lg backdrop-blur-md bg-white/50 dark:bg-black/30 border border-white/50 dark:border-white/20 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/50 dark:focus:ring-blue-400/50 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 shadow-lg"
                            type="tel"
                            name="phone"
                            :value="old('phone')"
                            placeholder="+998901234567"
                            required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-1.5" />
        </div>

        <div class="flex flex-col gap-3 mt-6">
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-2.5 px-6 text-sm rounded-lg shadow-2xl shadow-blue-500/50 dark:shadow-blue-900/50 transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 backdrop-blur-sm">
                {{ __('Register') }}
            </button>
            
            <div class="text-center">
                <a class="text-xs text-gray-800 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 font-semibold transition-colors drop-shadow" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
