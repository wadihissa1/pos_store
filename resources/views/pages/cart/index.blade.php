@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <div class="container container--cart">
        <section class="section section--compact-top section--cart animate-on-scroll">
            <div class="page-header page-header--offers">
                <h1 class="title is-3">Your Cart</h1>
                <p class="subtitle is-6">Review your items and quantities below.</p>
            </div>

            @if(session('success'))
                <div class="notification is-success is-light mb-5">
                    {{ session('success') }}
                </div>
            @endif

            @if(empty($items))
                <div class="box has-text-centered">
                    <p class="mb-4">Your cart is empty.</p>
                    <a href="{{ route('products.index') }}" class="button is-primary">Browse Products</a>
                </div>
            @else
                <div class="cart-items">
                    @foreach($items as $item)
                        <div class="cart-item box">
                            <div class="cart-item__row cart-item__row--top">
                                <a href="{{ route('products.show', $item['product']) }}" class="cart-item__image-wrap">
                                    <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" class="cart-item__image">
                                </a>
                                <div class="cart-item__info">
                                    <a href="{{ route('products.show', $item['product']) }}" class="cart-item__name">
                                        {{ $item['product']->name }}
                                    </a>
                                    @if($item['product']->defaultUnit)
                                        <p class="cart-item__unit">{{ $item['product']->defaultUnit->label }}</p>
                                    @endif
                                </div>
                                <form action="{{ route('cart.remove', $item['product']) }}" method="post" class="cart-item__remove" onsubmit="return confirm('Remove from cart?');">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="button is-danger is-light is-small" aria-label="Remove">
                                        <span class="icon"><i class="fas fa-trash"></i></span>
                                    </button>
                                </form>
                            </div>
                            <div class="cart-item__row cart-item__row--bottom">
                                <form action="{{ route('cart.update') }}" method="post" class="cart-item__qty-form">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                    <div class="field has-addons">
                                        <div class="control">
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="999" class="input cart-item__qty-input">
                                        </div>
                                        <div class="control">
                                            <button type="submit" class="button is-light">Update</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="cart-item__subtotal">
                                    <p class="has-text-weight-semibold">${{ number_format($item['subtotal'], 2) }}</p>
                                    <p class="subtitle is-7">${{ number_format($item['price'], 2) }} each</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @php
                    $orderLines = collect($items)->map(fn ($item) => $item['product']->name . ' x ' . $item['quantity'])->implode("\n");
                    $whatsappMessage = "Hi! I'd like to place an order:\n\n" . $orderLines . "\n\nTotal: $" . number_format($total, 2);
                    $whatsappUrl = 'https://wa.me/96170604010?text=' . rawurlencode($whatsappMessage);
                @endphp
                <div class="cart-summary box has-background-light">
                    <div class="columns is-vcentered">
                        <div class="column">
                            <p class="title is-5 mb-0">Total: ${{ number_format($total, 2) }}</p>
                        </div>
                        <div class="column is-narrow">
                            <a href="{{ route('products.index') }}" class="button is-light mr-2">Continue Shopping</a>
                            <a href="{{ $whatsappUrl }}" class="button is-success is-medium" target="_blank" rel="noopener noreferrer">
                                <span class="icon"><i class="fab fa-whatsapp"></i></span>
                                <span>Send via WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>
@endsection
