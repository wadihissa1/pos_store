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
        if (! empty($this->image)) {
            if (is_string($this->image) && str_starts_with($this->image, 'http')) {
                return $this->image;
            }

            $baseUrl = rtrim((string) config('app.pos_asset_url'), '/');
            $imagePath = ltrim((string) $this->image, '/');

            return $baseUrl.'/'.$imagePath;
        }

        return asset('images/mezher_cosmetics_logo.jpg');
    }

    public function getDiscountPercentageAttribute(): ?float
    {
        return null;
    }
}
