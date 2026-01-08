@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-8">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:underline mb-4">
                ← {{ __('back_to_dashboard') }}
            </a>
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700/50 p-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('profile_settings') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">{{ __('manage_your_account_information') }}</p>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-6 backdrop-blur-xl bg-green-500/20 border border-green-500/30 rounded-2xl p-4">
            <p class="text-green-800 dark:text-green-200">{{ session('success') }}</p>
        </div>
        @endif

        @if(session('status') === 'password-updated')
        <div class="mb-6 backdrop-blur-xl bg-green-500/20 border border-green-500/30 rounded-2xl p-4">
            <p class="text-green-800 dark:text-green-200">{{ __('Password updated successfully') }}</p>
        </div>
        @endif

        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Avatar Section -->
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">{{ __('profile_picture') }}</h2>
                
                <div class="flex items-center gap-6">
                    <div class="relative">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" 
                                 id="avatar-preview"
                                 class="w-32 h-32 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-lg">
                        @else
                            <div id="avatar-preview" class="w-32 h-32 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-5xl font-bold shadow-lg">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-1">
                        <label class="block">
                            <span class="sr-only">{{ __('choose_avatar') }}</span>
                            <input type="file" name="avatar" accept="image/jpeg,image/jpg,image/png" 
                                   class="block w-full text-sm text-gray-900 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400"
                                   onchange="previewAvatar(event)">
                        </label>
                        <p class="text-sm text-gray-500 dark:text-gray-500 mt-2">{{ __('jpg_png_max_2mb') }}</p>
                        @error('avatar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        
                        @if($user->avatar)
                        <form action="{{ route('user.profile.delete-avatar') }}" method="POST" class="mt-3" onsubmit="return confirm('{{ __('delete_avatar_confirm') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:underline">
                                {{ __('delete_avatar') }}
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">{{ __('personal_information') }}</h2>
                
                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('name') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-4 py-3 rounded-xl backdrop-blur-md bg-white/50 dark:bg-gray-700/50 border border-white/30 dark:border-gray-600/30 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('phone') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" required
                               class="w-full px-4 py-3 rounded-xl backdrop-blur-md bg-white/50 dark:bg-gray-700/50 border border-white/30 dark:border-gray-600/30 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                               placeholder="+998901234567">
                        @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('email') }} <span class="text-gray-400">({{ __('optional') }})</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-3 rounded-xl backdrop-blur-md bg-white/50 dark:bg-gray-700/50 border border-white/30 dark:border-gray-600/30 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                               placeholder="email@example.com">
                        @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>



            <!-- Submit Button -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('user.dashboard') }}" 
                   class="px-8 py-3 backdrop-blur-md bg-white/70 dark:bg-gray-700/70 text-gray-700 dark:text-gray-300 rounded-full hover:shadow-xl transition-all duration-300 hover:scale-105 font-semibold border border-white/30 dark:border-gray-600/30">
                    {{ __('cancel') }}
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full hover:shadow-xl transition-all duration-300 hover:scale-105 font-semibold">
                    {{ __('save_changes') }}
                </button>
            </div>
        </form>

        <!-- Change Password Section (Separate Form) -->
        <form action="{{ route('password.update') }}" method="POST" id="passwordForm">
            @csrf
            @method('PUT')
            
            <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-gray-700/50 p-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">{{ __('Change Password') }}</h2>
                
                <div class="space-y-4">
                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Current Password') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password"
                                   class="w-full px-4 py-3 pr-12 rounded-xl backdrop-blur-md bg-white/50 dark:bg-gray-700/50 border border-white/30 dark:border-gray-600/30 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                            <button type="button" onclick="togglePasswordField('current_password', 'eyeIconCurrent')" class="absolute right-4 top-1/2 transform -translate-y-1/2 focus:outline-none">
                                <img src="/size-512/images/eye.png" alt="{{ __('Show password') }}" class="w-5 h-5 opacity-60 hover:opacity-100 transition-opacity" id="eyeIconCurrent">
                            </button>
                        </div>
                        @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('New Password') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="new_password"
                                   class="w-full px-4 py-3 pr-12 rounded-xl backdrop-blur-md bg-white/50 dark:bg-gray-700/50 border border-white/30 dark:border-gray-600/30 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                            <button type="button" onclick="togglePasswordField('new_password', 'eyeIconNew')" class="absolute right-4 top-1/2 transform -translate-y-1/2 focus:outline-none">
                                <img src="/size-512/images/eye.png" alt="{{ __('Show password') }}" class="w-5 h-5 opacity-60 hover:opacity-100 transition-opacity" id="eyeIconNew">
                            </button>
                        </div>
                        @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1 hidden" id="newPasswordError"></p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Confirm Password') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation_profile"
                                   class="w-full px-4 py-3 pr-12 rounded-xl backdrop-blur-md bg-white/50 dark:bg-gray-700/50 border border-white/30 dark:border-gray-600/30 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                            <button type="button" onclick="togglePasswordField('password_confirmation_profile', 'eyeIconConfirm')" class="absolute right-4 top-1/2 transform -translate-y-1/2 focus:outline-none">
                                <img src="/size-512/images/eye.png" alt="{{ __('Show password') }}" class="w-5 h-5 opacity-60 hover:opacity-100 transition-opacity" id="eyeIconConfirm">
                            </button>
                        </div>
                        @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1 hidden" id="confirmPasswordError"></p>
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full hover:shadow-xl transition-all duration-300 hover:scale-105 font-semibold">
                            {{ __('Change Password') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                preview.outerHTML = `<img src="${e.target.result}" alt="Preview" id="avatar-preview" class="w-32 h-32 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-lg">`;
            }
        }
        reader.readAsDataURL(file);
    }
}

