<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class BProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('backend.setting.product.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('backend.setting.product.create')->with('categories', $categories)->with('brands', $brands);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'slug' => 'required|string|unique:products,slug,' . $request->id,
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
            'is_featured' => 'required|boolean',
            'in_stock' => 'required|boolean',
            'on_sale' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ]);

        $input = $request->input();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('frontend/images/product_images'), $imageName);
            $input['image'] = 'frontend/images/product_images/' . $imageName;
        }

        Product::create($input,$validated);
        return redirect('/product')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $products = Product::find($id);
        $categories = Category::all();
        $brands = Brand::all();

        return view('backend.setting.product.edit')->with('products', $products) ->with('categories', $categories)->with('brands', $brands);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category_id' => 'required',
            'brand_id' => 'required',
            'slug' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'is_active' => 'required',
            'is_featured' =>'required',
            'in_stock' => 'required',
            'on_sale' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ]);

        $product = Product::find($id);
        $input = $request->input();

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('frontend/images/product_images'), $imageName);
            $input['image'] = 'frontend/images/product_images/' . $imageName;
        }

        $product->update($input,$validated);
        return redirect('/product')->with('info', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);
        return redirect('/product')->with('error', 'Product deleted successfully');
    }
}
