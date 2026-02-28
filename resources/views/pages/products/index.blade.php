@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="container">
        <section class="section section--compact-top animate-on-scroll">
            <div class="page-header page-header--offers mb-5">
                <h1 class="title is-3">Products</h1>
                <p class="subtitle is-6">Search and filter our catalog.</p>
            </div>

            <form method="get" action="{{ route('products.index') }}" class="products-filters box mb-5">
                <div class="columns is-mobile is-variable is-2">
                    <div class="column is-full-mobile is-two-thirds-tablet">
                        <div class="field">
                            <label class="label is-small" for="q">Search</label>
                            <div class="control has-icons-left">
                                <input type="text" id="q" name="q" class="input" placeholder="Product name or description..." value="{{ request('q') }}">
                                <span class="icon is-small is-left"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="column is-full-mobile is-one-third-tablet">
                        <div class="field">
                            <label class="label is-small" for="category">Category</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select id="category" name="category">
                                        <option value="">All categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
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
                        <button type="submit" class="button is-primary">Apply</button>
                    </div>
                    @if(request()->hasAny(['q', 'category']))
                        <div class="control">
                            <a href="{{ route('products.index') }}" class="button is-light">Clear</a>
                        </div>
                    @endif
                </div>
            </form>

        <div class="columns is-multiline is-mobile">
            @foreach($products as $product)
                <div class="column is-half-mobile is-one-third-tablet is-one-quarter-desktop product-card-column">
                    @include('components.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>

            @if($products->isEmpty())
                <div class="box has-text-centered">
                    <p class="mb-3">No products match your search or filters.</p>
                    <a href="{{ route('products.index') }}" class="button is-link">Clear filters</a>
                </div>
            @else
                <nav class="pagination is-centered mt-5" role="navigation">
                    {{ $products->links() }}
                </nav>
            @endif
        </section>
    </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.querySelector('.products-filters');
    var categorySelect = document.getElementById('category');
    if (form && categorySelect) {
        categorySelect.addEventListener('change', function () {
            form.submit();
        });
    }
});
</script>
@endpush
@endsection
