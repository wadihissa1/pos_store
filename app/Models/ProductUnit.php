<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductUnit extends Model
{
    protected $fillable = ['product_id', 'name', 'symbol', 'is_default', 'price', 'label', 'available_quantity', 'multiplier'];

    protected $casts = [
        'is_default' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function getLabelAttribute($value): string
    {
        return $value ?: ($this->attributes['name'] ?? '');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Percentage discount applied to this unit, if any.
     */
    public function getDiscountPercentageAttribute(): ?float
    {
        $product = $this->relationLoaded('product') ? $this->product : $this->product()->first();
        $categoryId = $product?->category_id;

        return DiscountRule::getDiscountForUnit(
            $this->id,
            (int) $this->product_id,
            $categoryId ? (int) $categoryId : null
        );
    }

    /**
     * Final price after discount for this unit, if a rule exists.
     */
    public function getDiscountedPriceAttribute(): ?float
    {
        $discount = $this->discount_percentage;

        if (! is_null($discount) && $discount > 0) {
            $base = (float) $this->price;

            return round($base * (1 - $discount / 100), 2);
        }

        return null;
    }
}

