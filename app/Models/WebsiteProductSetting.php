<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebsiteProductSetting extends Model
{
    protected $table = 'website_product_settings';

    protected $fillable = [
        'product_id',
        'website_category_id',
        'is_visible',
        'is_featured',
        'is_latest',
        'is_offer',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'website_category_id' => 'integer',
            'is_visible' => 'boolean',
            'is_featured' => 'boolean',
            'is_latest' => 'boolean',
            'is_offer' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function websiteCategory(): BelongsTo
    {
        return $this->belongsTo(WebsiteCategory::class);
    }
}
