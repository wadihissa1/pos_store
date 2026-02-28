@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="container">
        <section class="section section--compact-top animate-on-scroll">
            <div class="page-header page-header--categories">
                <h1 class="title is-3">Shop by Category</h1>
                <p class="subtitle is-5">Browse our product categories to find what you need.</p>
            </div>

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
        </section>
    </div>
@endsection
