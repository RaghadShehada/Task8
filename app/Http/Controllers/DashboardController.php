<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

class DashboardController extends Controller
{
    // تأكد أن الصفحة محمية بـ auth
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // إحصائيات الكروت
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();

        // آخر 5 منتجات مع التصنيف والموردين والمالك (Eager Loading)
        $latestProducts = Product::with(['category', 'suppliers', 'user'])
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        // عرض view
        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'latestProducts'
        ));
    }
}
