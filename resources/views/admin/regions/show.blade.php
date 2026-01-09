<x-admin-layout>
    <div class="mb-6">
        <a href="{{ route('admin.regions.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Regions
        </a>
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $region->name }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.regions.edit', $region) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition-colors duration-200">
                    Edit Region
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Region Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Internal Name</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $region->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Uzbek Name</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $region->name_uz }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Russian Name</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $region->name_ru }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">English Name</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $region->name_en }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $region->slug }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Display Order</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $region->order }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                    <dd class="mt-1">
                        @if($region->is_active)
                            <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 rounded-full text-xs font-medium">Active</span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-400 rounded-full text-xs font-medium">Inactive</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Statistics</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Locations</dt>
                    <dd class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">{{ $region->locations->count() }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Places</dt>
                    <dd class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">{{ $region->places->count() }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $region->created_at->format('M d, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $region->updated_at->format('M d, Y') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    @if($region->locations->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Locations in this Region</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Places Count</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Slug</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($region->locations as $location)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $location->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $location->places->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $location->slug }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</x-admin-layout>
