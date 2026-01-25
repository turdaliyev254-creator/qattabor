<x-admin-layout>
    @if(isset($category) && $category)
        <x-breadcrumb :items="[
            ['label' => __('Categories'), 'url' => route('admin.categories.index')],
            ['label' => $category->name, 'url' => route('admin.categories.edit', $category), 'icon' => $category->icon, 'color' => $category->color],
            ['label' => __('Subcategories'), 'url' => null]
        ]" />
        
        <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 text-sm text-gray-700 dark:text-gray-300">
            <strong>{{ __('Context') }}:</strong> {{ __('Managing subcategories for') }} <strong class="text-gray-900 dark:text-white">{{ $category->name }}</strong>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Subcategories') }}</h2>
        <a href="@if(isset($category) && $category){{ route('admin.categories.subcategories.create', $category) }}@else{{ route('admin.subcategories.create') }}@endif" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition-colors duration-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            {{ __('Add Subcategory') }}
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Search and Sort Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 mb-4">
        <form method="GET" action="{{ route('admin.subcategories.index') }}" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search subcategories...') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
            </div>
            <div>
                <select name="sort" onchange="this.form.submit()" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    <option value="manual" {{ request('sort', 'manual') === 'manual' ? 'selected' : '' }}>{{ __('Manual Order') }}</option>
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>{{ __('Newest First') }}</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>{{ __('Oldest First') }}</option>
                    <option value="alphabetical" {{ request('sort') === 'alphabetical' ? 'selected' : '' }}>{{ __('A-Z') }}</option>
                    <option value="alphabetical_desc" {{ request('sort') === 'alphabetical_desc' ? 'selected' : '' }}>{{ __('Z-A') }}</option>
                </select>
                <input type="hidden" name="search" value="{{ request('search') }}">
            </div>
            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition-colors duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                {{ __('Search') }}
            </button>
            @if(request('search'))
                <a href="{{ route('admin.subcategories.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-white rounded-lg shadow-sm transition-colors duration-200">
                    {{ __('Clear') }}
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="sortable-table" class="w-full text-left text-sm text-gray-600 dark:text-gray-400">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs uppercase font-medium text-gray-500 dark:text-gray-300">
                    <tr>
                        @if(request('sort', 'manual') === 'manual')
                            <th class="px-6 py-4 w-12"></th>
                        @endif
                        <th class="px-6 py-4 w-20">{{ __('Order') }}</th>
                        <th class="px-6 py-4">{{ __('Icon') }}</th>
                        <th class="px-6 py-4">{{ __('Name') }}</th>
                        <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($subcategories as $subcategory)
                        <tr class="sortable-row hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors" data-id="{{ $subcategory->id }}">
                            @if(request('sort', 'manual') === 'manual')
                                <td class="px-6 py-4 handle" style="cursor: grab;">
                                    <svg class="w-6 h-6 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 3H11V5H9V3ZM13 3H15V5H13V3ZM9 7H11V9H9V7ZM13 7H15V9H13V7ZM9 11H11V13H9V11ZM13 11H15V13H13V11ZM9 15H11V17H9V15ZM13 15H15V17H13V15ZM9 19H11V21H9V19ZM13 19H15V21H13V19Z" />
                                    </svg>
                                </td>
                            @endif
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.subcategories.update-order', $subcategory) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="order" value="{{ $subcategory->order }}" min="1" onchange="this.form.submit()" class="w-16 px-2 py-1 text-center rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                @if($subcategory->icon)
                                    <img src="/size-512/images/{{ $subcategory->icon }}" alt="{{ $subcategory->name }}" class="w-8 h-8 object-contain">
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $subcategory->name }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.subcategories.places.index', $subcategory) }}" 
                                       class="inline-flex items-center p-2 text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition-colors" 
                                       title="{{ __('Manage Places') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="hidden md:inline-flex ml-1 px-2 py-0.5 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-full text-xs">({{ $subcategory->places_count }})</span>
                                    </a>
                                    <a href="{{ route('admin.subcategories.edit', $subcategory) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00 2 2h11a2 2 0 00 2-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.subcategories.destroy', $subcategory) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}');" class="inline">
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
                            <td colspan="{{ request('sort', 'manual') === 'manual' ? '8' : '7' }}" class="px-6 py-8 text-center text-gray-500">
                                @if(request('search'))
                                    {{ __('No subcategories found matching') }} "{{ request('search') }}".
                                @else
                                    {{ __('No subcategories found.') }}
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $subcategories->appends(['sort' => request('sort', 'manual'), 'search' => request('search')])->links() }}
        </div>
    </div>

    @if(request('sort', 'manual') === 'manual')
        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
        <script>
            const table = document.querySelector('#sortable-table tbody');
            if (table) {
                const sortable = new Sortable(table, {
                    handle: '.handle',
                    animation: 200,
                    easing: 'cubic-bezier(0.4, 0, 0.2, 1)',
                    ghostClass: 'opacity-50',
                    chosenClass: 'bg-blue-50 dark:bg-blue-900/20',
                    dragClass: 'opacity-0',
                    forceFallback: false,
                    fallbackTolerance: 3,
                    onStart: function(evt) {
                        evt.item.style.cursor = 'grabbing';
                    },
                    onEnd: function (evt) {
                        evt.item.style.cursor = '';
                        const rows = table.querySelectorAll('.sortable-row');
                        const orders = Array.from(rows).map(row => row.dataset.id);
                        
                        fetch('{{ route('admin.subcategories.reorder') }}', {
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
                                location.reload();
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                });
            }
        </script>
        @endpush
    @endif
</x-admin-layout>
