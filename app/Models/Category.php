<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getImageUrlAttribute(): string
    {
        $posBaseUrl = rtrim((string) config('app.pos_asset_url'), '/');

        // If POS stores a direct category image path in the `categories.image` column,
        // use it (do NOT require a product relation to be loaded).
        $categoryImage = $this->image ?? null;
        if (! empty($categoryImage)) {
            if (str_starts_with($categoryImage, 'http')) {
                return $categoryImage;
            }

            return $posBaseUrl . '/' . ltrim((string) $categoryImage, '/');
        }

        // Otherwise use the first related product image as the category thumbnail.
        if ($this->relationLoaded('products') && $this->products->isNotEmpty()) {
            return $this->products->first()->image_url;
        }

        // Local placeholder (same style as products fallback).
        return asset('images/mezher_cosmetics_logo.jpg');
    }

    /**
     * Percentage discount applied at category level, if any.
     */
    public function getDiscountPercentageAttribute(): ?float
    {
        /** @var \App\Models\DiscountRule|null $rule */
        $rule = DiscountRule::where('type', DiscountRule::TYPE_CATEGORY)
            ->where('entity_id', $this->id)
            ->first();

        return $rule ? (float) $rule->percentage : null;
    }
}

