<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\WebsiteCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()
            ->visibleForStore()
            ->with(['category', 'defaultUnit', 'websiteSetting.websiteCategory']);

        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', '%' . $term . '%')
                    ->orWhere('description', 'like', '%' . $term . '%');
            });
        }

        if ($request->filled('website_category')) {
            $wc = (string) $request->website_category;
            if (ctype_digit($wc)) {
                $query->whereHas('websiteSetting', function ($q) use ($wc): void {
                    $q->where('website_category_id', (int) $wc);
                });
            } else {
                $query->forWebsiteCategorySlug($wc);
            }
        }

        if ($request->filled('brand')) {
            $brand = (string) $request->brand;
            if (ctype_digit($brand)) {
                $query->where('category_id', (int) $brand);
            } else {
                $query->forBrandSlug($brand);
            }
        }

        $products = $query->orderedForStore()->paginate(12)->withQueryString();

        $websiteCategories = WebsiteCategory::query()
            ->orderedForStore()
            ->get();

        $brands = Category::query()
            ->orderBy('name')
            ->get();

        return view('pages.products.index', [
            'products' => $products,
            'websiteCategories' => $websiteCategories,
            'brands' => $brands,
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->websiteSetting?->is_visible, 404);

        $product->load(['category', 'defaultUnit', 'websiteSetting.websiteCategory']);

        return view('pages.products.show', [
            'product' => $product,
        ]);
    }
}
