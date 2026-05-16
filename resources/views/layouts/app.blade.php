<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@if(trim($__env->yieldContent('title'))){{ trim($__env->yieldContent('title')) }} | @endif{{ config('app.name', 'NeXT-SOLUTION') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    {{-- Using Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/exzoom/jquery.exzoom.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glider-js@1.7.4/glider.min.css"> --}}
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    
    @yield('page_css')


    <!-- <link href="{{ asset('assets/css/product.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('assets/css/index.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">


    
    <!-- Owl Carousel CSS (CDN only) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <!-- jQuery (CDN, before everything else) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Owl Carousel JS (CDN only) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>


    <style>
        @font-face {
            font-family: 'Poppins';
            src: url('/fonts/Poppins-Regular.woff2') format('woff2'),
                 url('/fonts/Poppins-Regular.woff') format('woff');
            font-weight: normal; font-style: normal;
        }
        @font-face {
            font-family: 'Poppins';
            src: url('/fonts/Poppins-Bold.woff2') format('woff2'),
                 url('/fonts/Poppins-Bold.woff') format('woff');
            font-weight: bold; font-style: normal;
        }
        body { font-family: 'Poppins', sans-serif; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background-color: #888; border-radius: 0; }
        ::-webkit-scrollbar-track { background-color: #f1f1f1; border-radius: 0; }
        ::-webkit-scrollbar-thumb:hover { background-color: #555; }
        html, body { overflow-x: hidden; height: auto; }
        .carousel-inner, .owl-carousel, .glider { overflow: hidden; }
        html { scroll-behavior: smooth; scroll-padding-top: 80px; } /* Adjust scroll-padding-top */
        .product-page { opacity: 0; animation: fadeIn 0.3s ease-in forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .btn { transition: all 0.2s ease; }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 4px 6px rgba(0,0,0,0.1); }

        /* --- CSS for JavaScript Sticky --- */
        .sticky-wrapper {
            position: relative;
        }
        #sticky-image {
            transition: transform 0.2s ease-out;
        }
        /* Exzoom image fit */
         .exzoom .exzoom_preview_img { max-width: 100; height: auto; object-fit: contain; }
         .exzoom .exzoom_nav .exzoom_nav_inner span img { object-fit: cover; }
         .exzoom .exzoom_zoom_outer { width: 100% !important; } /* Ensure zoom container fits */

    </style>

    @yield('preload') {{-- Section for preload links --}}

</head>
<body>
    <div id="app">
        @include('layouts.inc.frontend.navbar')

        <main>
            @yield('content')
        </main>

        @include('layouts.inc.frontend.footer')
    </div>


    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    {{-- ** IMPORTANT: Make sure jquery.exzoom.js is present in this path ** --}}
    <script src="{{ asset('assets/exzoom/jquery.exzoom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/glider-js@1.7.4/glider.min.js"></script> --}}
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
        <!-- Swiper JS -->
   <script src="//cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/swiper-bundle.min.js"></script>

    <!-- JavaScript -->
      <!--Uncomment this line-->
    <script src="//cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/script.js"></script>

    <script>
        // Debounce utility function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }


        

        document.addEventListener('DOMContentLoaded', function () {

            // --- START JAVASCRIPT STICKY LOGIC ---
            const stickyImage = document.getElementById('sticky-image');
            const productDetails = document.getElementById('product-details');
            const stickyWrapper = document.querySelector('.sticky-wrapper');

            // Only run if all elements exist on the page
            if (stickyImage && productDetails && stickyWrapper) {
                const offsetTop = 20;
                const marginBottom = 20;

                let lastScrollY = window.scrollY;
                let ticking = false;
                let currentTranslateY = 0;

                function handleStickyImage() {
                    if (!stickyImage || !productDetails || !stickyWrapper) return;

                    const detailsRect = productDetails.getBoundingClientRect();
                    const wrapperRect = stickyWrapper.getBoundingClientRect();
                    const imageHeight = stickyImage.offsetHeight;
                    const detailsHeight = productDetails.offsetHeight;

                    const scrollY = window.scrollY;
                    const wrapperTop = wrapperRect.top + scrollY;
                    const stickyStartPoint = wrapperTop - offsetTop;
                    const stickyEndPoint = wrapperTop + detailsHeight - (imageHeight + marginBottom);

                    if (scrollY >= stickyStartPoint && scrollY <= stickyEndPoint) {
                        // Calculate how far we've scrolled past the start point
                        const scrollPastStart = scrollY - stickyStartPoint;
                        currentTranslateY = scrollPastStart;

                        stickyImage.style.position = 'relative';
                        stickyImage.style.transform = `translateY(${currentTranslateY}px)`;
                        stickyImage.style.width = '100%';

                    } else if (scrollY > stickyEndPoint) {
                        // Lock at bottom position
                        currentTranslateY = detailsHeight - imageHeight - marginBottom;
                        stickyImage.style.transform = `translateY(${currentTranslateY}px)`;
                    } else {
                        // Reset to initial position
                        currentTranslateY = 0;
                        stickyImage.style.transform = 'translateY(0)';
                    }

                    lastScrollY = scrollY;
                }

                window.addEventListener('scroll', () => {
                    if (!ticking) {
                        window.requestAnimationFrame(() => {
                            handleStickyImage();
                            ticking = false;
                        });
                        ticking = true;
                    }
                }, { passive: true });

                window.addEventListener('resize', debounce(handleStickyImage, 100));

                // Initial calculation
                handleStickyImage();
                setTimeout(handleStickyImage, 300);
            }
            // --- END JAVASCRIPT STICKY LOGIC ---

            // Global Alertify Listener
            window.addEventListener('message', event => {
                if (event.detail && event.detail.text && event.detail.type) {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.notify(event.detail.text, event.detail.type);
                }
            });

            // General smooth scroll for internal hash links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    if (href && href.length > 1 && href.startsWith('#')) {
                        e.preventDefault();
                        const target = document.querySelector(href);
                        if (target) {
                            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    } else if (href === '#') {
                        e.preventDefault();
                    }
                });
            });

            // Scroll optimization visual cue (optional)
            let scrollTimeout;
            window.addEventListener('scroll', () => {
                document.body.classList.add('is-scrolling');
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    document.body.classList.remove('is-scrolling');
                }, 150);
            }, { passive: true });

         }); // End DOMContentLoaded
     </script>

     @stack('scripts') </body>
 </html>
