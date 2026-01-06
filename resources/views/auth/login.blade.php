<x-guest-layout>
    <!-- Language Switcher -->
    <div class="flex justify-end gap-2 mb-4">
        <form method="POST" action="/language/en" class="inline">
            @csrf
            <button type="submit" class="px-3 py-1 text-xs rounded-lg backdrop-blur-md {{ app()->getLocale() === 'en' ? 'bg-blue-500 text-white' : 'bg-white/50 dark:bg-black/30 text-gray-800 dark:text-white' }} border border-white/50 dark:border-white/20 hover:bg-blue-400 transition-colors">EN</button>
        </form>
        <form method="POST" action="/language/uz" class="inline">
            @csrf
            <button type="submit" class="px-3 py-1 text-xs rounded-lg backdrop-blur-md {{ app()->getLocale() === 'uz' ? 'bg-blue-500 text-white' : 'bg-white/50 dark:bg-black/30 text-gray-800 dark:text-white' }} border border-white/50 dark:border-white/20 hover:bg-blue-400 transition-colors">UZ</button>
        </form>
        <form method="POST" action="/language/ru" class="inline">
            @csrf
            <button type="submit" class="px-3 py-1 text-xs rounded-lg backdrop-blur-md {{ app()->getLocale() === 'ru' ? 'bg-blue-500 text-white' : 'bg-white/50 dark:bg-black/30 text-gray-800 dark:text-white' }} border border-white/50 dark:border-white/20 hover:bg-blue-400 transition-colors">RU</button>
        </form>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4" id="loginForm">
        @csrf

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone')" class="text-gray-800 dark:text-white font-semibold mb-1.5 drop-shadow text-sm" />
            <x-text-input id="phone" class="block mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-lg backdrop-blur-md bg-white/50 dark:bg-black/30 border border-white/50 dark:border-white/20 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/50 dark:focus:ring-blue-400/50 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 shadow-lg"
                            type="tel"
                            name="phone"
                            value=""
                            required autofocus autocomplete="off" />
            <x-input-error :messages="$errors->get('phone')" class="mt-1.5" />
            <p class="text-xs text-red-600 dark:text-red-400 mt-1 hidden" id="phoneError"></p>
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-800 dark:text-white font-semibold mb-1.5 drop-shadow text-sm" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1.5 w-full px-3.5 py-2.5 pr-10 text-sm rounded-lg backdrop-blur-md bg-white/50 dark:bg-black/30 border border-white/50 dark:border-white/20 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/50 dark:focus:ring-blue-400/50 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 shadow-lg"
                                type="password"
                                name="password"
                                value=""
                                required autocomplete="off" />
                <button type="button" onclick="togglePassword('password', 'eyeIcon')" class="absolute right-3 top-1/2 transform -translate-y-1/2 focus:outline-none">
                    <img src="/size-512/images/eye.png" alt="{{ __('Show password') }}" class="w-5 h-5 opacity-60 hover:opacity-100 transition-opacity" id="eyeIcon">
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-600 bg-white/50 dark:bg-black/30 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500 dark:focus:ring-blue-400 focus:ring-2">
            <label for="remember" class="ml-2 text-sm text-gray-800 dark:text-white font-medium">{{ __('Remember me') }}</label>
        </div>

        <div class="flex flex-col gap-3 mt-6">
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-2.5 px-6 text-sm rounded-lg shadow-2xl shadow-blue-500/50 dark:shadow-blue-900/50 transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 backdrop-blur-sm">
                {{ __('Log in') }}
            </button>
            
            <div class="text-center">
                <a class="text-xs text-gray-800 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 font-semibold transition-colors drop-shadow" href="{{ route('register') }}">
                    {{ __('Need an account?') }}
                </a>
            </div>
        </div>
    </form>

    <script>
        // Password visibility toggle
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.alt = '{{ __("Hide password") }}';
            } else {
                input.type = 'password';
                icon.alt = '{{ __("Show password") }}';
            }
        }

        // Client-side phone validation
        const phoneInput = document.getElementById('phone');
        const phoneError = document.getElementById('phoneError');
        const phoneRegex = /^\+998[0-9]{9}$/;

        phoneInput.addEventListener('input', function() {
            validatePhone();
        });

        phoneInput.addEventListener('blur', function() {
            validatePhone();
        });

        function validatePhone() {
            const value = phoneInput.value.trim();
            if (value && !phoneRegex.test(value)) {
                phoneError.textContent = '{{ __("phone_format_error") }}';
                phoneError.classList.remove('hidden');
                phoneInput.classList.add('border-red-500');
                return false;
            } else {
                phoneError.classList.add('hidden');
                phoneInput.classList.remove('border-red-500');
                return true;
            }
        }

        // Form validation on submit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            if (!validatePhone()) {
                e.preventDefault();
            }
        });
    </script>
</x-guest-layout>
