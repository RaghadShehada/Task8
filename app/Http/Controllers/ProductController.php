<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * عرض قائمة المنتجات مع التصنيف والموردين
     */
  public function index()
{
    $products = Product::with(['category', 'suppliers', 'user'])
        ->latest()
        ->paginate(10);

    return view('products.index', compact('products'));
}




    /**
     * عرض صفحة إنشاء منتج جديد
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers  = Supplier::all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    /**
     * تخزين منتج جديد مع الموردين (pivot) وربطه بالمستخدم الحالي
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        // إنشاء المنتج وربطه بالمستخدم الحالي
        $product = Product::create([
            'name'        => $data['name'],
            'price'       => $data['price'],
            'category_id' => $data['category_id'],
            'user_id'     => auth()->id(), // ربط المنتج بالمستخدم الحالي
        ]);

        // تجهيز بيانات الـ pivot
        $pivot = [];
        foreach ($request->input('suppliers', []) as $supplierId => $payload) {
            if (!empty($payload['selected'])) {
                $pivot[$supplierId] = [
                    'cost_price'     => $payload['cost_price'],
                    'lead_time_days' => $payload['lead_time_days'],
                ];
            }
        }

        // ربط الموردين بالمنتج
        $product->suppliers()->sync($pivot);

        return redirect()->route('products.index')
                         ->with('success', 'تم إنشاء المنتج وربطه بالمستخدم والموردين بنجاح.');
    }

    /**
     * عرض تفاصيل منتج واحد
     */
    public function show(Product $product)
    {
        $product->load(['category', 'suppliers', 'user']);
        return view('products.show', compact('product'));
    }

    /**
     * عرض صفحة تعديل منتج
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product); // التحقق من الصلاحيات

        $categories = Category::all();
        $suppliers  = Supplier::all();
        $product->load('suppliers');

        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * تحديث بيانات منتج مع الموردين (pivot)
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product); // التحقق من الصلاحيات

        $data = $request->validated();

        // تحديث المنتج
        $product->update([
            'name'        => $data['name'],
            'price'       => $data['price'],
            'category_id' => $data['category_id'],
        ]);

        // تجهيز بيانات الـ pivot
        $pivot = [];
        foreach ($request->input('suppliers', []) as $supplierId => $payload) {
            if (!empty($payload['selected'])) {
                $pivot[$supplierId] = [
                    'cost_price'     => $payload['cost_price'],
                    'lead_time_days' => $payload['lead_time_days'],
                ];
            }
        }

        // تحديث الموردين المرتبطين بالمنتج
        $product->suppliers()->sync($pivot);

        return redirect()->route('products.index')
                         ->with('success', 'تم تحديث المنتج والموردين بنجاح.');
    }

    /**
     * حذف منتج
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product); // التحقق من الصلاحيات

        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'تم حذف المنتج بنجاح.');
    }
}
