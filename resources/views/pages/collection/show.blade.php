@extends('layouts.app')

@section('title', $brand->name)

@section('content')
    <div class="category-page">
        <div class="category-banner">
            <img src="{{ $brand->image_url }}" alt="{{ $brand->name }}" class="category-banner__image">
            <div class="category-banner__overlay">
                <div class="container">
                    <nav class="breadcrumb breadcrumb--light" aria-label="breadcrumbs">
                        <ul>
                            <li><a href="{{ route('collection.index') }}">Collection</a></li>
                            <li class="is-active"><a href="#" aria-current="page">{{ $brand->name }}</a></li>
                        </ul>
                    </nav>
                    <h1 class="category-banner__title">{{ $brand->name }}</h1>
                    <p class="category-banner__count">{{ $products->total() }} {{ $products->total() === 1 ? 'product' : 'products' }}</p>
                </div>
            </div>
        </div>

        <div class="container container--categories-products">
            <section class="section section--compact-top animate-on-scroll">
                <form method="get" action="{{ route('collection.show', $brand) }}" class="products-filters box mb-5">
                    <div class="columns is-multiline is-mobile is-variable is-2">
                        <div class="column is-full-mobile is-half-tablet">
                            <div class="field">
                                <label class="label is-small" for="collection-q">Search</label>
                                <div class="control has-icons-left">
                                    <input type="search" id="collection-q" name="q" class="input" placeholder="Product name or description..." value="{{ request('q') }}" autocomplete="off">
                                    <span class="icon is-small is-left"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="column is-full-mobile is-half-tablet">
                            <div class="field">
                                <label class="label is-small" for="collection-website-category">Category</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select id="collection-website-category" name="website_category">
                                            <option value="">All categories</option>
                                            @foreach($websiteCategories as $wc)
                                                @php
                                                    $wcVal = $wc->slug ?? (string) $wc->getKey();
                                                @endphp
                                                <option value="{{ $wcVal }}" {{ (string) request('website_category') === (string) $wcVal ? 'selected' : '' }}>
                                                    {{ $wc->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field is-grouped products-filters-actions">
                        <div class="control">
                            <button type="submit" class="button is-primary is-rounded">Apply</button>
                        </div>
                        @if(request()->hasAny(['q', 'website_category']))
                            <div class="control">
                                <a href="{{ route('collection.show', $brand) }}" class="button is-light is-rounded">Clear</a>
                            </div>
                        @endif
                    </div>
                </form>

                <div class="columns is-multiline is-mobile is-variable is-2">
                    @forelse($products as $product)
                        <div class="column is-half-mobile is-one-third-tablet is-one-quarter-desktop product-card-column">
                            @include('components.product-card', ['product' => $product])
                        </div>
                    @empty
                        <div class="column is-full">
                            <div class="notification is-light has-text-centered">
                                @if(request()->hasAny(['q', 'website_category']))
                                    <p class="mb-3">No products match your search or category filter.</p>
                                    <a href="{{ route('collection.show', $brand) }}" class="button is-link is-rounded">Clear filters</a>
                                @else
                                    <p class="mb-3">No products for this brand yet.</p>
                                    <a href="{{ route('collection.index') }}" class="button is-link is-rounded">Browse collection</a>
                                @endif
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.querySelector('.container--categories-products .products-filters');
    var categorySelect = document.getElementById('collection-website-category');
    if (form && categorySelect) {
        categorySelect.addEventListener('change', function () {
            form.submit();
        });
    }
});
</script>
@endpush
@endsection
