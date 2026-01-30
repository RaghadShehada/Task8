<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Categories
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Add Button --}}
            <a href="{{ route('categories.create') }}"
               class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
                + Add Category
            </a>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full">

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">ID</th>
                            <th class="p-3 text-left">Name</th>
                            <th class="p-3 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($categories as $category)

                            <tr class="border-t">

                                <td class="p-3">{{ $category->id }}</td>

                                <td class="p-3">{{ $category->name }}</td>

                                <td class="p-3 text-center">

                                    <a href="{{ route('categories.edit', $category->id) }}"
                                       class="text-yellow-600 mr-2">
                                        Edit
                                    </a>

                                    <form action="{{ route('categories.destroy', $category->id) }}"
                                          method="POST"
                                          class="inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                onclick="return confirm('Delete this category?')"
                                                class="text-red-600">
                                            Delete
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="3" class="p-3 text-center text-gray-500">
                                    No categories found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</x-app-layout>
