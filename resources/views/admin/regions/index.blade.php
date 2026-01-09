<x-admin-layout>
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Regions Management</h2>
            <a href="{{ route('admin.regions.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition-colors duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Region
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-400 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-400 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Uzbek</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Russian</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">English</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Locations</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($regions as $region)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-semibold">
                                {{ $region->order }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $region->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $region->slug }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $region->name_uz }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $region->name_ru }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $region->name_en }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 rounded-full text-xs font-medium">
                                    {{ $region->locations->count() }} locations
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($region->is_active)
                                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 rounded-full text-xs font-medium">Active</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-400 rounded-full text-xs font-medium">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.regions.show', $region) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.regions.edit', $region) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.regions.destroy', $region) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this region?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                </svg>
                                <p class="text-lg font-medium">No regions found</p>
                                <p class="mt-1">Get started by creating a new region.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($regions->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $regions->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
