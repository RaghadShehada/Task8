<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Suppliers
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('suppliers.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
                + Add Supplier
            </a>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full">

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">ID</th>
                            <th class="p-3 text-left">Name</th>
                            <th class="p-3 text-left">Email</th>
                            <th class="p-3 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($suppliers as $supplier)
                            <tr class="border-t">
                                <td class="p-3">{{ $supplier->id }}</td>
                                <td class="p-3">{{ $supplier->name }}</td>
                                <td class="p-3">{{ $supplier->email }}</td>
                                <td class="p-3 text-center">
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="text-yellow-600 mr-2">Edit</a>

                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this supplier?')" class="text-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-gray-500">
                                    No suppliers found
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>
</x-app-layout>
