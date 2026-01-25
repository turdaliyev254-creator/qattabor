<x-admin-layout>
    @if(isset($subcategory) && $subcategory)
        <x-breadcrumb :items="[
            ['label' => __('Categories'), 'url' => route('admin.categories.index')],
            ['label' => $subcategory->category->name, 'url' => route('admin.categories.edit', $subcategory->category), 'icon' => $subcategory->category->icon, 'color' => $subcategory->category->color],
            ['label' => __('Subcategories'), 'url' => route('admin.categories.subcategories.index', $subcategory->category)],
            ['label' => $subcategory->name, 'url' => route('admin.subcategories.edit', $subcategory), 'icon' => $subcategory->icon],
            ['label' => __('Places'), 'url' => null]
        ]" />
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Places') }}</h2>
        @if(isset($subcategory) && $subcategory)
            <a href="{{ route('admin.subcategories.places.create', $subcategory) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition-colors duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                {{ __('Add Place') }}
            </a>
        @else
            <div class="px-4 py-3 bg-blue-100 dark:bg-blue-900/30 border-l-4 border-blue-500 text-blue-800 dark:text-blue-200 text-sm rounded">
                <strong>{{ __('Note') }}:</strong> {{ __('To add places, please navigate through: Categories → Select Category → Subcategories → Select Subcategory → Add Place') }}
            </div>
        @endif
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Sort Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 mb-4">
        <form method="GET" action="{{ route('admin.places.index') }}" class="flex gap-4 justify-end">
            <div>
                <select name="sort" onchange="this.form.submit()" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    <option value="manual" {{ request('sort', 'manual') === 'manual' ? 'selected' : '' }}>{{ __('Manual Order') }}</option>
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>{{ __('Newest First') }}</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>{{ __('Oldest First') }}</option>
                    <option value="alphabetical" {{ request('sort') === 'alphabetical' ? 'selected' : '' }}>{{ __('A-Z') }}</option>
                    <option value="alphabetical_desc" {{ request('sort') === 'alphabetical_desc' ? 'selected' : '' }}>{{ __('Z-A') }}</option>
                </select>
            </div>
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
                        <th class="px-6 py-4">{{ __('Name') }}</th>
                        <th class="px-6 py-4">{{ __('Category') }}</th>
                        <th class="px-6 py-4">{{ __('Location') }}</th>
                        <th class="px-6 py-4">{{ __('Owner') }}</th>
                        <th class="px-6 py-4">{{ __('Status') }}</th>
                        <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($places as $place)
                        <tr class="sortable-row hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors" data-id="{{ $place->id }}">
                            @if(request('sort', 'manual') === 'manual')
                                <td class="px-6 py-4 handle" style="cursor: grab;">
                                    <svg class="w-6 h-6 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 3H11V5H9V3ZM13 3H15V5H13V3ZM9 7H11V9H9V7ZM13 7H15V9H13V7ZM9 11H11V13H9V11ZM13 11H15V13H13V11ZM9 15H11V17H9V15ZM13 15H15V17H13V15ZM9 19H11V21H9V19ZM13 19H15V21H13V19Z" />
                                    </svg>
                                </td>
                            @endif
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.places.update-order', $place) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="order" value="{{ $place->order }}" min="1" onchange="this.form.submit()" class="w-16 px-2 py-1 text-center rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                </form>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                <div class="flex items-center gap-3">
                                    @if($place->image_url)
                                        @if(str_starts_with($place->image_url, 'http'))
                                            <img src="{{ $place->image_url }}" alt="{{ $place->name }}" class="w-10 h-10 rounded-lg object-cover">
                                        @else
                                            <img src="{{ asset('storage/' . $place->image_url) }}" alt="{{ $place->name }}" class="w-10 h-10 rounded-lg object-cover">
                                        @endif
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-medium">{{ $place->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $place->address }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                                        {{ $place->category->name }}
                                    </span>
                                    @if($place->subcategory)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                            {{ $place->subcategory->name }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $place->location->name }}</td>
                            <td class="px-6 py-4">
                                @if($place->owner)
                                    <div class="text-sm">
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $place->owner->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $place->owner->id }}</div>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">{{ __('No owner') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-1">
                                    @if($place->is_popular)
                                        <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">{{ __('Popular') }}</span>
                                    @endif
                                    @if($place->is_featured)
                                        <span class="px-2 py-1 rounded-full bg-purple-100 text-purple-700 text-xs font-bold">{{ __('Featured') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.places.edit', $place) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00 2 2h11a2 2 0 00 2-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.places.destroy', $place) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}');" class="inline">
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
                            <td colspan="{{ request('sort', 'manual') === 'manual' ? '9' : '8' }}" class="px-6 py-8 text-center text-gray-500">
                                {{ __('No places found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $places->appends(['sort' => request('sort', 'manual')])->links() }}
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
                        
                        fetch('{{ route('admin.places.reorder') }}', {
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