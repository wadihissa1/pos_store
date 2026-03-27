<?php

namespace App\Queries;

use App\Models\Product;
use App\Models\WebsiteCategory;
use Illuminate\Database\Eloquent\Builder;

/**
 * Reference queries for storefront product listings (same patterns as controllers).
 */
final class StoreProductQueryExamples
{
    public static function allVisible(): Builder
    {
        return Product::query()
            ->with(['category', 'defaultUnit', 'websiteSetting.websiteCategory'])
            ->visibleForStore()
            ->orderedForStore();
    }

    public static function featured(): Builder
    {
        return Product::query()
            ->with(['category', 'defaultUnit', 'websiteSetting.websiteCategory'])
            ->featuredForStore()
            ->orderedForStore();
    }

    public static function latest(): Builder
    {
        return Product::query()
            ->with(['category', 'defaultUnit', 'websiteSetting.websiteCategory'])
            ->latestForStore()
            ->orderedForStore();
    }

    public static function offers(): Builder
    {
        return Product::query()
            ->with(['category', 'defaultUnit', 'websiteSetting.websiteCategory'])
            ->offersForStore()
            ->orderedForStore();
    }

    public static function forWebsiteCategorySlug(string $slug): Builder
    {
        return self::allVisible()->whereHas('websiteSetting', function (Builder $q) use ($slug): void {
            $q->whereHas('websiteCategory', function (Builder $q2) use ($slug): void {
                $q2->where('slug', $slug);
            });
        });
    }

    public static function forWebsiteCategory(WebsiteCategory $websiteCategory): Builder
    {
        return self::allVisible()->whereHas('websiteSetting', function (Builder $q) use ($websiteCategory): void {
            $q->where('website_category_id', $websiteCategory->getKey());
        });
    }

    public static function forBrandSlug(string $slug): Builder
    {
        return self::allVisible()->forBrandSlug($slug);
    }
}
