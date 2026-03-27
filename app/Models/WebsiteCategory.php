<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

class WebsiteCategory extends Model
{
    protected $table = 'website_categories';

    protected $fillable = [
        'name',
        'slug',
        'sort_order',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function websiteProductSettings(): HasMany
    {
        return $this->hasMany(WebsiteProductSetting::class);
    }

    public function scopeOrderedForStore(Builder $query): Builder
    {
        $table = $query->getModel()->getTable();

        if (Schema::hasColumn($table, 'sort_order')) {
            return $query->orderBy($table . '.sort_order')->orderBy($table . '.name');
        }

        return $query->orderBy($table . '.name');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getImageUrlAttribute(): string
    {
        $path = $this->image;

        if ($path === null || $path === '') {
            return asset('images/mezher_cosmetics_logo.jpg');
        }

        if (is_string($path) && str_starts_with($path, 'http')) {
            return $path;
        }

        $base = rtrim((string) config('app.pos_asset_url'), '/');

        return $base !== '' ? $base . '/' . ltrim((string) $path, '/') : asset('images/mezher_cosmetics_logo.jpg');
    }

    public function getDiscountPercentageAttribute(): ?float
    {
        return null;
    }
}