function togglePasswordField(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input && icon) {
        if (input.type === 'password') {
            input.type = 'text';
            icon.alt = '{{ __("Hide password") }}';
        } else {
            input.type = 'password';
            icon.alt = '{{ __("Show password") }}';
        }
    }
}

// Client-side password validation for password change form
document.addEventListener('DOMContentLoaded', function() {
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('password_confirmation_profile');
    const newPasswordError = document.getElementById('newPasswordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');
    const passwordForm = document.getElementById('passwordForm');

    if (newPasswordInput && confirmPasswordInput && newPasswordError && confirmPasswordError && passwordForm) {
        function validateNewPassword() {
            const value = newPasswordInput.value;
            if (value && value.length < 8) {
                newPasswordError.textContent = '{{ __("Password must be at least 8 characters") }}';
                newPasswordError.classList.remove('hidden');
                newPasswordInput.classList.add('border-red-500');
                return false;
            } else {
                newPasswordError.classList.add('hidden');
                newPasswordInput.classList.remove('border-red-500');
                return true;
            }
        }

        function validatePasswordConfirmation() {
            const password = newPasswordInput.value;
            const confirm = confirmPasswordInput.value;
            if (confirm && password !== confirm) {
                confirmPasswordError.textContent = '{{ __("Passwords must match") }}';
                confirmPasswordError.classList.remove('hidden');
                confirmPasswordInput.classList.add('border-red-500');
                return false;
            } else {
                confirmPasswordError.classList.add('hidden');
                confirmPasswordInput.classList.remove('border-red-500');
                return true;
            }
        }

        if (newPasswordInput && typeof newPasswordInput.addEventListener === 'function') {
            newPasswordInput.addEventListener('input', validateNewPassword);
            newPasswordInput.addEventListener('blur', validateNewPassword);
        }
        
        if (confirmPasswordInput && typeof confirmPasswordInput.addEventListener === 'function') {
            confirmPasswordInput.addEventListener('input', validatePasswordConfirmation);
            confirmPasswordInput.addEventListener('blur', validatePasswordConfirmation);
        }

        if (passwordForm && typeof passwordForm.addEventListener === 'function') {
            passwordForm.addEventListener('submit', function(e) {
                const newPasswordValid = validateNewPassword();
                const confirmValid = validatePasswordConfirmation();
                
                if (!newPasswordValid || !confirmValid) {
                    e.preventDefault();
                }
            });
        }
    }
});
</script>
@endsection
