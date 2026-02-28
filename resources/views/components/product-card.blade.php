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
    </div>
    <div class="card-content">
        <p class="product-card__name">{{ $product->name }}</p>
        @if($product->defaultUnit)
            <p class="product-card__price">${{ number_format($product->defaultUnit->price, 2) }}</p>
            <p class="product-card__unit subtitle is-7">{{ $product->defaultUnit->label }}</p>
        @else
            <p class="product-card__price">${{ number_format($product->cost_price, 2) }}</p>
        @endif
    </div>
</a>
