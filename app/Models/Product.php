<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'stock_units',
        'cost_price',
        'barcode',
        'image',
    ];

    public function getImageUrlAttribute(): string
    {
        if (! empty($this->image)) {
            $baseUrl = rtrim((string) config('app.pos_asset_url'), '/');
            $imagePath = ltrim((string) $this->image, '/');

            return $baseUrl.'/'.$imagePath;
        }

        return asset('images/mezher_cosmetics_logo.jpg');
    }

    protected $casts = [
        'cost_price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function productUnits(): HasMany
    {
        return $this->hasMany(ProductUnit::class);
    }

    public function defaultUnit(): HasOne
    {
        return $this->hasOne(ProductUnit::class)->where('is_default', true);
    }

    public function websiteSetting(): HasOne
    {
        return $this->hasOne(WebsiteProductSetting::class);
    }

    public function scopeVisibleForStore(Builder $query): Builder
    {
        return $query->whereHas('websiteSetting', function (Builder $q): void {
            $q->where('is_visible', true);
        });
    }

    public function scopeFeaturedForStore(Builder $query): Builder
    {
        return $query->visibleForStore()->whereHas('websiteSetting', function (Builder $q): void {
            $q->where('is_featured', true);
        });
    }

    public function scopeLatestForStore(Builder $query): Builder
    {
        return $query->visibleForStore()->whereHas('websiteSetting', function (Builder $q): void {
            $q->where('is_latest', true);
        });
    }

    public function scopeOffersForStore(Builder $query): Builder
    {
        return $query->visibleForStore()->whereHas('websiteSetting', function (Builder $q): void {
            $q->where('is_offer', true);
        });
    }

    public function scopeOffers(Builder $query): Builder
    {
        return $query->offersForStore();
    }

    public function scopeOrderedForStore(Builder $query): Builder
    {
        return $query
            ->orderByRaw('(select coalesce(sort_order, 0) from website_product_settings where website_product_settings.product_id = products.id limit 1) asc')
            ->orderByDesc('products.updated_at');
    }

    public function scopeForWebsiteCategorySlug(Builder $query, string $slug): Builder
    {
        return $query->whereHas('websiteSetting', function (Builder $q) use ($slug): void {
            $q->whereHas('websiteCategory', function (Builder $q2) use ($slug): void {
                $q2->where('slug', $slug);
            });
        });
    }

    public function scopeForBrandSlug(Builder $query, string $slug): Builder
    {
        if (! Category::hasSlugColumn()) {
            return $query->whereRaw('1 = 0');
        }

        return $query->whereHas('category', function (Builder $q) use ($slug): void {
            $q->where('slug', $slug);
        });
    }

    public function isInStock(): bool
    {
        return (int) $this->stock_units > 0;
    }

    public function getSellableQuantityAttribute(): int
    {
        $stock = (int) $this->stock_units;
        if ($this->relationLoaded('defaultUnit') && $this->defaultUnit && isset($this->defaultUnit->multiplier)) {
            $multiplier = (float) ($this->defaultUnit->multiplier ?: 1);
            return $multiplier > 0 ? (int) floor($stock / $multiplier) : 0;
        }
        return $stock;
    }
}
