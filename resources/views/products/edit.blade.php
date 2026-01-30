<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تعديل المنتج
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">اسم المنتج</label>
                        <input type="text" name="name" class="w-full border-gray-300 rounded px-3 py-2" value="{{ old('name', $product->name) }}">
                        @error('name')<small class="text-red-500">{{ $message }}</small>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">السعر</label>
                        <input type="number" name="price" step="0.01" class="w-full border-gray-300 rounded px-3 py-2" value="{{ old('price', $product->price) }}">
                        @error('price')<small class="text-red-500">{{ $message }}</small>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">التصنيف</label>
                        <select name="category_id" class="w-full border-gray-300 rounded px-3 py-2">
                            <option value="">-- اختر التصنيف --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id)==$category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<small class="text-red-500">{{ $message }}</small>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">الموردون</label>
                        <select name="suppliers[]" multiple class="w-full border-gray-300 rounded px-3 py-2">
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ in_array($supplier->id, old('suppliers', $product->suppliers->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('suppliers')<small class="text-red-500">{{ $message }}</small>@enderror
                    </div>

                    <div class="flex space-x-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">تحديث</button>
                        <a href="{{ route('products.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">إلغاء</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
