<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Categories') }}</h2>
        <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition-colors duration-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            {{ __('Add Category') }}
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Sort Filter -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 mb-4">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="flex gap-4 items-center">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Sort By') }}:</label>
            <select name="sort" onchange="this.form.submit()" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                <option value="manual" {{ $sort == 'manual' ? 'selected' : '' }}>{{ __('Manual Order') }}</option>
                <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>{{ __('Newest First') }}</option>
                <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>{{ __('Oldest First') }}</option>
                <option value="alphabetical" {{ $sort == 'alphabetical' ? 'selected' : '' }}>{{ __('A-Z') }}</option>
                <option value="alphabetical_desc" {{ $sort == 'alphabetical_desc' ? 'selected' : '' }}>{{ __('Z-A') }}</option>
            </select>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600 dark:text-gray-400">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs uppercase font-medium text-gray-500 dark:text-gray-300">
                    <tr>
                        @if($sort == 'manual')
                        <th class="px-6 py-4 w-12">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                            </svg>
                        </th>
                        @endif
                        <th class="px-6 py-4">{{ __('Order') }}</th>
                        <th class="px-6 py-4">{{ __('Name') }}</th>
                        <th class="px-6 py-4">Icon</th>
                        <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody id="sortable-categories" class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors sortable-row" data-id="{{ $category->id }}">
                            @if($sort == 'manual')
                            <td class="px-6 py-4 handle" style="cursor: grab;">
                                <svg class="w-6 h-6 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 3H11V5H9V3ZM13 3H15V5H13V3ZM9 7H11V9H9V7ZM13 7H15V9H13V7ZM9 11H11V13H9V11ZM13 11H15V13H13V11ZM9 15H11V17H9V15ZM13 15H15V17H13V15ZM9 19H11V21H9V19ZM13 19H15V21H13V19Z" />
                                </svg>
                            </td>
                            @endif
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.categories.update-order', $category) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="order" value="{{ $category->order }}" 
                                           class="w-20 px-2 py-1 text-center border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           min="1" onchange="this.form.submit()">
                                </form>
                            </td>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $category->name }}</td>
                            <td class="px-6 py-4">
                                @if($category->icon)
                                    @if(Str::endsWith($category->icon, '.png'))
                                        <img src="{{ asset('size-512/images/' . $category->icon) }}" alt="{{ $category->name }}" class="w-8 h-8 object-contain">
                                    @else
                                        <span class="text-xl">{{ $category->icon }}</span>
                                    @endif
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.categories.subcategories.index', $category) }}" 
                                       class="inline-flex items-center p-2 text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-colors" 
                                       title="{{ __('Manage Subcategories') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                        </svg>
                                        <span class="hidden md:inline-flex ml-1 px-2 py-0.5 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded-full text-xs font-medium">({{ $category->subcategories_count }})</span>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                {{ __('No categories found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $categories->appends(['sort' => $sort])->links() }}
        </div>
    </div>

    @if($sort == 'manual')
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortable = new Sortable(document.getElementById('sortable-categories'), {
                handle: '.handle',
                animation: 200,
                easing: 'cubic-bezier(0.4, 0, 0.2, 1)',
                ghostClass: 'opacity-50',
                chosenClass: 'bg-blue-50 dark:bg-blue-900/20',
                dragClass: 'opacity-0',
                forceFallback: false,
                fallbackTolerance: 3,
                onStart: function(evt) {
                    const handle = evt.item.querySelector('.handle');
                    if (handle) handle.style.cursor = 'grabbing';
                },
                onEnd: function(evt) {
                    const handle = evt.item.querySelector('.handle');
                    if (handle) handle.style.cursor = 'grab';
                    
                    const items = document.querySelectorAll('.sortable-row');
                    const orders = Array.from(items).map(item => item.getAttribute('data-id'));
                    
                    fetch('{{ route('admin.categories.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ orders: orders })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        }
                    });
                }
            });
        });
    </script>
    @endpush
    @endif
</x-admin-layout>