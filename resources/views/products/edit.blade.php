<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تعديل المنتج
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="container max-w-3xl">

            <div class="card shadow mb-6">
                <div class="card-body">

                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">اسم المنتج</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}">
                            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">السعر</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}">
                            @error('price')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">التصنيف</label>
                            <select name="category_id" class="form-select">
                                <option value="">-- اختر التصنيف --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">الموردون</label>
                            @foreach($suppliers as $supplier)
                                @php $pivot = $product->suppliers->find($supplier->id)?->pivot; @endphp
                                <div class="border p-2 rounded mb-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="suppliers[{{ $supplier->id }}][selected]" {{ $pivot ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $supplier->name }}</label>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col">
                                            <input type="number" name="suppliers[{{ $supplier->id }}][cost_price]" placeholder="سعر التكلفة" value="{{ $pivot->cost_price ?? '' }}" class="form-control">
                                        </div>
                                        <div class="col">
                                            <input type="number" name="suppliers[{{ $supplier->id }}][lead_time_days]" placeholder="مدة التوريد (يوم)" value="{{ $pivot->lead_time_days ?? '' }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <label class="form-label">صورة المنتج</label>
                            <input type="file" name="image" class="form-control">
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" class="mt-2 rounded" style="width:120px; height:120px; object-fit:cover;">
                            @endif
                            @error('image')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-center gap-2 mt-4">
                            <button type="submit" class="btn btn-success"> حفظ </button>
                            <a href="{{ route('products.index') }}" class="btn btn-danger">إلغاء</a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>

