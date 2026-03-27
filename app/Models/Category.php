<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public static function hasSlugColumn(): bool
    {
        return Schema::hasColumn((new static)->getTable(), 'slug');
    }

    public function getRouteKeyName(): string
    {
        return static::hasSlugColumn() ? 'slug' : 'id';
    }

    public function getRouteKey(): mixed
    {
        if (static::hasSlugColumn() && ! empty($this->attributes['slug'] ?? null)) {
            return $this->slug;
        }

        return $this->getKey();
    }

    /**
     * Resolve collection URLs by id, or by slug when the `categories.slug` column exists.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if ($field !== null) {
            return parent::resolveRouteBinding($value, $field);
        }

        if (ctype_digit((string) $value)) {
            return static::query()->where('id', $value)->firstOrFail();
        }

        if (static::hasSlugColumn()) {
            return static::query()->where('slug', $value)->firstOrFail();
        }

        return static::query()->where('id', $value)->firstOrFail();
    }

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

