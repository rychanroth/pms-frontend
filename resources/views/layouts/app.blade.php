<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex flex-col md:flex-row">

        <!-- LEFT: Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0">
            <x-sidebar />
        </aside>

        <!-- RIGHT: Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Top Header Bar -->
            @isset($header)
            <header class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-800">Aeterna Health</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">{{ session('user_role') ?? 'Guest' }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:underline">Logout</button>
                    </form>
                </div>
            </header>
            @endisset

            <!-- Scrollable Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>

        </div>
    </div>
</body>

</html>