<!doctype html> 
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>تفاصيل المنتج</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <h2 class="mb-4">تفاصيل المنتج</h2>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">المنتج: {{ $product->name }}</h5>
            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> رجوع للقائمة
            </a>
        </div>

        <div class="card-body">

            <div class="mb-4 text-center">
                <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : asset('images/placeholder.png') }}"
                     alt="{{ $product->name }}"
                     class="w-64 h-64 object-cover rounded mx-auto">
            </div>

            <dl class="row">
                <dt class="col-sm-3">الاسم:</dt>
                <dd class="col-sm-9">{{ $product->name }}</dd>

                <dt class="col-sm-3">السعر:</dt>
                <dd class="col-sm-9">{{ $product->price }}</dd>

                <dt class="col-sm-3">التصنيف:</dt>
                <dd class="col-sm-9">{{ $product->category ? $product->category->name : 'بدون تصنيف' }}</dd>

                <dt class="col-sm-3">المالك:</dt>
                <dd class="col-sm-9">{{ $product->user->name ?? 'غير معروف' }}</dd>

                <dt class="col-sm-3">تاريخ الإنشاء:</dt>
                <dd class="col-sm-9">{{ $product->created_at->format('Y-m-d') }}</dd>

                <dt class="col-sm-3">آخر تحديث:</dt>
                <dd class="col-sm-9">{{ $product->updated_at->format('Y-m-d') }}</dd>
            </dl>

            <hr>
            <h5>الموردون</h5>
            @forelse($product->suppliers as $s)
                <div class="mb-1">
                    <strong>{{ $s->name }}</strong>
                    <span class="text-muted">
                        — التكلفة: {{ $s->pivot->cost_price }} ، مدة التوريد: {{ $s->pivot->lead_time_days }} يوم
                    </span>
                </div>
            @empty
                <div class="text-muted">لا يوجد موردون مرتبطون بهذا المنتج.</div>
            @endforelse

            <div class="mt-3">
                @can('update', $product)
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm me-1">
                        <i class="fa fa-edit"></i> تعديل
                    </a>
                @endcan
                @can('delete', $product)
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('تأكيد الحذف؟')">
                            <i class="fa fa-trash"></i> حذف
                        </button>
                    </form>
                @endcan
            </div>

        </div>
    </div>
</div>

</body>
</html>
