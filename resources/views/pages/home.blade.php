@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section class="hero is-medium has-background-light hero--compact animate-on-scroll">
        <div class="hero-body">
            <div class="container container--home">
                <div class="columns is-vcentered is-variable is-5 hero-columns">
                    <div class="column is-half-desktop hero-column hero-column--text">
                        <h1 class="title is-2 has-text-weight-bold hero-title">
                            Care &amp; Beauty, <span class="has-text-primary">Curated for You</span>
                        </h1>
                        <p class="subtitle is-5 mt-4 hero-subtitle">Quality products, easy ordering. Browse our catalog or reach us on WhatsApp for a smooth experience.</p>
                        <div class="buttons mt-4 hero-actions">
                            <a href="{{ route('products.index') }}" class="button is-primary is-medium">Browse Products</a>
                            <a href="https://wa.me/96170604010" class="button is-success is-outlined is-medium" target="_blank" rel="noopener noreferrer">Contact via WhatsApp</a>
                        </div>
                    </div>
                    <div class="column is-half-desktop hero-column hero-column--visual">
                        <figure class="image hero-figure">
                            <img src="{{ asset('images/hero_section.jpeg') }}" alt="Mezher Cosmetics" decoding="async" fetchpriority="high">
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container container--home">
        <section class="section section--products-bg animate-on-scroll">
            <h2 class="title is-4 mb-5">Latest Products</h2>
            <div class="columns is-multiline is-mobile">
                @foreach($latestProducts as $product)
                    <div class="column is-half-mobile is-one-quarter-tablet product-card-column">
                        @include('components.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
            <p class="has-text-centered mt-5"><a href="{{ route('products.index') }}" class="button is-link">View all products</a></p>
        </section>

        <section class="section section--categories">
            <h2 class="title is-4 mb-5">Categories</h2>
            <div class="category-carousel-wrap">
                <div class="category-carousel">
            <button type="button" class="carousel-arrow carousel-arrow--prev" aria-label="Previous categories">
                <i class="fas fa-chevron-left" aria-hidden="true"></i>
            </button>
            <div class="carousel-viewport">
                <div class="carousel-track" id="categoryCarouselTrack">
                    @foreach($categories as $category)
                        <a href="{{ route('categories.show', $category) }}" class="category-card">
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" loading="lazy">
                            <div class="category-card-overlay">
                                <span class="category-card-name">{{ $category->name }}</span>
                                <span class="category-card-count">{{ $category->products_count }} products</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            <button type="button" class="carousel-arrow carousel-arrow--next" aria-label="Next categories">
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
            </button>
                </div>
            </div>
            <p class="has-text-centered mt-5"><a href="{{ route('categories.index') }}" class="button is-primary">View all categories</a></p>
        </section>
    </div>

    <section class="section has-background-success animate-on-scroll section--home-cta">
        <div class="container container--home has-text-centered">
            <h2 class="title is-3 has-text-white">Order Easily via WhatsApp</h2>
            <p class="subtitle is-5 has-text-white mb-5">Get in touch and we'll help you place your order.</p>
            <a href="https://wa.me/96170604010" class="button is-large is-white" target="_blank" rel="noopener noreferrer">Chat on WhatsApp</a>
            <p class="has-text-white mt-4 is-size-7">We typically reply within minutes.</p>
        </div>
    </section>

    <div class="container container--home">
        <section class="section has-background-white-bis animate-on-scroll">
            <h2 class="title is-4 mb-5">Featured Products</h2>
            <div class="columns is-multiline is-mobile">
                @foreach($featuredProducts ?? [] as $product)
                    <div class="column is-full-mobile is-half-tablet is-one-quarter-desktop product-card-column">
                        @include('components.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </section>

        <section class="section animate-on-scroll">
            <h2 class="title is-4 has-text-centered mb-5">Why Choose Us</h2>
            <div class="columns is-multiline">
                <div class="column is-full-mobile is-half-tablet is-one-quarter-desktop has-text-centered">
                    <span class="icon is-large has-text-primary"><i class="fas fa-truck fa-2x" aria-hidden="true"></i></span>
                    <h3 class="title is-5 mt-3">Fast Delivery</h3>
                    <p class="subtitle is-6">Quick and reliable delivery to your door.</p>
                </div>
                <div class="column is-full-mobile is-half-tablet is-one-quarter-desktop has-text-centered">
                    <span class="icon is-large has-text-primary"><i class="fas fa-shield-alt fa-2x" aria-hidden="true"></i></span>
                    <h3 class="title is-5 mt-3">Quality Assured</h3>
                    <p class="subtitle is-6">We source only the best products for you.</p>
                </div>
                <div class="column is-full-mobile is-half-tablet is-one-quarter-desktop has-text-centered">
                    <span class="icon is-large has-text-primary"><i class="fas fa-headset fa-2x" aria-hidden="true"></i></span>
                    <h3 class="title is-5 mt-3">Support</h3>
                    <p class="subtitle is-6">Friendly support when you need it.</p>
                </div>
                <div class="column is-full-mobile is-half-tablet is-one-quarter-desktop has-text-centered">
                    <span class="icon is-large has-text-primary"><i class="fas fa-tag fa-2x" aria-hidden="true"></i></span>
                    <h3 class="title is-5 mt-3">Great Offers</h3>
                    <p class="subtitle is-6">Regular deals and special prices.</p>
                </div>
            </div>
        </section>
    </div>

    <section class="section has-background-light animate-on-scroll section--home-cta">
        <div class="container container--home has-text-centered">
            <h2 class="title is-4">Check Our Latest Offers</h2>
            <p class="subtitle is-6 mb-5">Don't miss out on special prices and promotions.</p>
            <a href="{{ route('offers.index') }}" class="button is-warning is-medium">View Offers</a>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var track = document.getElementById('categoryCarouselTrack');
    var carousel = track ? track.closest('.category-carousel') : null;
    var prevBtn = carousel ? carousel.querySelector('.carousel-arrow--prev') : null;
    var nextBtn = carousel ? carousel.querySelector('.carousel-arrow--next') : null;
    var cards = track ? track.querySelectorAll('.category-card') : [];
    if (!track || !prevBtn || !nextBtn || cards.length === 0) return;
    var viewport = track.closest('.carousel-viewport');
    var gap = 16;
    var cardsPerPage = 3;
    var totalPages = Math.ceil(cards.length / cardsPerPage);
    var currentPage = 0;

    function getCardsPerPage() {
        return window.innerWidth < 769 ? 1 : window.innerWidth < 1024 ? 2 : 3;
    }

    function measureViewportWidth() {
        var w = viewport.offsetWidth || viewport.clientWidth || 0;
        if (w >= 32) {
            return w;
        }
        var rect = carousel.getBoundingClientRect();
        var gapPx = 12;
        try {
            gapPx = parseFloat(window.getComputedStyle(carousel).gap) || 12;
        } catch (e) {}
        var aw = (prevBtn && prevBtn.offsetWidth) ? prevBtn.offsetWidth : 40;
        var bw = (nextBtn && nextBtn.offsetWidth) ? nextBtn.offsetWidth : 40;
        var estimated = rect.width - aw - bw - 2 * gapPx;
        if (estimated >= 32) {
            return estimated;
        }
        return Math.max(160, Math.min(window.innerWidth - 40, window.innerWidth * 0.78));
    }

    function updateCarousel() {
        if (!viewport) return;
        var viewportWidth = measureViewportWidth();
        cardsPerPage = getCardsPerPage();
        totalPages = Math.max(1, Math.ceil(cards.length / cardsPerPage));
        currentPage = Math.min(currentPage, totalPages - 1);

        var cardWidth = (viewportWidth - (cardsPerPage - 1) * gap) / cardsPerPage;

        track.style.width = (cards.length * cardWidth + (cards.length - 1) * gap) + 'px';
        cards.forEach(function (card) {
            card.style.width = cardWidth + 'px';
            card.style.flexShrink = '0';
        });

        var offsetPx = -currentPage * cardsPerPage * (cardWidth + gap);
        track.style.transform = 'translateX(' + offsetPx + 'px)';

        prevBtn.disabled = currentPage === 0;
        nextBtn.disabled = currentPage >= totalPages - 1;
        carousel.classList.toggle('carousel--single-page', totalPages <= 1);
    }

    function scheduleUpdate() {
        requestAnimationFrame(function () {
            updateCarousel();
        });
    }

    prevBtn.addEventListener('click', function () {
        if (currentPage > 0) {
            currentPage--;
            updateCarousel();
        }
    });

    nextBtn.addEventListener('click', function () {
        if (currentPage < totalPages - 1) {
            currentPage++;
            updateCarousel();
        }
    });

    window.addEventListener('resize', scheduleUpdate);

    if (viewport && typeof ResizeObserver !== 'undefined') {
        var ro = new ResizeObserver(function () {
            scheduleUpdate();
        });
        ro.observe(viewport);
    }

    scheduleUpdate();
    window.addEventListener('load', scheduleUpdate);
    [0, 100, 300, 600].forEach(function (ms) {
        setTimeout(scheduleUpdate, ms);
    });
});
</script>
@endpush
