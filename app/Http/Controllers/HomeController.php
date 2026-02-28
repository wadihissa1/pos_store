<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $latestProducts = Product::query()
            ->with(['category', 'defaultUnit'])
            ->latest()
            ->limit(8)
            ->get();

        $featuredProducts = Product::query()
            ->with(['category', 'defaultUnit'])
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $categories = Category::query()
            ->withCount('products')
            ->with(['products' => fn ($q) => $q->limit(1)])
            ->orderBy('name')
            ->limit(12)
            ->get();

        return view('pages.home', [
            'latestProducts' => $latestProducts,
            'featuredProducts' => $featuredProducts,
            'categories' => $categories,
        ]);
    }
}
