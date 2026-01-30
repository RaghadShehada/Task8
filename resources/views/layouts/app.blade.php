<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

   
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">

       
        <nav class="bg-gray-800 text-white">
            <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
                <div class="flex space-x-4">
                    <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                    <a href="{{ route('products.index') }}" class="hover:underline">Products</a>
                    <a href="{{ route('categories.index') }}" class="hover:underline">Categories</a>
                    <a href="{{ route('suppliers.index') }}" class="hover:underline">Suppliers</a>
                </div>
                <div class="flex items-center space-x-4">
                    <span>{{ auth()->user()->name ?? auth()->user()->email }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-600 px-3 py-1 rounded hover:bg-red-700">Logout</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto px-4 py-3">
            @if(session('success'))
                <div class="bg-green-200 text-green-800 px-4 py-2 rounded mb-2">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-200 text-red-800 px-4 py-2 rounded mb-2">{{ session('error') }}</div>
            @endif
        </div>

        
        <main class="max-w-7xl mx-auto px-4 py-6">
            {{ $slot }}
        </main>
    </div>
</body>
</html>

