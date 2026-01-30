<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Category
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-6 rounded shadow">

                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Category Name --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            Category Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $category->name) }}"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
                            placeholder="Enter category name"
                            required
                        >
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3">
                        <button
                            type="submit"
                            class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700"
                        >
                            Update
                        </button>

                        <a
                            href="{{ route('categories.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                        >
                            Back
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
