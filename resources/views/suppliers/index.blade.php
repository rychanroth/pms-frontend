<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Suppliers</h2>
        <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-md">Add Supplier</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Phone</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Address</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($suppliers as $supplier)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $supplier['id'] }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $supplier['name'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $supplier['phone'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $supplier['address'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No suppliers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>