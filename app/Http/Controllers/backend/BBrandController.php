<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $brands = Brand::all(); // Fetch all brands

        return view('backend.setting.brand.index')->with('brands', $brands);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.setting.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:191|unique:brands,name',
            'slug' => 'nullable|unique:brands,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required|boolean',
        ]);
        $input = $request->input();
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brands', 'public');
            $validated['image'] = $imagePath;
        }

        Brand::create($input,$validated);

        return redirect('/brand')->with('success', 'Brand created successfully.');
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
        $brands = Brand::find($id);
        return view('backend.setting.brand.edit')->with('brands', $brands);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:191|unique:brands,name,' ,
            'slug' => 'nullable|unique:brands,slug,' ,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required|boolean',
        ]);

        $brand = Brand::findOrFail($id);
        $input = $request->input();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brands', 'public');
            $validated['image'] = $imagePath;
        }

        $brand->update($input,$validated);

        return redirect('/brand')->with('info', 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Brand::destroy($id);
        return redirect('/brand')->with('error', 'Brand deleted successfully.');
    }
}
