<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @stack('styles')
</head>
<body>
    @include('components.navbar')

    <main class="section" role="main">
        @yield('content')
    </main>

    @include('components.footer')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var burger = document.querySelector('.navbar-burger');
            var menu = document.getElementById('navbarMenu');
            var overlay = document.getElementById('navbarOverlay');
            function toggleSidebar() {
                burger.classList.toggle('is-active');
                menu.classList.toggle('is-active');
                if (overlay) overlay.classList.toggle('is-active');
                document.body.classList.toggle('has-navbar-sidebar-open');
            }
            if (burger && menu) {
                burger.addEventListener('click', toggleSidebar);
                if (overlay) overlay.addEventListener('click', toggleSidebar);
            }

            // Scroll-triggered animations
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-in-view');
                    }
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

            document.querySelectorAll('.animate-on-scroll').forEach(function (el) {
                observer.observe(el);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
