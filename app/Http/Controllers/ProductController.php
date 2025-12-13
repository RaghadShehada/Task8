<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Read - عرض قائمة المنتجات
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }
    // Show - عرض منتج واحد
    public function show(Product $product)
    {
    return view('products.show', compact('product'));
     }


    // Create - إظهار فورم الإضافة
    public function create()
    {
        return view('products.create');
    }

    // Store - حفظ المنتج الجديد
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric'
        ]);

        Product::create($request->only(['name','price']));

        return redirect()->route('products.index')->with('success', 'Product Added');
    }

    // Edit - إظهار فورم التعديل
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Update - حفظ التغييرات
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric'
        ]);

        $product->update($request->only(['name','price']));

        return redirect()->route('products.index')->with('success', 'Product Updated');
    }

    // Delete - حذف المنتج
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product Deleted');
    }
}
