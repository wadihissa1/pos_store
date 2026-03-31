<footer class="footer">
    <div class="container">
        <div class="columns is-multiline">
            <div class="column is-full-mobile is-half-tablet is-one-quarter-desktop">
                <a href="{{ route('home') }}" class="footer-brand-with-logo">
                    <img src="{{ asset('images/mezher_cosmetics_logo.jpg') }}" alt="" class="footer-logo-img">
                    <span class="footer-brand-text">Mezher Cosmetics</span>
                </a>
                <p class="is-size-7 has-text-grey mt-2">Quality cosmetics and beauty products. Browse, discover, order via WhatsApp.</p>
            </div>
            <div class="column is-full-mobile is-half-tablet is-one-quarter-desktop">
                <p class="has-text-weight-bold is-size-7 is-uppercase has-text-grey">Shop</p>
                <ul class="footer-links">
                    <li><a href="{{ route('products.index') }}">Products</a></li>
                    <li><a href="{{ route('collection.index') }}">Collection</a></li>
                    <li><a href="{{ route('offers.index') }}">Offers</a></li>
                </ul>
            </div>
            <div class="column is-full-mobile is-half-tablet is-one-quarter-desktop">
                <p class="has-text-weight-bold is-size-7 is-uppercase has-text-grey">Contact</p>
                <a href="{{ config('whatsapp.url') }}" class="footer-whatsapp" target="_blank" rel="noopener noreferrer">
                    <span class="icon is-small"><i class="fab fa-whatsapp"></i></span>
                    <span>Chat on WhatsApp</span>
                    @if(config('whatsapp.label'))
                        <span class="is-block is-size-7 has-text-grey mt-1">{{ config('whatsapp.label') }}</span>
                    @else
                        <span class="is-block is-size-7 has-text-grey mt-1">{{ config('whatsapp.phone') }}</span>
                    @endif
                </a>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="content has-text-centered">
            <p class="is-size-7 has-text-grey">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</footer>
