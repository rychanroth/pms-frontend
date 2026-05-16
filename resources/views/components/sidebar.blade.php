<div class="p-4 flex flex-col h-full">
    <!-- Logo / Brand -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-blue-600">Aeterna</h2>
        <p class="text-xs text-gray-500">Pharmacy Management</p>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 space-y-1">
        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">Dashboard</a>
        
        <!-- ADMIN & PHARMACIST MENUS -->
        @if(in_array(session('user_role'), ['admin', 'pharmacist']))
            <p class="px-3 pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase">Inventory</p>
            <a href="{{ route('product-types.index') }}" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">Product Types</a>
            <a href="{{ route('categories.index') }}" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">Categories</a>
            <a href="#" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">Products</a>
            <a href="{{ route('suppliers.index') }}" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">Suppliers</a>
            <a href="#" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">Stock Movements</a>
        @endif

        <!-- CLINICAL MENUS -->
        @if(in_array(session('user_role'), ['admin', 'pharmacist']))
            <p class="px-3 pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase">Clinical</p>
            <a href="#" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">Doctors</a>
            <a href="#" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">Patients</a>
            <a href="#" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">Prescriptions</a>
        @endif

        <!-- CASHIER MENUS -->
        @if(session('user_role') === 'cashier')
            <p class="px-3 pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase">Point of Sale</p>
            <a href="#" class="block px-3 py-2 rounded-md text-sm hover:bg-gray-100 bg-blue-50 text-blue-700 font-medium">New Sale (POS)</a>
            <a href="#" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">Sales History</a>
        @endif

        <!-- ADMIN ONLY -->
        @if(session('user_role') === 'admin')
            <p class="px-3 pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase">System</p>
            <a href="#" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">Users</a>
            <a href="#" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100">Reports</a>
        @endif
    </nav>
</div>