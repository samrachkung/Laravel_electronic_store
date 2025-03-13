<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class shopController extends Controller
{
    public function shop(Request $request)
    {

        $categories = DB::table('categories')->get();
        $query = DB::table('products')
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
                'categories.id as category_id',
                'categories.name as category_name',
                'brands.name as brand_name'
            )
            ->where('products.is_active', 1);

        if ($request->has('category')) {
            $query->whereIn('products.category_id', $request->category);
        }
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('products.price', [$request->min_price, $request->max_price]);
        }
        $query->orderBy('products.created_at', 'DESC');
        $products = $query->get();
        $sort = request('sort', 'latest');
        $productSort = DB::table('products')
            ->when($sort == 'newest', fn($query) => $query->orderBy('created_at', 'desc'))
            ->when($sort == 'latest', fn($query) => $query->orderBy('updated_at', 'desc'))
            ->get();


        return view('frontend.shop.shop')
        -> with('products', $products)
        -> with('categories', $categories)
        -> with('productSort', $productSort);


    }
}
