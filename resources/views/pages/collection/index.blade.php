@extends('layouts.app')

@section('title', 'Collection')

@section('content')
    <div class="container container--categories">
        <section class="section section--compact-top animate-on-scroll">
            <div class="page-header page-header--categories">
                <h1 class="title is-3">Collection</h1>
                <p class="subtitle is-5">Browse all brands in our catalog.</p>
            </div>

            <form method="get" action="{{ route('collection.index') }}" class="products-filters box mb-5 categories-filters" id="collection-filter-form">
                <div class="columns is-mobile is-variable is-2">
                    <div class="column is-full-mobile is-half-tablet is-one-third-desktop">
                        <div class="field">
                            <label class="label is-small" for="collection-brand">Brand</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select id="collection-brand" name="brand">
                                        <option value="">All brands</option>
                                        @foreach($allBrands as $b)
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
                @if(request()->filled('brand'))
                    <div class="field is-grouped products-filters-actions">
                        <div class="control">
                            <a href="{{ route('collection.index') }}" class="button is-light is-rounded">Clear</a>
                        </div>
                    </div>
                @endif
            </form>

            @if($brands->isEmpty())
                <div class="box has-text-centered">
                    <p class="mb-3">No brands match this filter.</p>
                    <a href="{{ route('collection.index') }}" class="button is-link is-rounded">Show all brands</a>
                </div>
            @else
            <div class="category-grid">
                @foreach($brands as $brand)
                    @php
                        $brandDiscount = $brand->discount_percentage;
                    @endphp
                    <a href="{{ route('collection.show', $brand) }}" class="category-grid-card">
                        <img src="{{ $brand->image_url }}" alt="{{ $brand->name }}" loading="lazy">
                        <div class="category-grid-card-overlay">
                            <span class="category-grid-card-name">{{ $brand->name }}</span>
                            <span class="category-grid-card-count">{{ $brand->products_count }} products</span>
                            @if(!is_null($brandDiscount) && $brandDiscount > 0)
                                <span class="category-grid-card-sale tag is-danger is-light">
                                    -{{ rtrim(rtrim(number_format($brandDiscount, 2), '0'), '.') }}% sale
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            @endif
        </section>
    </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var select = document.getElementById('collection-brand');
    var form = document.getElementById('collection-filter-form');
    if (select && form) {
        select.addEventListener('change', function () {
            form.submit();
        });
    }
});
</script>
@endpush
@endsection
