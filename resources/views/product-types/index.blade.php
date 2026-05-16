<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Product Types</h2>
        <a href="{{ route('product-types.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md">Add Type</a>
    </div>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Expiration?</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Rx Required?</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($productTypes as $pt)
                <tr>
                    <td class="px-6 py-4 font-medium">{{ $pt['name'] }}</td>
                    <td class="px-6 py-4">
                        @if($pt['requires_expiration'])
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Yes</span>
                        @else
                        No
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($pt['requires_prescription'])
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Yes</span>
                        @else
                        No
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('product-types.edit', $pt['id']) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                        <form action="{{ route('product-types.destroy', $pt['id']) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No types found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>