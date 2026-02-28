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
            return str_starts_with($this->image, 'http') ? $this->image : asset('storage/' . ltrim($this->image, '/'));
        }
        return 'https://picsum.photos/seed/' . ($this->id ?? 1) . '/600/400';
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

    public function scopeOffers(Builder $query): Builder
    {
        return $query->where('stock_units', '>', 50);
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
