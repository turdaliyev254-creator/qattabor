<nav x-data="{ open: false }" class="glass sticky top-0 z-50 border-b border-gray-100 dark:border-gray-800">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-500 to-accent-500 flex items-center justify-center">
                        <x-application-logo class="block h-5 w-5 fill-current text-white" />
                    </div>
                    <span class="font-bold text-lg gradient-text">Qattabor</span>
                </a>
            </div>
        </div>
    </div>
</nav>
