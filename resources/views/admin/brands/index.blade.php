<x-admin-layout>
    <x-breadcrumb :items="[
        ['label' => __('Categories'), 'url' => route('admin.categories.index')],
        ['label' => $subcategory->category->name, 'url' => route('admin.categories.edit', $subcategory->category), 'icon' => $subcategory->category->icon, 'color' => $subcategory->category->color],
        ['label' => __('Subcategories'), 'url' => route('admin.categories.subcategories.index', $subcategory->category)],
        ['label' => $subcategory->name, 'url' => route('admin.subcategories.edit', $subcategory), 'icon' => $subcategory->icon],
        ['label' => __('Brands'), 'url' => null]
    ]" />

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Brands') }}</h2>
        <a href="{{ route('admin.subcategories.brands.create', $subcategory) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition-colors duration-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            {{ __('Add Brand') }}
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

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="sortable-table" class="w-full text-left text-sm text-gray-600 dark:text-gray-400">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs uppercase font-medium text-gray-500 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-12">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 3H11V5H9V3ZM13 3H15V5H13V3ZM9 7H11V9H9V7ZM13 7H15V9H13V7ZM9 11H11V13H9V11ZM13 11H15V13H13V11ZM9 15H11V17H9V15ZM13 15H15V17H13V15ZM9 19H11V21H9V19ZM13 19H15V21H13V19Z" />
                            </svg>
                        </th>
                        <th scope="col" class="px-6 py-3 w-20">{{ __('Order') }}</th>
                        <th scope="col" class="px-6 py-3 w-24">{{ __('Icon') }}</th>
                        <th scope="col" class="px-6 py-3">{{ __('Name') }}</th>
                        <th scope="col" class="px-6 py-3">{{ __('Places') }}</th>
                        <th scope="col" class="px-6 py-3 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($brands as $brand)
                        <tr data-id="{{ $brand->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 handle cursor-move">
                                <svg class="w-6 h-6 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 3H11V5H9V3ZM13 3H15V5H13V3ZM9 7H11V9H9V7ZM13 7H15V9H13V7ZM9 11H11V13H9V11ZM13 11H15V13H13V11ZM9 15H11V17H9V15ZM13 15H15V17H13V15ZM9 19H11V21H9V19ZM13 19H15V21H13V19Z" />
                                </svg>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.brands.update-order', $brand) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="order" value="{{ $brand->order }}" min="1" onchange="this.form.submit()" class="w-16 px-2 py-1 text-center rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                @if($brand->icon)
                                    <img src="{{ asset('images/brands/' . $brand->icon) }}" alt="{{ $brand->name }}" class="w-12 h-12 object-contain rounded">
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                <div>{{ $brand->name }}</div>
                                @if($brand->name_uz || $brand->name_ru || $brand->name_en)
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        @if($brand->name_uz)<span class="mr-2">🇺🇿 {{ $brand->name_uz }}</span>@endif
                                        @if($brand->name_ru)<span class="mr-2">🇷🇺 {{ $brand->name_ru }}</span>@endif
                                        @if($brand->name_en)<span>🇬🇧 {{ $brand->name_en }}</span>@endif
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                    {{ $brand->places_count }} {{ __('places') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.brands.edit', $brand) }}" class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.brands.destroy', ['subcategory' => $subcategory, 'brand' => $brand]) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('Are you sure you want to delete this brand?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                {{ __('No brands found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($brands->count() > 0)
        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
        <script>
            const table = document.querySelector('#sortable-table tbody');
            if (table) {
                const sortable = new Sortable(table, {
                    handle: '.handle',
                    animation: 200,
                    onEnd: function(evt) {
                        const order = Array.from(table.querySelectorAll('tr')).map(row => row.dataset.id);
                        
                        fetch('{{ route('admin.brands.reorder', $subcategory) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ orders: order })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update order numbers in the table
                                table.querySelectorAll('tr').forEach((row, index) => {
                                    const input = row.querySelector('input[name="order"]');
                                    if (input) input.value = index + 1;
                                });
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
