<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            قائمة المنتجات
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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

            {{-- Add Product Button --}}
            @auth
                <div class="mb-4">
                    <a href="{{ route('products.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        إضافة منتج
                    </a>
                </div>
            @endauth

            {{-- Products Table --}}
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">#</th>
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
                                <td colspan="7" class="px-4 py-4 text-center text-gray-500">لا توجد منتجات حالياً</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
