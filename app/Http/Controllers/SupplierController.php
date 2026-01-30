<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    // حماية كل الـ Routes بالـ auth
    public function __construct()
    {
        $this->middleware('auth');
    }

    // عرض كل الموردين
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    // صفحة إضافة مورد جديد
    public function create()
    {
        return view('suppliers.create');
    }

    // تخزين مورد جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:suppliers,email'
        ]);

        Supplier::create($request->only('name', 'email'));

        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully!');
    }

    // عرض مورد واحد
    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    // صفحة تعديل المورد
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    // تحديث المورد
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:suppliers,email,' . $supplier->id
        ]);

        $supplier->update($request->only('name', 'email'));

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully!');
    }

    // حذف المورد
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully!');
    }
}
