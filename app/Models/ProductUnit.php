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
}
