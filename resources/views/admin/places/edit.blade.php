<x-admin-layout>
    <div class="mb-6">
        <a href="{{ route('admin.places.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            {{ __('Back to Places') }}
        </a>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Edit Place') }}: {{ $place->name }}</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 max-w-4xl">
        <form action="{{ route('admin.places.update', $place) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Name') }}</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $place->name) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Category') }}</label>
                        <select name="category_id" id="category_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required onchange="loadSubcategories(this.value)">
                            <option value="">{{ __('Select Category') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $place->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="subcategory-container" style="display: none;">
                        <label for="subcategory_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Subcategory (Optional)') }}</label>
                        <select name="subcategory_id" id="subcategory_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" onchange="loadBrands(this.value)">
                            <option value="">{{ __('Select Subcategory') }}</option>
                        </select>
                        @error('subcategory_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="brand-container" style="display: none;">
                        <label for="brand_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Brand (Optional)') }}</label>
                        <select name="brand_id" id="brand_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <option value="">{{ __('No Brand') }}</option>
                        </select>
                        @error('brand_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Location') }}</label>
                        <select name="location_id" id="location_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                            <option value="">{{ __('Select Location') }}</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ old('location_id', $place->location_id) == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                            @endforeach
                        </select>
                        @error('location_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data="{
                        open: false,
                        search: '',
                        selected: {{ old('owner_id', $place->owner_id) ?: 'null' }},
                        users: {{ json_encode($users->map(fn($u) => ['id' => $u->id, 'name' => $u->name, 'phone' => $u->phone ?? ''])) }},
                        get filteredUsers() {
                            if (this.search === '') return this.users;
                            const searchLower = this.search.toLowerCase().replace(/[^0-9+]/g, '');
                            return this.users.filter(user => {
                                const name = (user.name || '').toLowerCase();
                                const phone = (user.phone || '').replace(/[^0-9+]/g, '');
                                const id = user.id.toString();
                                return name.includes(this.search.toLowerCase()) ||
                                       phone.includes(searchLower) ||
                                       id.includes(this.search);
                            });
                        },
                        get selectedUser() {
                            return this.users.find(u => u.id === this.selected);
                        },
                        selectUser(user) {
                            this.selected = user ? user.id : null;
                            this.open = false;
                            this.search = '';
                        }
                    }" class="relative">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Place Owner (Optional)') }}</label>
                        
                        <input type="hidden" name="owner_id" :value="selected">
                        
                        <button type="button" @click="open = !open" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-white px-4 py-2 text-left shadow-sm focus:border-indigo-500 focus:ring-indigo-500 flex items-center justify-between">
                            <span x-text="selectedUser ? `ID: ${selectedUser.id} - ${selectedUser.name} (${selectedUser.phone})` : 'No Owner'" class="truncate"></span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-transition class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg">
                            <div class="p-2 border-b border-gray-200 dark:border-gray-700">
                                <input 
                                    type="text" 
                                    x-model="search" 
                                    placeholder="{{ __('Search by ID, name, or phone...') }}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm"
                                >
                            </div>
                            <div class="max-h-60 overflow-y-auto">
                                <button type="button" @click="selectUser(null)" class="w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">
                                    <span class="font-medium">{{ __('No Owner') }}</span>
                                </button>
                                <template x-for="user in filteredUsers" :key="user.id">
                                    <button type="button" @click="selectUser(user)" class="w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 dark:text-white text-sm flex items-center justify-between" :class="{ 'bg-indigo-50 dark:bg-indigo-900/20': selected === user.id }">
                                        <div>
                                            <div class="font-medium" x-text="`ID: ${user.id} - ${user.name}`"></div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400" x-text="user.phone"></div>
                                        </div>
                                        <svg x-show="selected === user.id" class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </template>
                                <div x-show="filteredUsers.length === 0" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400 text-sm">
                                    No users found
                                </div>
                            </div>
                        </div>
                        
                        @error('owner_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Assign a user as the owner of this place to grant them access to statistics and reply to comments.</p>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Address') }}</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $place->address) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">{{ old('description', $place->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Place Image</label>
                        @if($place->image_url)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $place->image_url) }}" alt="{{ $place->name }}" class="w-32 h-32 object-cover rounded-lg border border-gray-300 dark:border-gray-600">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Current image</p>
                            </div>
                        @endif
                        <input type="file" name="image" id="image" accept="image/jpeg,image/jpg,image/png,image/webp" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400" onchange="previewImage(event)">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG, JPEG, PNG, WEBP (Max 5MB) - Leave empty to keep current image</p>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div id="imagePreview" class="mt-3 hidden">
                            <img id="preview" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border border-gray-300 dark:border-gray-600">
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Phone') }}</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $place->phone) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Website') }}</label>
                        <input type="url" name="website" id="website" value="{{ old('website', $place->website) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        @error('website')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="navigate_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Navigation Link</label>
                        <input type="url" name="navigate_link" id="navigate_link" value="{{ old('navigate_link', $place->navigate_link) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="e.g., https://yandex.uz/maps/-/...">
                        @error('navigate_link')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Working Hours -->
                    @php
                        $hours = old('working_hours') ?: ($place->working_hours ?: [
                            'monday' => ['enabled' => false, 'open' => '09:00', 'close' => '18:00'],
                            'tuesday' => ['enabled' => false, 'open' => '09:00', 'close' => '18:00'],
                            'wednesday' => ['enabled' => false, 'open' => '09:00', 'close' => '18:00'],
                            'thursday' => ['enabled' => false, 'open' => '09:00', 'close' => '18:00'],
                            'friday' => ['enabled' => false, 'open' => '09:00', 'close' => '18:00'],
                            'saturday' => ['enabled' => false, 'open' => '09:00', 'close' => '18:00'],
                            'sunday' => ['enabled' => false, 'open' => '09:00', 'close' => '18:00']
                        ]);
                    @endphp
                    <div class="col-span-2" x-data="workingHoursEdit({{ json_encode($hours) }})">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Working Hours</h3>
                        
                        <!-- {{ __('Apply to All') }} Days -->
                        <div class="mb-4 p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border-2 border-indigo-200 dark:border-indigo-800">
                            <h4 class="text-sm font-semibold text-indigo-900 dark:text-indigo-300 mb-3">{{ __('Quick Set - Apply to All Days') }}</h4>
                            <div class="flex items-center gap-3">
                                <input type="time" x-model="bulkTime.open" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                <span class="text-gray-500 dark:text-gray-400">to</span>
                                <input type="time" x-model="bulkTime.close" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                <button type="button" @click="applyToAll()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    {{ __('Apply to All') }}
                                </button>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="flex items-center w-32">
                                    <input type="checkbox" id="day_monday" x-model="monday.enabled" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="day_monday" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Monday</label>
                                </div>
                                <div class="flex items-center gap-2 flex-1" x-show="monday.enabled">
                                    <input type="time" x-model="monday.open" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                    <span class="text-gray-500 dark:text-gray-400">to</span>
                                    <input type="time" x-model="monday.close" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="flex items-center w-32">
                                    <input type="checkbox" id="day_tuesday" x-model="tuesday.enabled" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="day_tuesday" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Tuesday</label>
                                </div>
                                <div class="flex items-center gap-2 flex-1" x-show="tuesday.enabled">
                                    <input type="time" x-model="tuesday.open" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                    <span class="text-gray-500 dark:text-gray-400">to</span>
                                    <input type="time" x-model="tuesday.close" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="flex items-center w-32">
                                    <input type="checkbox" id="day_wednesday" x-model="wednesday.enabled" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="day_wednesday" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Wednesday</label>
                                </div>
                                <div class="flex items-center gap-2 flex-1" x-show="wednesday.enabled">
                                    <input type="time" x-model="wednesday.open" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                    <span class="text-gray-500 dark:text-gray-400">to</span>
                                    <input type="time" x-model="wednesday.close" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="flex items-center w-32">
                                    <input type="checkbox" id="day_thursday" x-model="thursday.enabled" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="day_thursday" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Thursday</label>
                                </div>
                                <div class="flex items-center gap-2 flex-1" x-show="thursday.enabled">
                                    <input type="time" x-model="thursday.open" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                    <span class="text-gray-500 dark:text-gray-400">to</span>
                                    <input type="time" x-model="thursday.close" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="flex items-center w-32">
                                    <input type="checkbox" id="day_friday" x-model="friday.enabled" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="day_friday" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Friday</label>
                                </div>
                                <div class="flex items-center gap-2 flex-1" x-show="friday.enabled">
                                    <input type="time" x-model="friday.open" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                    <span class="text-gray-500 dark:text-gray-400">to</span>
                                    <input type="time" x-model="friday.close" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="flex items-center w-32">
                                    <input type="checkbox" id="day_saturday" x-model="saturday.enabled" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="day_saturday" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Saturday</label>
                                </div>
                                <div class="flex items-center gap-2 flex-1" x-show="saturday.enabled">
                                    <input type="time" x-model="saturday.open" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                    <span class="text-gray-500 dark:text-gray-400">to</span>
                                    <input type="time" x-model="saturday.close" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="flex items-center w-32">
                                    <input type="checkbox" id="day_sunday" x-model="sunday.enabled" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="day_sunday" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Sunday</label>
                                </div>
                                <div class="flex items-center gap-2 flex-1" x-show="sunday.enabled">
                                    <input type="time" x-model="sunday.open" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                    <span class="text-gray-500 dark:text-gray-400">to</span>
                                    <input type="time" x-model="sunday.close" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="working_hours" :value="getHoursJson()">
                        @error('working_hours')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <script>
                        function workingHoursEdit(data) {
                            return {
                                bulkTime: { open: '09:00', close: '18:00' },
                                monday: data.monday || { enabled: false, open: '09:00', close: '18:00' },
                                tuesday: data.tuesday || { enabled: false, open: '09:00', close: '18:00' },
                                wednesday: data.wednesday || { enabled: false, open: '09:00', close: '18:00' },
                                thursday: data.thursday || { enabled: false, open: '09:00', close: '18:00' },
                                friday: data.friday || { enabled: false, open: '09:00', close: '18:00' },
                                saturday: data.saturday || { enabled: false, open: '09:00', close: '18:00' },
                                sunday: data.sunday || { enabled: false, open: '09:00', close: '18:00' },
                                applyToAll() {
                                    const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                                    days.forEach(day => {
                                        this[day].enabled = true;
                                        this[day].open = this.bulkTime.open;
                                        this[day].close = this.bulkTime.close;
                                    });
                                },
                                getHoursJson() {
                                    return JSON.stringify({
                                        monday: this.monday,
                                        tuesday: this.tuesday,
                                        wednesday: this.wednesday,
                                        thursday: this.thursday,
                                        friday: this.friday,
                                        saturday: this.saturday,
                                        sunday: this.sunday
                                    });
                                }
                            }
                        }
                    </script>

                    <!-- Social Media Links -->
                    <div class="col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Social Media Links</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="instagram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                    Instagram
                                </label>
                                <input type="url" name="instagram" id="instagram" value="{{ old('instagram', $place->instagram) }}" placeholder="https://instagram.com/username" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>
                            <div>
                                <label for="telegram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                                    Telegram
                                </label>
                                <input type="url" name="telegram" id="telegram" value="{{ old('telegram', $place->telegram) }}" placeholder="https://t.me/username" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>
                            <div>
                                <label for="facebook" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    Facebook
                                </label>
                                <input type="url" name="facebook" id="facebook" value="{{ old('facebook', $place->facebook) }}" placeholder="https://facebook.com/page" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>
                            <div>
                                <label for="youtube" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                    YouTube
                                </label>
                                <input type="url" name="youtube" id="youtube" value="{{ old('youtube', $place->youtube) }}" placeholder="https://youtube.com/channel" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Multiple Images Upload -->
                    <div class="col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">{{ __('Gallery Media (Images Gallery Media (Images & Videos) Videos)') }}</h3>
                        
                        <!-- Existing Media -->
                        @if($place->images->count() > 0)
                            <div class="mb-3">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                    {{ __('Drag to reorder media') }}
                                </p>
                            </div>
                            <div id="sortable-gallery" class="grid grid-cols-4 gap-4 mb-4">
                                @foreach($place->images->sortBy('order') as $image)
                                    <div class="relative group cursor-move" data-id="{{ $image->id }}">
                                        @if($image->isVideo())
                                            <!-- Video Thumbnail -->
                                            <div class="relative w-full h-32 bg-gray-900 rounded-lg flex items-center justify-center">
                                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                                <span class="absolute bottom-2 right-2 px-2 py-0.5 bg-black/70 text-white text-xs rounded">VIDEO</span>
                                                <!-- Drag Handle -->
                                                <div class="absolute top-2 left-2 p-1 bg-black/50 text-white rounded cursor-move">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M9 3h2v2H9V3zm0 4h2v2H9V7zm0 4h2v2H9v-2zm0 4h2v2H9v-2zm0 4h2v2H9v-2zm4-16h2v2h-2V3zm0 4h2v2h-2V7zm0 4h2v2h-2v-2zm0 4h2v2h-2v-2zm0 4h2v2h-2v-2z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Image -->
                                            <div class="relative">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery image" class="w-full h-32 object-cover rounded-lg">
                                                <!-- Drag Handle -->
                                                <div class="absolute top-2 left-2 p-1 bg-black/50 text-white rounded cursor-move">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M9 3h2v2H9V3zm0 4h2v2H9V7zm0 4h2v2H9v-2zm0 4h2v2H9v-2zm0 4h2v2H9v-2zm4-16h2v2h-2V3zm0 4h2v2h-2V7zm0 4h2v2h-2v-2zm0 4h2v2h-2v-2zm0 4h2v2h-2v-2z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        @endif
                                        <button type="button" onclick="deleteImage({{ $image->id }})" class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- New Images Upload -->
                        <div class="mb-4">
                            <label for="images" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Add More Images') }}</label>
                            <input type="file" name="images[]" id="images" accept="image/*" multiple onchange="previewMultipleImages(event)" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <p class="mt-1 text-xs text-gray-500">{{ __('You can select multiple images (Max 5MB each)') }}</p>
                        </div>
                        
                        <!-- New Videos Upload -->
                        <div>
                            <label for="videos" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Add Videos') }}</label>
                            <input type="file" name="videos[]" id="videos" accept="video/*" multiple onchange="previewMultipleVideos(event)" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <p class="mt-1 text-xs text-gray-500">{{ __('You can select multiple videos (Max 50MB each, MP4, MOV, AVI, WMV)') }}</p>
                        </div>
                        
                        <!-- Preview Multiple Images -->
                        <div id="multipleImagePreview" class="grid grid-cols-4 gap-4 mt-4 hidden"></div>
                        
                        <!-- Preview Multiple Videos -->
                        <div id="multipleVideoPreview" class="grid grid-cols-4 gap-4 mt-4 hidden"></div>
                    </div>

                    <!-- Location Picker -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Coordinates (Latitude, Longitude)') }}</label>
                        <div class="flex gap-2">
                            <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $place->latitude) }}" placeholder="{{ __('Latitude') }}" class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" readonly>
                            <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $place->longitude) }}" placeholder="{{ __('Longitude') }}" class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" readonly>
                            <button type="button" onclick="openMapPicker()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition-colors duration-200 flex items-center gap-2 whitespace-nowrap">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ __('Pick Location') }}
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Click "{{ __('Pick Location') }}" to select coordinates on the map</p>
                    </div>

                    <div class="flex gap-6 pt-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_popular" value="1" {{ old('is_popular', $place->is_popular) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Popular Place</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $place->is_featured) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Featured Place</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="pt-6 flex justify-end border-t border-gray-100 dark:border-gray-700 mt-6">
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition-colors duration-200">
                    Update Place
                </button>
            </div>
        </form>
    </div>

    <script>
        // Image preview function
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('imagePreview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        // Store subcategories data
        const categoriesData = @json($categories->map(function($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'subcategories' => $cat->subcategories
            ];
        }));

        function loadSubcategories(categoryId) {
            const subcategoryContainer = document.getElementById('subcategory-container');
            const subcategorySelect = document.getElementById('subcategory_id');
            const brandContainer = document.getElementById('brand-container');
            
            // Clear existing options
            subcategorySelect.innerHTML = '<option value="">{{ __('Select Subcategory') }}</option>';
            
            // Hide and clear brands
            brandContainer.style.display = 'none';
            document.getElementById('brand_id').innerHTML = '<option value="">{{ __('No Brand') }}</option>';
            
            if (!categoryId) {
                subcategoryContainer.style.display = 'none';
                return;
            }
            
            // Find the selected category
            const category = categoriesData.find(cat => cat.id == categoryId);
            
            if (category && category.subcategories && category.subcategories.length > 0) {
                // Add subcategory options
                category.subcategories.forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.id;
                    option.textContent = sub.name;
                    subcategorySelect.appendChild(option);
                });
                
                subcategoryContainer.style.display = 'block';
            } else {
                subcategoryContainer.style.display = 'none';
            }
        }

        function loadBrands(subcategoryId) {
            const brandContainer = document.getElementById('brand-container');
            const brandSelect = document.getElementById('brand_id');
            
            // Clear existing options
            brandSelect.innerHTML = '<option value="">{{ __('No Brand') }}</option>';
            
            if (!subcategoryId) {
                brandContainer.style.display = 'none';
                return;
            }
            
            // Fetch brands via API
            fetch(`/admin/api/subcategories/${subcategoryId}/brands`)
                .then(response => response.json())
                .then(brands => {
                    if (brands && brands.length > 0) {
                        brands.forEach(brand => {
                            const option = document.createElement('option');
                            option.value = brand.id;
                            option.textContent = brand.name;
                            brandSelect.appendChild(option);
                        });
                        brandContainer.style.display = 'block';
                    } else {
                        brandContainer.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error loading brands:', error);
                    brandContainer.style.display = 'none';
                });
        }

        // Load subcategories on page load if category is already selected
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category_id');
            const currentSubcategoryId = '{{ old("subcategory_id", $place->subcategory_id) }}';
            const currentBrandId = '{{ old("brand_id", $place->brand_id) }}';
            
            if (categorySelect.value) {
                loadSubcategories(categorySelect.value);
                
                // Set the current subcategory value if it exists
                if (currentSubcategoryId) {
                    setTimeout(() => {
                        document.getElementById('subcategory_id').value = currentSubcategoryId;
                        loadBrands(currentSubcategoryId);
                        
                        // Set the current brand value if it exists
                        if (currentBrandId) {
                            setTimeout(() => {
                                document.getElementById('brand_id').value = currentBrandId;
                            }, 200);
                        }
                    }, 100);
                }
            }
        });

        // Preview multiple images
        function previewMultipleImages(event) {
            const preview = document.getElementById('multipleImagePreview');
            preview.innerHTML = '';
            preview.classList.remove('hidden');
            
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-32 object-cover rounded-lg">`;
                    preview.appendChild(div);
                }
                
                reader.readAsDataURL(file);
            }
        }

        // Preview multiple videos
        function previewMultipleVideos(event) {
            const preview = document.getElementById('multipleVideoPreview');
            preview.innerHTML = '';
            preview.classList.remove('hidden');
            
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const div = document.createElement('div');
                div.className = 'relative bg-gray-900 rounded-lg h-32 flex items-center justify-center';
                div.innerHTML = `
                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                    <span class="absolute bottom-2 right-2 px-2 py-0.5 bg-black/70 text-white text-xs rounded">${file.name}</span>
                `;
                preview.appendChild(div);
            }
        }

        // Delete image
        function deleteImage(imageId) {
            if (!confirm('Are you sure you want to delete this image?')) {
                return;
            }

            fetch(`/admin/place-images/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error deleting image');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting image');
            });
        }

        // Map Picker Modal
        function openMapPicker() {
            document.getElementById('mapPickerModal').classList.remove('hidden');
            if (!window.mapInitialized) {
                initializeMap();
            }
        }

        function closeMapPicker() {
            document.getElementById('mapPickerModal').classList.add('hidden');
        }

        function initializeMap() {
            const lat = parseFloat(document.getElementById('latitude').value) || 41.2995;
            const lng = parseFloat(document.getElementById('longitude').value) || 69.2401;

            ymaps.ready(function() {
                const map = new ymaps.Map('yandex-map', {
                    center: [lat, lng],
                    zoom: 13,
                    controls: ['zoomControl', 'searchControl', 'typeSelector', 'fullscreenControl']
                });

                let placemark = new ymaps.Placemark([lat, lng], {
                    balloonContent: 'Selected Location'
                }, {
                    preset: 'islands#redDotIcon',
                    draggable: true
                });

                map.geoObjects.add(placemark);

                // Update coordinates when placemark is dragged
                placemark.events.add('dragend', function() {
                    const coords = placemark.geometry.getCoordinates();
                    updateCoordinates(coords[0], coords[1]);
                });

                // Update coordinates when map is clicked
                map.events.add('click', function(e) {
                    const coords = e.get('coords');
                    placemark.geometry.setCoordinates(coords);
                    updateCoordinates(coords[0], coords[1]);
                });

                // Search control event
                const searchControl = map.controls.get('searchControl');
                searchControl.events.add('resultselect', function(e) {
                    const index = e.get('index');
                    searchControl.getResult(index).then(function(res) {
                        const coords = res.geometry.getCoordinates();
                        placemark.geometry.setCoordinates(coords);
                        updateCoordinates(coords[0], coords[1]);
                    });
                });

                window.mapInitialized = true;
                window.yandexMap = map;
                window.yandexPlacemark = placemark;
            });
        }

        function updateCoordinates(lat, lng) {
            document.getElementById('modal-latitude').textContent = lat.toFixed(6);
            document.getElementById('modal-longitude').textContent = lng.toFixed(6);
        }

        function confirmLocation() {
            const lat = document.getElementById('modal-latitude').textContent;
            const lng = document.getElementById('modal-longitude').textContent;
            
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            
            closeMapPicker();
        }
    </script>

    <!-- Map Picker Modal -->
    <div id="mapPickerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Pick Location') }} on Map</h3>
                <button type="button" onclick="closeMapPicker()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="p-6">
                <div id="yandex-map" style="width: 100%; height: 500px;" class="rounded-lg mb-4"></div>
                
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Selected Coordinates') }}:</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                <span id="modal-latitude">{{ old('latitude', $place->latitude ?? '41.2995') }}</span>, 
                                <span id="modal-longitude">{{ old('longitude', $place->longitude ?? '69.2401') }}</span>
                            </p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Click on the map or drag the marker to select a location. You can also use the search box to find an address.
                    </p>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeMapPicker()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="button" onclick="confirmLocation()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-200">
                        {{ __('Confirm Location') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Yandex Maps API -->
    <script src="https://api-maps.yandex.ru/2.1/?apikey=YOUR_API_KEY&lang=en_US" type="text/javascript"></script>
    
    <!-- SortableJS for drag and drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        // Initialize SortableJS for gallery reordering
        document.addEventListener('DOMContentLoaded', function() {
            const sortableGallery = document.getElementById('sortable-gallery');
            if (sortableGallery) {
                new Sortable(sortableGallery, {
                    animation: 150,
                    ghostClass: 'opacity-50',
                    handle: '.cursor-move',
                    onEnd: function(evt) {
                        // Get the new order of image IDs
                        const items = sortableGallery.querySelectorAll('[data-id]');
                        const order = Array.from(items).map((item, index) => ({
                            id: item.dataset.id,
                            order: index + 1
                        }));
                        
                        // Send AJAX request to update order
                        fetch('{{ route("admin.places.reorder-images", $place) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ order: order })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Order updated successfully');
                            }
                        })
                        .catch(error => {
                            console.error('Error updating order:', error);
                        });
                    }
                });
            }
        });
    </script>
</x-admin-layout>