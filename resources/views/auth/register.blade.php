<x-guest-layout>
    <!-- Header with Logo and Language Switcher -->
    <div class="text-center mb-8">
        <div class="flex justify-center mb-4">
            <x-application-logo class="w-16 h-16 text-blue-600 dark:text-blue-400" />
        </div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
            {{ __('Create Account') }}
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Join Qattabor to discover amazing places') }}
        </p>
    </div>

    <!-- Language Switcher -->
    <div class="flex justify-center gap-2 mb-6">
        <form method="POST" action="/language/en" class="inline">
            @csrf
            <button type="submit" class="px-4 py-2 text-xs font-medium rounded-lg {{ app()->getLocale() === 'en' ? 'bg-blue-600 text-white shadow-lg' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }} transition-all duration-200">EN</button>
        </form>
        <form method="POST" action="/language/uz" class="inline">
            @csrf
            <button type="submit" class="px-4 py-2 text-xs font-medium rounded-lg {{ app()->getLocale() === 'uz' ? 'bg-blue-600 text-white shadow-lg' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }} transition-all duration-200">UZ</button>
        </form>
        <form method="POST" action="/language/ru" class="inline">
            @csrf
            <button type="submit" class="px-4 py-2 text-xs font-medium rounded-lg {{ app()->getLocale() === 'ru' ? 'bg-blue-600 text-white shadow-lg' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }} transition-all duration-200">RU</button>
        </form>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5" id="registerForm">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-700 dark:text-gray-300 font-medium mb-2 text-sm flex items-center gap-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone')" class="text-gray-700 dark:text-gray-300 font-medium mb-2 text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <x-text-input id="phone" class="block w-full pl-10 pr-4 py-3 text-sm rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white placeholder-gray-400 transition-all duration-200"
                            type="tel"
                            name="phone"
                            :value="old('phone')"
                            placeholder="+998XXXXXXXXX"
                            required autocomplete="off" />
            </div>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 hidden" id="phoneError"></p>
        </div>-text-input id="phone" class="block mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-lg backdrop-blur-md bg-white/50 dark:bg-black/30 border border-white/50 dark:border-white/20 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/50 dark:focus:ring-blue-400/50 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 shadow-lg"
        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 dark:text-gray-300 font-medium mb-2 text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <x-text-input id="password" class="block w-full pl-10 pr-12 py-3 text-sm rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white placeholder-gray-400 transition-all duration-200"
                                type="password"
                                name="password"
                                placeholder="{{ __('Min. 8 characters') }}"
                                required autocomplete="off" />
                <button type="button" onclick="togglePassword('password', 'eyeIcon1')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="eyeIcon1">
        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 dark:text-gray-300 font-medium mb-2 text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <x-text-input id="password_confirmation" class="block w-full pl-10 pr-12 py-3 text-sm rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white placeholder-gray-400 transition-all duration-200"
                                type="password"
                                name="password_confirmation"
                                placeholder="{{ __('Re-enter password') }}"
                                required autocomplete="off" />
                <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="eyeIcon2">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 hidden" id="confirmError"></p>
        </div> class="text-xs text-red-600 dark:text-red-400 mt-1 hidden" id="passwordError"></p>
        <div class="flex flex-col gap-4 mt-8">
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3.5 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                {{ __('Create Account') }}
            </button>
            
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white dark:bg-gray-900 text-gray-500 dark:text-gray-400">
                        {{ __('Already have an account?') }}
                    </span>
    <script>
        // Password visibility toggle
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }/div>

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
