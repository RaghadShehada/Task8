@extends('layouts.app')

@section('title', 'تفاصيل المنتج')

@section('content')
<div class="card">
    <div class="card-header bg-info text-white">
        تفاصيل المنتج
    </div>
    <div class="card-body">
        <h5>الاسم: {{ $product->name }}</h5>
        <p>السعر: {{ $product->price }}</p>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">رجوع للقائمة</a>
    </div>
</div>
@endsection
