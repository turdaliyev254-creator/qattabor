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

    <form method="POST" action="{{ route('register') }}" class="space-y-4" id="registerForm">
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
                            required autocomplete="off" />
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
                                required autocomplete="off" />
                <button type="button" onclick="togglePassword('password', 'eyeIcon1')" class="absolute right-3 top-1/2 transform -translate-y-1/2 focus:outline-none">
                    <img src="/size-512/images/eye.png" alt="{{ __('Show password') }}" class="w-5 h-5 opacity-60 hover:opacity-100 transition-opacity" id="eyeIcon1">
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
            <p class="text-xs text-red-600 dark:text-red-400 mt-1 hidden" id="passwordError"></p>
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-800 dark:text-white font-semibold mb-1.5 drop-shadow text-sm" />
            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1.5 w-full px-3.5 py-2.5 pr-10 text-sm rounded-lg backdrop-blur-md bg-white/50 dark:bg-black/30 border border-white/50 dark:border-white/20 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/50 dark:focus:ring-blue-400/50 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 shadow-lg"
                                type="password"
                                name="password_confirmation"
                                required autocomplete="off" />
                <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')" class="absolute right-3 top-1/2 transform -translate-y-1/2 focus:outline-none">
                    <img src="/size-512/images/eye.png" alt="{{ __('Show password') }}" class="w-5 h-5 opacity-60 hover:opacity-100 transition-opacity" id="eyeIcon2">
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
            <p class="text-xs text-red-600 dark:text-red-400 mt-1 hidden" id="confirmError"></p>
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

        // Client-side validation
        const phoneInput = document.getElementById('phone');
        const phoneError = document.getElementById('phoneError');
        const passwordInput = document.getElementById('password');
        const passwordError = document.getElementById('passwordError');
        const confirmInput = document.getElementById('password_confirmation');
        const confirmError = document.getElementById('confirmError');
        const phoneRegex = /^\+998[0-9]{9}$/;

        phoneInput.addEventListener('input', validatePhone);
        phoneInput.addEventListener('blur', validatePhone);
        passwordInput.addEventListener('input', validatePassword);
        passwordInput.addEventListener('blur', validatePassword);
        confirmInput.addEventListener('input', validateConfirm);
        confirmInput.addEventListener('blur', validateConfirm);

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

        function validatePassword() {
            const value = passwordInput.value;
            if (value && value.length < 8) {
                passwordError.textContent = '{{ __("Password must be at least 8 characters") }}';
                passwordError.classList.remove('hidden');
                passwordInput.classList.add('border-red-500');
                return false;
            } else {
                passwordError.classList.add('hidden');
                passwordInput.classList.remove('border-red-500');
                return true;
            }
        }

        function validateConfirm() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;
            if (confirm && password !== confirm) {
                confirmError.textContent = '{{ __("Passwords must match") }}';
                confirmError.classList.remove('hidden');
                confirmInput.classList.add('border-red-500');
                return false;
            } else {
                confirmError.classList.add('hidden');
                confirmInput.classList.remove('border-red-500');
                return true;
            }
        }

        // Form validation on submit
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const phoneValid = validatePhone();
            const passwordValid = validatePassword();
            const confirmValid = validateConfirm();
            
            if (!phoneValid || !passwordValid || !confirmValid) {
                e.preventDefault();
            }
        });
    </script>
</x-guest-layout>
