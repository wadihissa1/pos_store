@extends('layouts.app')

@section('title', $category->name)

@section('content')
    <div class="category-page">
        <div class="category-banner">
            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="category-banner__image">
            <div class="category-banner__overlay">
                <div class="container">
                    <nav class="breadcrumb breadcrumb--light" aria-label="breadcrumbs">
                        <ul>
                            <li><a href="{{ route('categories.index') }}">Categories</a></li>
                            <li class="is-active"><a href="#" aria-current="page">{{ $category->name }}</a></li>
                        </ul>
                    </nav>
                    <h1 class="category-banner__title">{{ $category->name }}</h1>
                    <p class="category-banner__count">{{ $category->products_count }} products</p>
                </div>
            </div>
        </div>

        <div class="container container--categories-products">
            <section class="section animate-on-scroll">
                <div class="columns is-multiline is-mobile is-variable is-2">
                    @forelse($products as $product)
                        <div class="column is-half-mobile is-one-third-tablet is-one-quarter-desktop product-card-column">
                            @include('components.product-card', ['product' => $product])
                        </div>
                    @empty
                        <div class="column is-full">
                            <div class="notification is-light has-text-centered">
                                <p class="mb-3">No products in this category yet.</p>
                                <a href="{{ route('categories.index') }}" class="button is-link">Browse all categories</a>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if($products->hasPages())
                    {{ $products->links() }}
                @endif
            </section>
        </div>
    </div>
@endsection
