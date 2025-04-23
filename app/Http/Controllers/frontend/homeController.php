<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class homeController extends Controller
{
    public function index()
    {
        $products = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                'products.id',
                'products.name as product_name',
                'products.slug',
                'products.image',
                'products.description',
                'products.price',
                'products.quantity',
                'products.is_active',
                'products.is_featured',
                'categories.name as category_name',
                'brands.name as brand_name'
            )
            ->where('products.is_active', 1) // Only active products
            ->orderBy('products.created_at', 'DESC') // Latest products first
            ->limit(20) // Show only 20 products
            ->get();

        // Get products with ID between 1 and 10
        $products1 = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                'products.id',
                'products.name as product_name',
                'products.slug',
                'products.image',
                'products.description',
                'products.price',
                'products.quantity',
                'products.is_active',
                'products.is_featured',
                'categories.name as category_name',
                'brands.name as brand_name'
            )
            ->where('products.is_active', 1)
            ->whereBetween('products.id', [1, 10]) // Only products with ID 1-10
            ->orderBy('products.created_at', 'DESC')
            ->get();

        $products2 = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                'products.id',
                'products.name as product_name',
                'products.slug',
                'products.image',
                'products.description',
                'products.price',
                'products.quantity',
                'products.is_active',
                'products.is_featured',
                'categories.name as category_name',
                'brands.name as brand_name'
            )
            ->where('products.is_active', 1)
            ->whereBetween('products.id', [9, 20]) // Only products with ID 11-20
            ->orderBy('products.created_at', 'DESC')
            ->get();

            $username = Auth::check() ? Auth::user()->name : null;
        return view('frontend.home.index')
            ->with('products', $products)
            ->with('products1', $products1)
            ->with('products2', $products2)
            ->with('username', $username)
        ;
    }
}

