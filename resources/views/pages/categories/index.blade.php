@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="container container--categories">
        <section class="section section--compact-top animate-on-scroll">
            <div class="page-header page-header--categories">
                <h1 class="title is-3">Shop by Category</h1>
                <p class="subtitle is-5">Browse our product categories to find what you need.</p>
            </div>

            <form method="get" action="{{ route('categories.index') }}" class="products-filters box mb-5 categories-filters">
                <div class="columns is-mobile is-variable is-2">
                    <div class="column is-full-mobile">
                        <div class="field">
                            <label class="label is-small" for="categories-q">Search categories</label>
                            <div class="control has-icons-left">
                                <input type="search" id="categories-q" name="q" class="input" placeholder="Category name..." value="{{ request('q') }}" autocomplete="off">
                                <span class="icon is-small is-left"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field is-grouped products-filters-actions">
                    <div class="control">
                        <button type="submit" class="button is-primary">Apply</button>
                    </div>
                    @if(request()->filled('q'))
                        <div class="control">
                            <a href="{{ route('categories.index') }}" class="button is-light">Clear</a>
                        </div>
                    @endif
                </div>
            </form>

            @if($categories->isEmpty())
                <div class="box has-text-centered">
                    <p class="mb-3">No categories match your search.</p>
                    <a href="{{ route('categories.index') }}" class="button is-link">Clear search</a>
                </div>
            @else
            <div class="category-grid">
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category) }}" class="category-grid-card">
                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" loading="lazy">
                        <div class="category-grid-card-overlay">
                            <span class="category-grid-card-name">{{ $category->name }}</span>
                            <span class="category-grid-card-count">{{ $category->products_count }} products</span>
                        </div>
                    </a>
                @endforeach
            </div>
            @endif
        </section>
    </div>
@endsection
