<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>قائمة المنتجات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <h2 class="mb-4">قائمة المنتجات</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @auth
        <a href="{{ route('products.create') }}" class="btn btn-success mb-3">
            <i class="fa fa-plus"></i> إضافة منتج
        </a>
    @endauth

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>السعر</th>
                    <th>التصنيف</th>
                    <th>الموردون</th>
                    <th>المالك</th>
                    <th class="text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->category ? $product->category->name : 'بدون تصنيف' }}</td>
                        <td>
                            @forelse($product->suppliers as $s)
                                <div>
                                    {{ $s->name }}
                                    <small class="text-muted">
                                        (cost: {{ $s->pivot->cost_price }}, lead: {{ $s->pivot->lead_time_days }} يوم)
                                    </small>
                                </div>
                            @empty
                                <span class="text-muted">لا يوجد موردون</span>
                            @endforelse
                        </td>
                        <td>{{ $product->user->name ?? 'غير معروف' }}</td>
                        <td class="text-center">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm me-1">
                                <i class="fa fa-eye"></i> عرض
                            </a>
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
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-danger">لا توجد منتجات حالياً</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $products->links() }}
    </div>
</div>
</body>
</html>
