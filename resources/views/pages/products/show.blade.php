@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('products.index') }}">Products</a></li>
                <li class="is-active"><a href="#" aria-current="page">{{ $product->name }}</a></li>
            </ul>
        </nav>

        <div class="product-detail-grid animate-on-scroll">
            <div class="product-detail-image">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
            </div>
            <div class="product-detail-info">
                <h1 class="product-detail-title">{{ $product->name }}</h1>

                @if($product->category)
                    <p class="product-detail-meta">
                        <a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a>
                    </p>
                @endif

                @if($product->defaultUnit)
                    <p class="product-detail-unit">{{ $product->defaultUnit->label }}</p>
                    <p class="product-detail-price">${{ number_format($product->defaultUnit->price, 2) }}</p>
                    @if(isset($product->defaultUnit->multiplier))
                        <p class="product-detail-meta">Multiplier: {{ $product->defaultUnit->multiplier }}</p>
                    @endif
                    <p class="product-detail-stock">
                        @if($product->sellable_quantity > 0)
                            <span class="tag is-success">In Stock</span>
                            <span class="product-detail-stock-qty">({{ $product->sellable_quantity }} available)</span>
                        @else
                            <span class="tag is-danger">Out of Stock</span>
                        @endif
                    </p>
                @else
                    <p class="product-detail-price">${{ number_format($product->cost_price, 2) }}</p>
                    <p class="product-detail-stock">
                        @if($product->isInStock())
                            <span class="tag is-success">In Stock</span>
                        @else
                            <span class="tag is-danger">Out of Stock</span>
                        @endif
                    </p>
                @endif

                <form action="{{ route('cart.add') }}" method="post" class="product-detail-actions">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="field has-addons">
                        <div class="control">
                            <label for="quantity" class="is-sr-only">Quantity</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->isInStock() ? min($product->sellable_quantity ?: 999, 999) : 1 }}" class="input" style="width: 5rem;">
                        </div>
                        <div class="control">
                            <button type="submit" class="button is-primary" @if(!$product->isInStock()) disabled @endif>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </form>

                @if($product->description)
                    <hr class="product-detail-hr">
                    <h2 class="title is-5">Description</h2>
                    <p class="content product-detail-description">{{ $product->description }}</p>
                @endif

                @if($product->barcode)
                    <p class="product-detail-barcode">Barcode: {{ $product->barcode }}</p>
                @endif
            </div>
        </div>
    </div>
@endsection
