<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Dashboard Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold">Total Products</h3>
                    <p class="text-2xl font-bold">{{ $totalProducts }}</p>
                    <a href="{{ route('products.index') }}" class="text-blue-500 hover:underline">View Products</a>
                </div>
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold">Total Categories</h3>
                    <p class="text-2xl font-bold">{{ $totalCategories }}</p>
                    <a href="{{ route('categories.index') }}" class="text-blue-500 hover:underline">View Categories</a>
                </div>
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold">Total Suppliers</h3>
                    <p class="text-2xl font-bold">{{ $totalSuppliers }}</p>
                    <a href="{{ route('suppliers.index') }}" class="text-blue-500 hover:underline">View Suppliers</a>
                </div>
            </div>

            {{-- Latest Products Table --}}
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Suppliers</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($latestProducts as $product)
                            <tr>
                                <td class="px-6 py-4">{{ $product->name }}</td>
                                <td class="px-6 py-4">{{ $product->category?->name ?? 'No Category' }}</td>
                                <td class="px-6 py-4">
                                    @forelse($product->suppliers as $s)
                                        <div>
                                            {{ $s->name }}
                                            <small class="text-gray-500">(Cost: {{ $s->pivot->cost_price }}, Lead: {{ $s->pivot->lead_time_days }} days)</small>
                                        </div>
                                    @empty
                                        <span class="text-gray-400">No Suppliers</span>
                                    @endforelse
                                </td>
                                <td class="px-6 py-4">{{ $product->user?->name ?? 'Unknown' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No products yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>

