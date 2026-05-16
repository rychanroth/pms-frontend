<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">{{ isset($productType) ? 'Edit' : 'Create' }} Product Type</h2>
        <div class="bg-white p-6 rounded-lg shadow">
            <form method="POST" action="{{ isset($productType) ? route('product-types.update', $productType['id']) : route('product-types.store') }}">
                @csrf @if(isset($productType)) @method('PUT') @endif
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name', $productType['name'] ?? '') }}" class="w-full border rounded-md px-3 py-2">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" class="w-full border rounded-md px-3 py-2">{{ old('description', $productType['description'] ?? '') }}</textarea>
                </div>
                <div class="mb-4 flex space-x-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="requires_expiration" value="true" {{ (old('requires_expiration', $productType['requires_expiration'] ?? false)) ? 'checked' : '' }} class="rounded text-blue-600 mr-2">
                        <span class="text-sm">Requires Expiration</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="requires_prescription" value="true" {{ (old('requires_prescription', $productType['requires_prescription'] ?? false)) ? 'checked' : '' }} class="rounded text-blue-600 mr-2">
                        <span class="text-sm">Requires Prescription</span>
                    </label>
                </div>
                <div class="flex justify-end mt-6">
                    <a href="{{ route('product-types.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md mr-3">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Save</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>