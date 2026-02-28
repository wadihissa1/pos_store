<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->withCount('products')
            ->with(['products' => fn ($q) => $q->limit(1)])
            ->orderBy('name')
            ->get();

        return view('pages.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function show(Category $category): View
    {
        $category->load(['products' => fn ($q) => $q->limit(1)])->loadCount('products');

        $products = $category->products()
            ->with(['category', 'defaultUnit'])
            ->latest()
            ->paginate(12);

        return view('pages.categories.show', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}
