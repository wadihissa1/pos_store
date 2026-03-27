@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="container container--products">
        <section class="section section--compact-top animate-on-scroll">
            <div class="page-header page-header--offers mb-5">
                <h1 class="title is-3">Products</h1>
                <p class="subtitle is-6">Search and filter by category or brand.</p>
            </div>

            <form method="get" action="{{ route('products.index') }}" class="products-filters box mb-5">
                <div class="columns is-multiline is-mobile is-variable is-2">
                    <div class="column is-full-mobile is-full-tablet">
                        <div class="field">
                            <label class="label is-small" for="q">Search</label>
                            <div class="control has-icons-left">
                                <input type="text" id="q" name="q" class="input" placeholder="Product name or description..." value="{{ request('q') }}">
                                <span class="icon is-small is-left"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="column is-full-mobile is-half-tablet">
                        <div class="field">
                            <label class="label is-small" for="website_category">Category</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select id="website_category" name="website_category">
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
                    <div class="column is-full-mobile is-half-tablet">
                        <div class="field">
                            <label class="label is-small" for="brand">Brand</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select id="brand" name="brand">
                                        <option value="">All brands</option>
                                        @foreach($brands as $b)
                                            @php
                                                $brandValue = $b->slug ?: (string) $b->getKey();
                                            @endphp
                                            <option value="{{ $brandValue }}" {{ (string) request('brand') === (string) $brandValue ? 'selected' : '' }}>
                                                {{ $b->name }}
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
                    @if(request()->hasAny(['q', 'website_category', 'brand']))
                        <div class="control">
                            <a href="{{ route('products.index') }}" class="button is-light is-rounded">Clear</a>
                        </div>
                    @endif
                </div>
            </form>

        <div class="columns is-multiline is-mobile is-variable is-2">
            @foreach($products as $product)
                <div class="column is-half-mobile is-one-third-tablet is-one-quarter-desktop product-card-column">
                    @include('components.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>

            @if($products->isEmpty())
                <div class="box has-text-centered">
                    <p class="mb-3">No products match your search or filters.</p>
                    <a href="{{ route('products.index') }}" class="button is-link is-rounded">Clear filters</a>
                </div>
            @else
                {{ $products->links() }}
            @endif
        </section>
    </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.querySelector('.products-filters');
    var websiteCategory = document.getElementById('website_category');
    var brand = document.getElementById('brand');
    function submitForm() {
        if (form) form.submit();
    }
    if (form && websiteCategory) {
        websiteCategory.addEventListener('change', submitForm);
    }
    if (form && brand) {
        brand.addEventListener('change', submitForm);
    }
});
</script>
@endpush
@endsection
