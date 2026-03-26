<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountRule extends Model
{
    protected $fillable = ['type', 'entity_id', 'percentage'];

    protected $casts = [
        'percentage' => 'decimal:2',
    ];

    public const TYPE_CATEGORY = 'category';
    public const TYPE_PRODUCT = 'product';
    public const TYPE_UNIT = 'unit';

    public static function types(): array
    {
        return [
            self::TYPE_CATEGORY => 'Category',
            self::TYPE_PRODUCT => 'Product',
            self::TYPE_UNIT => 'Unit',
        ];
    }

    public function getEntityNameAttribute(): ?string
    {
        if ($this->type === self::TYPE_CATEGORY) {
            return Category::find($this->entity_id)?->name;
        }

        if ($this->type === self::TYPE_PRODUCT) {
            return Product::find($this->entity_id)?->name;
        }

        if ($this->type === self::TYPE_UNIT) {
            $unit = ProductUnit::with('product')->find($this->entity_id);

            return $unit ? $unit->product->name . ' — ' . $unit->label : null;
        }

        return null;
    }

    /**
     * Get the applicable discount for a unit.
     * Priority: unit > product > category.
     */
    public static function getDiscountForUnit(int $unitId, int $productId, ?int $categoryId): ?float
    {
        $unitRule = static::where('type', self::TYPE_UNIT)
            ->where('entity_id', $unitId)
            ->first();

        if ($unitRule) {
            return (float) $unitRule->percentage;
        }

        $productRule = static::where('type', self::TYPE_PRODUCT)
            ->where('entity_id', $productId)
            ->first();

        if ($productRule) {
            return (float) $productRule->percentage;
        }

        if ($categoryId) {
            $categoryRule = static::where('type', self::TYPE_CATEGORY)
                ->where('entity_id', $categoryId)
                ->first();

            if ($categoryRule) {
                return (float) $categoryRule->percentage;
            }
        }

        return null;
    }

    /**
     * @deprecated Use getDiscountForUnit for unit-level. Kept for backward compatibility.
     */
    public static function getDiscountForProduct(int $productId, ?int $categoryId): ?float
    {
        $productRule = static::where('type', self::TYPE_PRODUCT)
            ->where('entity_id', $productId)
            ->first();

        if ($productRule) {
            return (float) $productRule->percentage;
        }

        if ($categoryId) {
            $categoryRule = static::where('type', self::TYPE_CATEGORY)
                ->where('entity_id', $categoryId)
                ->first();

            if ($categoryRule) {
                return (float) $categoryRule->percentage;
            }
        }

        return null;
    }
}

