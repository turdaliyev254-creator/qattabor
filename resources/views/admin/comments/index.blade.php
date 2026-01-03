<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Comments Management') }}</h2>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Tabs -->
    <div class="mb-6 flex gap-2">
        <a href="{{ route('admin.comments.index') }}" class="px-4 py-2 rounded-lg {{ !request('status') ? 'bg-indigo-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }} transition-colors">
            {{ __('All Comments') }}
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg {{ request('status') === 'pending' ? 'bg-yellow-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }} transition-colors">
            {{ __('Pending Approval') }}
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}" class="px-4 py-2 rounded-lg {{ request('status') === 'approved' ? 'bg-green-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }} transition-colors">
            {{ __('Approved') }}
        </a>
    </div>

    <!-- Comments List -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($comments as $comment)
                <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $comment->is_approved ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' }}">
                                    {{ $comment->is_approved ? __('Approved') : __('Pending') }}
                                </span>
                                @if($comment->rating)
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $comment->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                @endif
                            </div>
                            
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                {{ __('On:') }} <a href="{{ route('places.show', $comment->place->slug) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ $comment->place->name }}</a>
                                @if($comment->place->owner)
                                    <span class="text-gray-500">• {{ __('Owner:') }} {{ $comment->place->owner->name }}</span>
                                @endif
                            </p>
                            
                            <p class="text-gray-900 dark:text-white">{{ $comment->content }}</p>
                            
                            @if($comment->replies->count() > 0)
                                <div class="mt-3 ml-6 space-y-2">
                                    @foreach($comment->replies as $reply)
                                        <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border-l-4 border-indigo-500">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="font-semibold text-indigo-900 dark:text-indigo-300">{{ $reply->user->name }}</span>
                                                <span class="px-2 py-0.5 bg-indigo-100 dark:bg-indigo-900/40 text-indigo-800 dark:text-indigo-300 rounded text-xs font-semibold">{{ __('Owner Reply') }}</span>
                                            </div>
                                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $reply->content }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        
                        <div class="ml-4 flex gap-2">
                            @if(!$comment->is_approved)
                                <form action="{{ route('admin.comments.approve', $comment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm transition-colors">
                                        {{ __('Approve') }}
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this comment?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm transition-colors">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                    {{ __('No comments found.') }}
                </div>
            @endforelse
        </div>
        
        @if($comments->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $comments->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
