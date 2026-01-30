<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;




class ProductController extends Controller
{
    
  public function index(Request $request)
{
    $query = Product::with(['category', 'suppliers', 'user']);

    if ($search = $request->input('search')) {
        $query->where('name', 'like', "%{$search}%");
    }

    if ($categoryId = $request->input('category_id')) {
        $query->where('category_id', $categoryId);
    }

    if ($supplierId = $request->input('supplier_id')) {
        $query->whereHas('suppliers', function ($q) use ($supplierId) {
            $q->where('suppliers.id', $supplierId);
        });
    }

    $allowedSorts = ['created_at', 'price', 'name'];
    $sortField = $request->input('sort_field', 'created_at');
    $sortDirection = $request->input('sort_direction', 'desc');

    if (!in_array($sortField, $allowedSorts)) $sortField = 'created_at';
    if (!in_array($sortDirection, ['asc','desc'])) $sortDirection = 'desc';

    $query->orderBy($sortField, $sortDirection);

   $products = $query->paginate(10); 
$products->appends(request()->all()); 



    $categories = \App\Models\Category::all();
    $suppliers = \App\Models\Supplier::all();

    return view('products.index', compact('products','categories','suppliers','search','categoryId','supplierId','sortField','sortDirection'));
}




    
    public function create()
    {
        $categories = Category::all();
        $suppliers  = Supplier::all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    
   public function store(StoreProductRequest $request)
{
    $data = $request->validated();

    if ($request->hasFile('image')) {
        $data['image_path'] = $request->file('image')->store('products', 'public');
    }

    $product = Product::create([
        'name'        => $data['name'],
        'price'       => $data['price'],
        'category_id' => $data['category_id'],
        'user_id'     => auth()->id(),
        'image_path'  => $data['image_path'] ?? null,
    ]);

    $pivot = [];
    foreach ($request->input('suppliers', []) as $supplierId => $payload) {
        if (!empty($payload['selected'])) {
            $pivot[$supplierId] = [
                'cost_price'     => $payload['cost_price'],
                'lead_time_days' => $payload['lead_time_days'],
            ];
        }
    }
    $product->suppliers()->sync($pivot);

    return redirect()->route('products.index')
                     ->with('success', 'تم إنشاء المنتج بنجاح.');
}


    
    public function show(Product $product)
    {
        $product->load(['category', 'suppliers', 'user']);
        return view('products.show', compact('product'));
    }

    
    public function edit(Product $product)
    {
        $this->authorize('update', $product); 
        $categories = Category::all();
        $suppliers  = Supplier::all();
        $product->load('suppliers');

        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    
    public function update(UpdateProductRequest $request, Product $product)
{
    $data = $request->validated();

    if ($request->hasFile('image')) {
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
    Storage::disk('public')->delete($product->image_path);
}

        }

        $data['image_path'] = $request->file('image')->store('products', 'public');
    

    $product->update([
        'name'        => $data['name'],
        'price'       => $data['price'],
        'category_id' => $data['category_id'],
        'image_path'  => $data['image_path'] ?? $product->image_path,
    ]);

    $pivot = [];
    foreach ($request->input('suppliers', []) as $supplierId => $payload) {
        if (!empty($payload['selected'])) {
            $pivot[$supplierId] = [
                'cost_price'     => $payload['cost_price'],
                'lead_time_days' => $payload['lead_time_days'],
            ];
        }
    }
    $product->suppliers()->sync($pivot);

    return redirect()->route('products.index')->with('success', 'تم تحديث المنتج بنجاح.');
}


    public function destroy(Product $product)
    {
        $this->authorize('delete', $product); 

        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'تم حذف المنتج بنجاح.');
    }
}
