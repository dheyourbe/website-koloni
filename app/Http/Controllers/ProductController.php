<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $category = $request->get('category', 'minuman'); // Default to minuman

        $products = Product::when($category, function ($query, $category) {
            return $query->where('category', $category);
        })->get();

        $foodProducts = Product::where('category', 'makanan')->get();
        $drinkProducts = Product::where('category', 'minuman')->get();

        return view('products.index', compact('foodProducts', 'drinkProducts', 'category'));
    }
}
