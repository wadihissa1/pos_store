<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WebsiteCategory;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $latestProducts = Product::query()
            ->latestForStore()
            ->with(['category', 'defaultUnit', 'websiteSetting.websiteCategory'])
            ->orderedForStore()
            ->limit(8)
            ->get();

        $featuredProducts = Product::query()
            ->featuredForStore()
            ->with(['category', 'defaultUnit', 'websiteSetting.websiteCategory'])
            ->orderedForStore()
            ->limit(4)
            ->get();

        $offerProducts = Product::query()
            ->offersForStore()
            ->with(['category', 'defaultUnit', 'websiteSetting.websiteCategory'])
            ->orderedForStore()
            ->limit(8)
            ->get();

        $categories = WebsiteCategory::query()
            ->withCount([
                'websiteProductSettings as products_count' => function ($q): void {
                    $q->where('is_visible', true);
                },
            ])
            ->orderedForStore()
            ->limit(12)
            ->get();

        return view('pages.home', [
            'latestProducts' => $latestProducts,
            'featuredProducts' => $featuredProducts,
            'offerProducts' => $offerProducts,
            'categories' => $categories,
        ]);
    }
}
