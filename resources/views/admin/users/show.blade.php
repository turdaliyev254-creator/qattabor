<x-admin-layout>
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            {{ __('Back to Users') }}
        </a>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('User Details') }}</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Information -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('User Information') }}</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('ID') }}</label>
                        <p class="text-gray-900 dark:text-white">#{{ $user->id }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Name') }}</label>
                        <p class="text-gray-900 dark:text-white">{{ $user->name }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Phone') }}</label>
                        <p class="text-gray-900 dark:text-white">{{ $user->phone ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Email') }}</label>
                        <p class="text-gray-900 dark:text-white">{{ $user->email ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Role') }}</label>
                        <p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Registration Date') }}</label>
                        <p class="text-gray-900 dark:text-white">{{ $user->created_at->format('F d, Y') }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Statistics') }}</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('Owned Places') }}</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $user->ownedPlaces->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('Saved Places') }}</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $user->savedPlaces->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('Comments') }}</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $user->comments->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Owned Places -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Owned Places') }} ({{ $user->ownedPlaces->count() }})</h3>
                
                @if($user->ownedPlaces->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->ownedPlaces as $place)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $place->name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $place->category->name ?? __('No category') }}</p>
                                    <div class="flex gap-4 mt-2 text-xs text-gray-600 dark:text-gray-400">
                                        <span>{{ __('Views:') }} {{ $place->views_count }}</span>
                                        <span>{{ __('Comments:') }} {{ $place->comments->count() }}</span>
                                        <span>{{ __('Saves:') }} {{ $place->savedByUsers->count() }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('admin.places.edit', $place) }}" class="ml-4 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm transition-colors">
                                    {{ __('Edit') }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">{{ __('No owned places yet.') }}</p>
                @endif
            </div>

            <!-- Recent Comments -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Recent Comments') }} ({{ $user->comments->count() }})</h3>
                
                @if($user->comments->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->comments->take(5) as $comment)
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-900 dark:text-white">{{ Str::limit($comment->content, 100) }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ __('On:') }} <a href="{{ route('places.show', $comment->place->slug) }}" class="text-indigo-600 hover:text-indigo-800">{{ $comment->place->name }}</a>
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="ml-4 px-2 py-1 text-xs rounded-full {{ $comment->is_approved ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                        {{ $comment->is_approved ? __('Approved') : __('Pending') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">{{ __('No comments yet.') }}</p>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
