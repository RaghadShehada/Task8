<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>تعديل المنتج</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <h2 class="mb-4">تعديل المنتج</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">الاسم</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}">
            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">السعر</label>
            <input type="text" name="price" class="form-control" value="{{ old('price', $product->price) }}">
            @error('price') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">التصنيف</label>
            <select name="category_id" class="form-select">
                <option value="">-- اختر التصنيف --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <hr>
        <h5>الموردون</h5>
        @error('suppliers') <div class="text-danger mb-2">{{ $message }}</div> @enderror

        @php
            $pivotMap = $product->suppliers->keyBy('id')->map(fn($s) => [
                'cost_price' => $s->pivot->cost_price,
                'lead_time_days' => $s->pivot->lead_time_days,
            ]);
        @endphp

        <div class="row g-3">
            @foreach($suppliers as $supplier)
                @php
                    $selected = old("suppliers.$supplier->id.selected") ??
                                ($pivotMap->has($supplier->id) ? 1 : null);
                    $cost = old("suppliers.$supplier->id.cost_price") ??
                            ($pivotMap[$supplier->id]['cost_price'] ?? '');
                    $lead = old("suppliers.$supplier->id.lead_time_days") ??
                            ($pivotMap[$supplier->id]['lead_time_days'] ?? '');
                @endphp
                <div class="col-md-6">
                    <div class="border rounded p-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox"
                                   name="suppliers[{{ $supplier->id }}][selected]" value="1"
                                   {{ $selected ? 'checked' : '' }}>
                            <label class="form-check-label">
                                {{ $supplier->name }} — {{ $supplier->email }}
                            </label>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Cost price</label>
                            <input type="text" class="form-control"
                                   name="suppliers[{{ $supplier->id }}][cost_price]"
                                   value="{{ $cost }}">
                        </div>
                        <div>
                            <label class="form-label">Lead time (days)</label>
                            <input type="number" class="form-control"
                                   name="suppliers[{{ $supplier->id }}][lead_time_days]"
                                   value="{{ $lead }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mt-3">تحديث</button>
    </form>
</div>
</body>
</html>
