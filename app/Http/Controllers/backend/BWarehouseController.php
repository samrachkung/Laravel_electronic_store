<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class BWarehouseController extends Controller
{
    public function index()
    {
        // Get low stock products (less than 10 items)
        $lowStockProducts = Product::where('quantity', '<', 10)
            ->orderBy('quantity', 'asc')
            ->get();

        // Get out of stock products
        $outOfStockProducts = Product::where('quantity', '<=', 0)
            ->orderBy('quantity', 'asc')
            ->get();

        // Get all products with pagination
        $products = Product::with(['category', 'brand'])
            ->orderBy('quantity', 'asc')
            ->paginate(20);

        // Get categories and brands for filters
        $categories = Category::all();
        $brands = Brand::all();

        return view('backend.warehouse.index', compact(
            'lowStockProducts',
            'outOfStockProducts',
            'products',
            'categories',
            'brands'
        ));
    }

    /**
     * Update product stock
     */
    public function updateStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
            'adjustment_type' => 'required|in:set,add,subtract'
        ]);

        switch ($validated['adjustment_type']) {
            case 'add':
                $product->quantity += $validated['quantity'];
                break;
            case 'subtract':
                $product->quantity = max(0, $product->quantity - $validated['quantity']);
                break;
            case 'set':
                $product->quantity = $validated['quantity'];
                break;
        }

        $product->in_stock = $product->quantity > 0;
        $product->save();

        return back()->with('success', 'Stock updated successfully');
    }

    /**
     * Filter products
     */
    public function filter(Request $request)
    {
        $query = Product::query()->with(['category', 'brand']);

        // Apply filters
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'low':
                    $query->where('quantity', '<', 10)->where('quantity', '>', 0);
                    break;
                case 'out':
                    $query->where('quantity', '<=', 0);
                    break;
                case 'in_stock':
                    $query->where('quantity', '>', 0);
                    break;
            }
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->orderBy('quantity', 'asc')
            ->paginate(20)
            ->appends($request->all());

        $categories = Category::all();
        $brands = Brand::all();

        return view('backend.warehouse.index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'lowStockProducts' => Product::where('quantity', '<', 10)->get(),
            'outOfStockProducts' => Product::where('quantity', '<=', 0)->get(),
            'filters' => $request->all()
        ]);
    }
}
