<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Categories</h2>
        <a href="{{ route('categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md">Add Category</a>
    </div>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Product Type</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Parent</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($categories as $cat)
                    <tr>
                        <td class="px-6 py-4 font-medium">{{ $cat['name'] }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $cat['product_type']['name'] ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $cat['parent']['name'] ?? 'Root' }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('categories.edit', $cat['id']) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                            <form action="{{ route('categories.destroy', $cat['id']) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No categories found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>