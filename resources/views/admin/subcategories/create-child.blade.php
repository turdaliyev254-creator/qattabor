<x-admin-layout>
    <div class="mb-6">
        <a href="{{ route('admin.subcategories.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Subcategories
        </a>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create Child Subcategory</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Add a new child subcategory under an existing parent subcategory</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 max-w-2xl">
        <form action="{{ route('admin.subcategories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <!-- Parent Category Selection -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Parent Category <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                        <option value="">Select a category first</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parent Subcategory Selection (Required) -->
                <div id="parent-subcategory-wrapper">
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Parent Subcategory <span class="text-red-500">*</span>
                    </label>
                    <select name="parent_id" id="parent_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required disabled>
                        <option value="">Select a parent category first</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">This child subcategory will be nested under the selected parent</p>
                    @error('parent_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name in Uzbek -->
                <div>
                    <label for="name_uz" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Name (Uzbek) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name_uz" id="name_uz" value="{{ old('name_uz') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required placeholder="O'zbek tilida nom">
                    @error('name_uz')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name in Russian -->
                <div>
                    <label for="name_ru" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Name (Russian) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name_ru" id="name_ru" value="{{ old('name_ru') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required placeholder="Название на русском">
                    @error('name_ru')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name in English -->
                <div>
                    <label for="name_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Name (English) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name_en" id="name_en" value="{{ old('name_en') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required placeholder="Name in English">
                    @error('name_en')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon Upload -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Icon</label>
                    <div class="flex gap-3">
                        <input type="text" name="icon" id="icon" value="{{ old('icon') }}" class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" readonly>
                        <button type="button" onclick="openIconPicker()" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow-sm transition-colors duration-200">
                            Browse Icons
                        </button>
                    </div>
                    <div id="iconPreview" class="mt-2 hidden">
                        <img id="iconPreviewImage" src="" alt="Selected icon" class="w-16 h-16 object-contain border border-gray-300 rounded-lg p-2">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Click "Browse Icons" to select an icon from the library</p>
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4 flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg shadow-sm transition-colors duration-200">
                        Create Child Subcategory
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Icon Picker Modal -->
    <div id="iconPickerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) closeIconPicker()">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-6xl w-full mx-4 max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4 flex items-center justify-between">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Select Icon</h3>
                <button type="button" onclick="closeIconPicker()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Icon Grid -->
            <div class="flex-1 overflow-y-auto p-6">
                <div id="iconGrid" class="grid grid-cols-6 sm:grid-cols-8 md:grid-cols-10 lg:grid-cols-12 gap-3">
                    <!-- Icons will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Load parent subcategories when category is selected
        document.getElementById('category_id').addEventListener('change', function() {
            const categoryId = this.value;
            const parentSelect = document.getElementById('parent_id');
            
            // Clear and disable parent select
            parentSelect.innerHTML = '<option value="">Loading...</option>';
            parentSelect.disabled = true;
            
            if (!categoryId) {
                parentSelect.innerHTML = '<option value="">Select a parent category first</option>';
                return;
            }
            
            // Fetch parent subcategories for this category
            fetch(`/admin/subcategories/get-parents?category_id=${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    parentSelect.innerHTML = '<option value="">Select a parent subcategory</option>';
                    
                    if (data.length === 0) {
                        parentSelect.innerHTML = '<option value="">No parent subcategories available in this category</option>';
                        parentSelect.disabled = true;
                    } else {
                        data.forEach(subcategory => {
                            const option = document.createElement('option');
                            option.value = subcategory.id;
                            option.textContent = (subcategory.icon ? subcategory.icon + ' ' : '') + subcategory.name;
                            if ({{ old('parent_id', 'null') }} == subcategory.id) {
                                option.selected = true;
                            }
                            parentSelect.appendChild(option);
                        });
                        parentSelect.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error loading parent subcategories:', error);
                    parentSelect.innerHTML = '<option value="">Error loading parent subcategories</option>';
                    parentSelect.disabled = true;
                });
        });

        // Trigger change event if category is pre-selected
        if (document.getElementById('category_id').value) {
            document.getElementById('category_id').dispatchEvent(new Event('change'));
        }

        // Icon picker functions
        let iconData = [];

        function openIconPicker() {
            document.getElementById('iconPickerModal').classList.remove('hidden');
            document.getElementById('iconPickerModal').classList.add('flex');
            
            if (iconData.length === 0) {
                loadIcons();
            }
        }

        function closeIconPicker() {
            document.getElementById('iconPickerModal').classList.add('hidden');
            document.getElementById('iconPickerModal').classList.remove('flex');
        }

        function loadIcons() {
            const iconGrid = document.getElementById('iconGrid');
            iconGrid.innerHTML = '<div class="col-span-full text-center py-4 text-gray-500">Loading icons...</div>';
            
            fetch('/size-512/meta.json')
                .then(response => response.json())
                .then(data => {
                    iconData = data.icons || [];
                    renderIcons();
                })
                .catch(error => {
                    console.error('Error loading icons:', error);
                    iconGrid.innerHTML = '<div class="col-span-full text-center py-4 text-red-500">Error loading icons</div>';
                });
        }

        function renderIcons() {
            const iconGrid = document.getElementById('iconGrid');
            iconGrid.innerHTML = '';
            
            iconData.forEach(icon => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'aspect-square p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex items-center justify-center';
                button.onclick = () => selectIcon(icon.file_name);
                
                const img = document.createElement('img');
                img.src = '/size-512/images/' + icon.file_name;
                img.alt = icon.title;
                img.className = 'w-full h-full object-contain';
                
                button.appendChild(img);
                iconGrid.appendChild(button);
            });
        }

        function selectIcon(fileName) {
            document.getElementById('icon').value = fileName;
            
            const preview = document.getElementById('iconPreview');
            const previewImage = document.getElementById('iconPreviewImage');
            previewImage.src = '/size-512/images/' + fileName;
            preview.classList.remove('hidden');
            
            closeIconPicker();
        }

        // Show icon preview if icon is pre-filled
        if (document.getElementById('icon').value) {
            const preview = document.getElementById('iconPreview');
            const previewImage = document.getElementById('iconPreviewImage');
            previewImage.src = document.getElementById('icon').value;
            preview.classList.remove('hidden');
        }
    </script>
</x-admin-layout>
