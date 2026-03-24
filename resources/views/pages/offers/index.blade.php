@extends('layouts.app')

@section('title', 'Offers')

@section('content')
    <div class="container">
        <section class="section section--compact-top animate-on-scroll">
            <div class="page-header page-header--offers">
                <h1 class="title is-3">Offers</h1>
                <p class="subtitle is-6">Products with high availability (stock &gt; 50 units).</p>
            </div>

        <div class="columns is-multiline is-mobile">
            @foreach($products as $product)
                <div class="column is-half-mobile is-one-third-tablet is-one-quarter-desktop product-card-column">
                    @include('components.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>

        {{ $products->links() }}
        </section>
    </div>
@endsection
