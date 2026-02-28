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
        if ($this->relationLoaded('products') && $this->products->isNotEmpty()) {
            return $this->products->first()->image_url;
        }
        return 'https://picsum.photos/seed/' . ($this->id ?? 1) . '/600/400';
    }
}
