<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">{{ isset($category) ? 'Edit' : 'Create' }} Category</h2>
        <div class="bg-white p-6 rounded-lg shadow">
            <!-- Pass the edit Product Type ID safely into a data attribute -->
            <form method="POST" action="{{ isset($category) ? route('categories.update', $category['id']) : route('categories.store') }}" data-edit-pt-id="{{ isset($category) ? ($category['product_type']['id'] ?? '') : '' }}">
                @csrf 
                @if(isset($category)) @method('PUT') @endif
                
                <!-- Product Type Dropdown -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Product Type</label>
                    <select name="product_type_id" id="pt-select" class="w-full border rounded-md px-3 py-2" required>
                        <option value="">Select Type...</option>
                        @foreach($productTypes as $pt)
                            <option value="{{ $pt['id'] }}" {{ (isset($category) && isset($category['product_type']) && $category['product_type']['id'] == $pt['id']) ? 'selected' : '' }}>
                                {{ $pt['name'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_type_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Parent Category Dropdown -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Parent Category (Optional)</label>
                    <input type="hidden" name="parent_id" value="{{ old('parent_id', $category['parent_id'] ?? '') }}" id="hidden_parent_id">
                    
                    <select id="parent-select" class="w-full border rounded-md px-3 py-2" onchange="document.getElementById('hidden_parent_id').value = this.value">
                        <option value="">None (Root Category)</option>
                        @if(!empty($categoryTree))
                            @foreach($categoryTree as $rootNode)
                                <x-category.tree-item :node="$rootNode" />
                            @endforeach
                        @endif
                    </select>
                    @error('parent_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Category Name -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Category Name</label>
                    <input type="text" name="name" value="{{ old('name', $category['name'] ?? '') }}" class="w-full border rounded-md px-3 py-2" required>
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Actions -->
                <div class="flex justify-end mt-6">
                    <a href="{{ route('categories.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md mr-3">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- PURE JAVASCRIPT BLOCK - NO BLADE SYNTAX ALLOWED HERE -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const ptSelect = document.getElementById('pt-select');
            const parentSelect = document.getElementById('parent-select');
            const hiddenParent = document.getElementById('hidden_parent_id');

            // 1. Recursive function to build <option> tags with indentation
            function renderTree(nodes, depth) {
                depth = depth || 0;
                let html = '';
                for (let i = 0; i < nodes.length; i++) {
                    let node = nodes[i];
                    html += '<option value="' + node.id + '">' + '--'.repeat(depth) + ' ' + node.name + '</option>';
                    if (node.children && node.children.length > 0) {
                        html += renderTree(node.children, depth + 1);
                    }
                }
                return html;
            }

            // 2. Function to call our Laravel Proxy route
            function fetchTree(ptId) {
                if (!ptId) {
                    parentSelect.innerHTML = '<option value="">None (Root Category)</option>';
                    hiddenParent.value = '';
                    return;
                }

                axios.get('/categories/tree?product_type=' + ptId)
                    .then(function(response) {
                        parentSelect.innerHTML = '<option value="">None (Root Category)</option>' + renderTree(response.data);
                        hiddenParent.value = '';
                    })
                    .catch(function(error) {
                        console.error("Proxy fetch failed:", error);
                    });
            }

            // 3. Listen for dropdown change
            ptSelect.addEventListener('change', function() {
                fetchTree(this.value);
            });

            // 4. If editing, trigger fetch automatically using the data attribute
            let editPtId = form.getAttribute('data-edit-pt-id');
            if (editPtId) {
                fetchTree(editPtId);
            }
        });
    </script>
</x-app-layout>