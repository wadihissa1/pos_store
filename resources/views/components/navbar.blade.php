<nav class="navbar navbar--store is-white" role="navigation" aria-label="main navigation">
    <div class="navbar-sidebar-overlay" id="navbarOverlay" aria-hidden="true"></div>
    <div class="container">
        <div class="navbar-brand">
            <a class="navbar-item navbar-brand-with-logo" href="{{ route('home') }}">
                <img src="{{ asset('images/mezher_cosmetics_logo.jpg') }}" alt="" class="navbar-brand-logo-img">
                <span class="navbar-brand-text">Mezher Cosmetics</span>
            </a>
        </div>
        <div id="navbarMenu" class="navbar-menu navbar-sidebar">
            <div class="navbar-start">
                <a class="navbar-item" href="{{ route('home') }}">Home</a>
                <a class="navbar-item" href="{{ route('products.index') }}">Products</a>
                @if(isset($navWebsiteCategories) && $navWebsiteCategories->isNotEmpty())
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link navbar-link--categories" href="{{ route('products.index') }}">Categories</a>
                        <div class="navbar-dropdown">
                            @foreach($navWebsiteCategories as $wc)
                                @php
                                    $wcParam = $wc->slug ?? (string) $wc->getKey();
                                @endphp
                                <a class="navbar-item" href="{{ route('products.index', ['website_category' => $wcParam]) }}">{{ $wc->name }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
                <a class="navbar-item" href="{{ route('collection.index') }}">Collection</a>
                <a class="navbar-item" href="{{ route('offers.index') }}">Offers</a>
            </div>
            <div class="navbar-end">
                <a class="navbar-item is-hidden-mobile" href="{{ route('cart.index') }}">
                    <span class="icon">
                        <i class="fas fa-shopping-cart"></i>
                        @if(($cartCount ?? 0) > 0)
                            <span class="navbar-cart-badge">{{ $cartCount ?? 0 }}</span>
                        @endif
                    </span>
                    <span class="is-hidden-touch ml-2">Cart</span>
                </a>
                <div class="navbar-item">
                    <a class="button is-success is-rounded" href="{{ config('whatsapp.url') }}" target="_blank" rel="noopener noreferrer">WhatsApp</a>
                </div>
            </div>
        </div>
        <div class="navbar-mobile-right">
            <a class="navbar-cart-mobile is-hidden-desktop" href="{{ route('cart.index') }}" aria-label="Cart">
                <span class="icon">
                    <i class="fas fa-shopping-cart"></i>
                    @if(($cartCount ?? 0) > 0)
                        <span class="navbar-cart-badge">{{ $cartCount ?? 0 }}</span>
                    @endif
                </span>
            </a>
            <div class="navbar-burger-wrapper">
                <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var link = document.querySelector('.navbar-link--categories');
    if (!link) return;
    var mq = window.matchMedia('(max-width: 1023px)');
    function onCategoriesClick(e) {
        if (!mq.matches) return;
        e.preventDefault();
        var parent = link.closest('.navbar-item.has-dropdown');
        if (parent) parent.classList.toggle('is-active');
    }
    link.addEventListener('click', onCategoriesClick);
    mq.addEventListener('change', function () {
        var parent = link.closest('.navbar-item.has-dropdown');
        if (parent) parent.classList.remove('is-active');
    });
});
</script>
@endpush
