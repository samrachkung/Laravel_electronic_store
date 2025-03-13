<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class BCateogryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {

        $categories = Category::all(); // Fetch all categories

        return view('backend.setting.category.index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('backend.setting.category.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'slug' => 'required|unique:categories,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'is_active' => 'required|boolean',
        ]);
        $input = $request->input();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('frontend/images/category_images'), $imageName);
            $input['image'] = 'frontend/images/category_images/' . $imageName;
        }
        // Store the category
        Category::create($input,$validated);
        return redirect('/category')->with('success', 'Category created successfully');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('backend.setting.category.edit')->with('category', $category);
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'slug' => 'required|unique:categories,slug,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'is_active' => 'required|boolean',
        ]);
        $input = $request->input();
        $category = Category::findOrFail($id);
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('frontend/images/category_images'), $imageName);
            $input['image'] = 'frontend/images/category_images/' . $imageName;
        }
        $category->update($input,$validated);
        return redirect('/category')->with('info', 'Category updated successfully');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(string $id)
    {
        Category::destroy($id);
        return redirect('/category')->with('error', 'Category deleted successfully');
    }
}
