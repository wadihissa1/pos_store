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
                <a class="navbar-item" href="{{ route('categories.index') }}">Categories</a>
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
                    <a class="button is-success is-rounded" href="https://wa.me/961XXXXXXXX" target="_blank" rel="noopener noreferrer">WhatsApp</a>
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
