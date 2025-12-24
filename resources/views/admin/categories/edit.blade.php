<x-admin-layout>
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Categories
        </a>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Category: {{ $category->name }}</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 max-w-2xl">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Icon</label>
                    <div class="flex gap-3">
                        <input type="text" name="icon" id="icon" value="{{ old('icon', $category->icon) }}" class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" readonly>
                        <button type="button" onclick="openIconPicker()" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow-sm transition-colors duration-200">
                            Browse Icons
                        </button>
                    </div>
                    <div id="iconPreview" class="mt-2 {{ $category->icon ? '' : 'hidden' }}">
                        <img id="iconPreviewImage" src="{{ $category->icon ? '/size-512/images/' . $category->icon : '' }}" alt="Selected icon" class="w-16 h-16 object-contain border border-gray-300 rounded-lg p-2">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Click "Browse Icons" to select an icon from the library</p>
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Color (Hex or Tailwind Class)</label>
                    <div class="flex gap-4">
                        <input type="color" id="colorPicker" value="{{ old('color', $category->color) }}" class="h-10 w-10 rounded cursor-pointer border border-gray-300" onchange="document.getElementById('color').value = this.value">
                        <input type="text" name="color" id="color" value="{{ old('color', $category->color) }}" class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="#000000">
                    </div>
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition-colors duration-200">
                        Update Category
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Icon Picker Modal -->
    <div id="iconPickerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) closeIconPicker()">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-6xl w-full mx-4 max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Select an Icon</h3>
                    <button type="button" onclick="closeIconPicker()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <input type="text" id="iconSearchInput" placeholder="Search icons..." class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" onkeyup="filterIcons()">
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto flex-1">
                <div id="iconGrid" class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10 gap-4">
                    <!-- Icons will be loaded here -->
                </div>
                <div id="iconLoading" class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Loading icons...</p>
                </div>
                <div id="iconNoResults" class="hidden text-center py-8">
                    <p class="text-gray-600 dark:text-gray-400">No icons found</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let iconsData = [];
        
        // Load icons on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadIcons();
        });

        async function loadIcons() {
            try {
                const response = await fetch('/size-512/meta.json');
                const data = await response.json();
                iconsData = data.items || [];
                
                // Set initial icon preview if icon is already selected
                const iconInput = document.getElementById('icon');
                if (iconInput.value) {
                    showIconPreview(iconInput.value);
                }
            } catch (error) {
                console.error('Error loading icons:', error);
            }
        }

        function openIconPicker() {
            const modal = document.getElementById('iconPickerModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Render icons if not already rendered
            const iconGrid = document.getElementById('iconGrid');
            if (iconGrid.children.length === 0) {
                renderIcons(iconsData);
            }
        }

        function closeIconPicker() {
            const modal = document.getElementById('iconPickerModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function renderIcons(icons) {
            const iconGrid = document.getElementById('iconGrid');
            const loading = document.getElementById('iconLoading');
            const noResults = document.getElementById('iconNoResults');
            
            loading.classList.add('hidden');
            iconGrid.innerHTML = '';
            
            if (icons.length === 0) {
                noResults.classList.remove('hidden');
                return;
            }
            
            noResults.classList.add('hidden');
            
            icons.forEach(icon => {
                const iconDiv = document.createElement('div');
                iconDiv.className = 'icon-item cursor-pointer p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex flex-col items-center justify-center';
                iconDiv.setAttribute('data-icon-name', icon.file_name);
                iconDiv.setAttribute('data-icon-title', icon.title.toLowerCase());
                iconDiv.onclick = () => selectIcon(icon.file_name, icon.title);
                
                iconDiv.innerHTML = `
                    <img src="/size-512/images/${icon.file_name}" alt="${icon.title}" class="w-12 h-12 object-contain mb-1">
                    <span class="text-xs text-gray-600 dark:text-gray-400 text-center truncate w-full" title="${icon.title}">${icon.title}</span>
                `;
                
                iconGrid.appendChild(iconDiv);
            });
        }

        function filterIcons() {
            const searchInput = document.getElementById('iconSearchInput').value.toLowerCase();
            
            if (searchInput === '') {
                renderIcons(iconsData);
                return;
            }
            
            const filtered = iconsData.filter(icon => 
                icon.title.toLowerCase().includes(searchInput) ||
                icon.slug.toLowerCase().includes(searchInput) ||
                (icon.tags && icon.tags.some(tag => tag.toLowerCase().includes(searchInput)))
            );
            
            renderIcons(filtered);
        }

        function selectIcon(fileName, title) {
            const iconInput = document.getElementById('icon');
            iconInput.value = fileName;
            
            showIconPreview(fileName);
            closeIconPicker();
        }

        function showIconPreview(fileName) {
            const preview = document.getElementById('iconPreview');
            const previewImage = document.getElementById('iconPreviewImage');
            
            if (fileName) {
                previewImage.src = '/size-512/images/' + fileName;
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        }
    </script>
</x-admin-layout>