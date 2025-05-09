<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

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



        if ($request->image) {
            $image_name = $request->file('image');

            $input['image'] = time() . '.' . $image_name->getClientOriginalExtension();

            $destinationPath = public_path('/uploads/thumbnail/image');
            $imgFile = Image::read($image_name->getRealPath());
            $imgFile->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $input['image']);
            $destinationPath = public_path('/uploads/image');
            $image_name->move($destinationPath, $input['image']);
        }

        Product::create($input, $validated);
        return redirect('/admin/product')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = Product::find($id);
        return view('backend.setting.product.show')->with('products', $products);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $products = Product::find($id);
        $categories = Category::all();
        $brands = Brand::all();

        return view('backend.setting.product.edit')->with('products', $products)->with('categories', $categories)->with('brands', $brands);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'slug' => 'required|string|unique:products,slug,' . $id,
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
            'is_featured' => 'required|boolean',
            'in_stock' => 'required|boolean',
            'on_sale' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                $oldImagePath = public_path('/uploads/image/' . $product->image);
                $oldThumbnailPath = public_path('/uploads/thumbnail/image/' . $product->image);
                if (file_exists($oldImagePath))
                    unlink($oldImagePath);
                if (file_exists($oldThumbnailPath))
                    unlink($oldThumbnailPath);
            }

            // Upload new image
            $image = $request->file('image');
            $newImageName = time() . '.' . $image->getClientOriginalExtension();
            $validated['image'] = $newImageName; // Add image to validated data

            // Save resized thumbnail
            $thumbnailPath = public_path('/uploads/thumbnail/image');
            $fullImagePath = public_path('/uploads/image');

            $imgFile = Image::read($image->getRealPath());
            $imgFile->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbnailPath . '/' . $newImageName);

            // Move full image
            $image->move($fullImagePath, $newImageName);
        }

        $product->update($validated);

        return redirect('/admin/product')->with('info', 'Product updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            $fullImagePath = public_path('/uploads/image/' . $product->image);
            $thumbnailPath = public_path('/uploads/thumbnail/image/' . $product->image);

            if (file_exists($fullImagePath)) {
                unlink($fullImagePath);
            }
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            }
        }

        $product->delete();

        return redirect('/admin/product')->with('error', 'Product deleted successfully');
    }
}
