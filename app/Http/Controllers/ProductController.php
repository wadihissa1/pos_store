<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()->with(['category', 'defaultUnit']);

        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', '%' . $term . '%')
                    ->orWhere('description', 'like', '%' . $term . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        $categories = Category::query()->orderBy('name')->get();

        return view('pages.products.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'defaultUnit']);

        return view('pages.products.show', [
            'product' => $product,
        ]);
    }
}
