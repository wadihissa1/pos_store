@php
    $ws = $product->websiteSetting;
    $unit = $product->defaultUnit;
    $discount = $unit?->discount_percentage;
    $discountedPrice = $unit?->discounted_price;
@endphp
<a href="{{ route('products.show', $product) }}" class="product-card card">
    <div class="card-image product-card__image">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
        <div class="product-card__badge">
            @if($product->sellable_quantity > 0)
                <span class="tag is-success">In Stock</span>
            @else
                <span class="tag is-danger">Out of Stock</span>
            @endif
        </div>
        @if($ws)
            <div class="product-card__store-tags">
                @if($ws->is_featured)
                    <span class="tag is-warning is-light">Featured</span>
                @endif
                @if($ws->is_latest)
                    <span class="tag is-info is-light">Latest</span>
                @endif
                @if($ws->is_offer)
                    <span class="tag is-danger is-light">Offer</span>
                @endif
            </div>
        @endif
    </div>
    <div class="card-content">
        <p class="product-card__name">{{ $product->name }}</p>
        @if($ws && $ws->relationLoaded('websiteCategory') && $ws->websiteCategory)
            <p class="product-card__website-category subtitle is-7 mb-1">{{ $ws->websiteCategory->name }}</p>
        @endif
        @if($unit)
            @if(!is_null($discountedPrice) && $discountedPrice < $unit->price)
                <p class="product-card__price">
                    <span class="has-text-grey-light" style="text-decoration: line-through;">
                        ${{ number_format($unit->price, 2) }}
                    </span>
                    <span class="has-text-danger" style="margin-left: 0.35rem;">
                        ${{ number_format($discountedPrice, 2) }}
                    </span>
                </p>
                <p class="product-card__unit subtitle is-7">
                    {{ $unit->label }}
                    @if(!is_null($discount) && $discount > 0)
                        <span class="tag is-danger is-light" style="margin-left: 0.35rem;">
                            -{{ rtrim(rtrim(number_format($discount, 2), '0'), '.') }}%
                        </span>
                    @endif
                </p>
            @else
                <p class="product-card__price">
                    ${{ number_format($unit->price, 2) }}
                </p>
                <p class="product-card__unit subtitle is-7">{{ $unit->label }}</p>
            @endif
        @else
            <p class="product-card__price">${{ number_format($product->cost_price, 2) }}</p>
        @endif
    </div>
</a>
