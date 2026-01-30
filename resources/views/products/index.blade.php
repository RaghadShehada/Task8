<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            قائمة المنتجات
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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

            @auth
                <div class="mb-4">
                    <a href="{{ route('products.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        إضافة منتج
                    </a>
                </div>
            @endauth

            <form method="GET" action="{{ route('products.index') }}" class="mb-4 grid grid-cols-1 md:grid-cols-5 gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث باسم المنتج..." class="p-2 border rounded col-span-1 md:col-span-2">

                <select name="category_id" class="p-2 border rounded col-span-1">
                    <option value="">كل التصنيفات</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <select name="supplier_id" class="p-2 border rounded col-span-1">
                    <option value="">كل الموردين</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>

                <select name="sort_field" class="p-2 border rounded col-span-1">
                    <option value="created_at" {{ request('sort_field') == 'created_at' ? 'selected' : '' }}>تاريخ الإنشاء</option>
                    <option value="price" {{ request('sort_field') == 'price' ? 'selected' : '' }}>السعر</option>
                    <option value="name" {{ request('sort_field') == 'name' ? 'selected' : '' }}>الاسم</option>
                </select>

                <div class="col-span-1 md:col-span-1 flex gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex-1">تطبيق</button>
                    <a href="{{ route('products.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 flex-1">إعادة ضبط</a>
                </div>
            </form>

            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">#</th>
                            <th class="px-4 py-2 text-left">الصورة</th>
                            <th class="px-4 py-2 text-left">الاسم</th>
                            <th class="px-4 py-2 text-left">السعر</th>
                            <th class="px-4 py-2 text-left">التصنيف</th>
                            <th class="px-4 py-2 text-left">الموردون</th>
                            <th class="px-4 py-2 text-left">المالك</th>
                            <th class="px-4 py-2 text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $product->id }}</td>
                                <td class="px-4 py-2">
                                    <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : asset('images/placeholder.png') }}"
                                         alt="{{ $product->name }}"
                                         class="w-16 h-16 object-cover rounded">
                                </td>
                                <td class="px-4 py-2">{{ $product->name }}</td>
                                <td class="px-4 py-2">{{ $product->price }}</td>
                                <td class="px-4 py-2">{{ $product->category?->name ?? 'بدون تصنيف' }}</td>
                                <td class="px-4 py-2">
                                    @forelse($product->suppliers as $s)
                                        <div class="text-sm">
                                            {{ $s->name }}
                                            <span class="text-gray-500">(cost: {{ $s->pivot->cost_price }}, lead: {{ $s->pivot->lead_time_days }} يوم)</span>
                                        </div>
                                    @empty
                                        <span class="text-gray-400">لا يوجد موردون</span>
                                    @endforelse
                                </td>
                                <td class="px-4 py-2">{{ $product->user?->name ?? 'غير معروف' }}</td>
                                <td class="px-4 py-2 text-center space-x-1">
                                    <a href="{{ route('products.show', $product->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-2 py-1 rounded text-sm">عرض</a>
                                    @can('update', $product)
                                        <a href="{{ route('products.edit', $product->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-sm">تعديل</a>
                                    @endcan
                                    @can('delete', $product)
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm" onclick="return confirm('تأكيد الحذف؟')">حذف</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-4 text-center text-gray-500">لا توجد منتجات مطابقة للمعايير</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $products->withQueryString()->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
