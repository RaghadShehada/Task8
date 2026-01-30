<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // حماية كل الـ Routes بالـ auth
    public function __construct()
    {
        $this->middleware('auth');
    }

    // عرض كل التصنيفات
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // صفحة إضافة تصنيف جديد
    public function create()
    {
        return view('categories.create');
    }

    // تخزين تصنيف جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Category::create($request->only('name'));

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    // عرض تصنيف واحد (اختياري)
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    // صفحة تعديل التصنيف
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // تحديث التصنيف
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update($request->only('name'));

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    // حذف التصنيف
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
