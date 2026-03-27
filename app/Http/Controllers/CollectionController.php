<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\WebsiteCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollectionController extends Controller
{
    public function index(): View
    {
        $allBrands = Category::query()
            ->orderBy('name')
            ->get();

        $query = Category::query()
            ->withCount([
                'products as products_count' => function ($q): void {
                    $q->whereHas('websiteSetting', fn ($q2) => $q2->where('is_visible', true));
                },
            ])
            ->with([
                'products' => function ($q): void {
                    $q->whereHas('websiteSetting', fn ($q2) => $q2->where('is_visible', true))
                        ->orderByRaw('CASE WHEN image IS NOT NULL AND image != "" THEN 0 ELSE 1 END')
                        ->orderBy('id')
                        ->limit(1);
                },
            ])
            ->orderBy('name');

        if (request()->filled('brand')) {
            $brand = (string) request('brand');
            if (ctype_digit($brand)) {
                $query->where('id', (int) $brand);
            } elseif (Category::hasSlugColumn()) {
                $query->where('slug', $brand);
            }
        }

        $brands = $query->get();

        return view('pages.collection.index', [
            'allBrands' => $allBrands,
            'brands' => $brands,
        ]);
    }

    public function show(Request $request, Category $category): View
    {
        $category->loadCount([
            'products as products_count' => function ($q): void {
                $q->whereHas('websiteSetting', fn ($q2) => $q2->where('is_visible', true));
            },
        ]);

        $query = Product::query()
            ->visibleForStore()
            ->where('category_id', $category->getKey())
            ->with(['category', 'defaultUnit', 'websiteSetting.websiteCategory']);

        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($q) use ($term): void {
                $q->where('name', 'like', '%'.$term.'%')
                    ->orWhere('description', 'like', '%'.$term.'%');
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

        $products = $query->orderedForStore()->paginate(12)->withQueryString();

        $websiteCategories = WebsiteCategory::query()
            ->orderedForStore()
            ->get();

        return view('pages.collection.show', [
            'brand' => $category,
            'products' => $products,
            'websiteCategories' => $websiteCategories,
        ]);
    }
}
