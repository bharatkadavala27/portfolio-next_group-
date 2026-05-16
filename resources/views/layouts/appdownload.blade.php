<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NeXT-SOLUTION') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- jQuery must be loaded first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Owl Carousel -->
    <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/owl.theme.default.min.css') }}" rel="stylesheet">

    <!-- exzoom product image -->
    <link href="{{ asset('assets/exzoom/jquery.exzoom.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

    <!-- Alertify CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glider-js@1.7.4/glider.min.css">

    <!-- Apply Custom Font -->
    <style>
        @font-face {
            font-family: 'Poppins';
            src: url('/fonts/Poppins-Regular.woff2') format('woff2'),
                url('/fonts/Poppins-Regular.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('/fonts/Poppins-Bold.woff2') format('woff2'),
                url('/fonts/Poppins-Bold.woff') format('woff');
            font-weight: bold;
            font-style: normal;
        }

        /* Apply font to website */
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* body {
                font-family: 'Arial Rounded MT'!important, Arial, sans-serif;
            } */

        /* Custom scrollbar for webkit browsers (Chrome, Safari, etc.) */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        /* Custom scrollbar thumb (the draggable part) */
        ::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 0;
        }

        ::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            border-radius: 0;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        html,
        body {
            overflow: auto;
            /* Enable vertical scrolling */
            height: auto;
            /* Allow height to adjust based on content */
        }

        .carousel-inner,
        .owl-carousel {
            overflow: hidden;
            /* Prevent overflow in carousels */
        }

        #sticky-image {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform, position, top;

            backface-visibility: hidden;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 20px;
        }

        .product-page {
            opacity: 0;
            animation: fadeIn 0.3s ease-in forwards;
        }

        /* Update Product Image styles */
        .product-images img {
            /* transform: scale(1); Ensure the default scale is 1 */
            backface-visibility: hidden;
            /* Reduce flickering */
            will-change: transform;
            /* Optimize for animations */
            transition: transform 0.3s ease-in-out;
            /* Smooth transition */
        }

        .product-images img:hover {
            /* transform: scale(1.05); Slight zoom on hover */
        }

        /* Main Image styles */
        .main-image {
            width: 100%;
            height: 100%;
            object-fit: contain;

            backface-visibility: hidden;
            will-change: transform;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Thumbnail styles */
        .thumbnail {

            backface-visibility: hidden;
            will-change: transform;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .thumbnail:hover,
        .thumbnail:focus {
            transform: scale(1.05) translateZ(0);
        }

        /* Container styles */
        .main-image-container {

            backface-visibility: hidden;
            perspective: 1000px;
        }

        .btn {
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Loading states */
        .loading {
            position: relative;
            opacity: 0.7;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes loading {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        /* Image Zoom Preview Styles */
        .product-images {
            position: relative;
        }

        .zoom-preview {
            display: none;
            position: fixed;
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            pointer-events: none;
            width: 600px;
            height: 400px;
            overflow: hidden;
            z-index: 999999;
            border-radius: 8px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            transition: transform 0.1s ease, opacity 0.1s ease;
            /* Smooth transitions */
        }

        .zoom-preview img {
            position: absolute;
            max-width: none;
            transform-origin: top left;
            transition: transform 0.1s ease;
            /* Smooth zoom movement */
        }

        .product-images.zooming img {
            cursor: crosshair;
        }

        /* Ensure no other elements overlay the zoom preview */
        .modal-backdrop,
        .modal,
        .dropdown-menu,
        .tooltip,
        .popover {
            z-index: 999998 !important;
        }

        /* Product Image Slider Styles */
        .product-thumbnails {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
            padding: 0 50px;
            max-width: 100%;
            overflow: hidden;
        }

        .thumbs-wrapper {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
            flex: 1;
        }

        .thumbs-wrapper::-webkit-scrollbar {
            display: none;
        }

        .thumbnail-wrapper {
            width: 80px;
            height: 80px;
            flex-shrink: 0;
            overflow: hidden;
            border-radius: 4px;
        }

        .thumbnail {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .thumbnail.active {
            border-color: #0d6efd;
            box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.2);
        }

        .thumbnail:hover,
        .thumbnail:focus {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            outline: none;
        }

        .slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .slider-arrow:hover {
            background: #f8f9fa;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .slider-arrow i {
            color: #333;
            font-size: 16px;
        }

        .slider-prev {
            left: 5px;
        }

        .slider-next {
            right: 5px;
        }

        .main-image-container {
            width: 100%;
            max-width: 600px;
            aspect-ratio: 4 / 3;
            position: relative;
            overflow: hidden;
            background: #f8f9fa;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            transition: opacity 0.3s ease;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .main-image-container {
                max-width: 100%;
                aspect-ratio: 1 / 1;
            }

            .thumbnail-wrapper {
                width: 60px;
                height: 60px;
            }

            .slider-arrow {
                width: 30px;
                height: 30px;
            }

            .slider-arrow i {
                font-size: 14px;
            }

            .zoom-preview {
                width: 90vw;
                height: 50vh;
            }
        }

        /* Loading animations */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }

        .btn-loading::after {
            content: '';
            width: 1em;
            height: 1em;
            border: 2px solid #fff;
            border-radius: 50%;
            border-right-color: transparent;
            position: absolute;
            right: 1em;
            top: 50%;
            transform: translateY(-50%);
            animation: spin 0.8s linear infinite;
        }

        .zoom-preview-loading::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Collapsed description */
        .description-collapse {
            max-height: 100px;
            overflow: hidden;
            position: relative;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>

    <div id="app">

        @include('layouts.inc.frontend.navbar')

        <main>
            @yield('content')
        </main>

    </div>
    @include('layouts.inc.frontend.footer')

    <style>
        body,
        html {
            margin: 0;
            padding: 0;
        }

        html,
        body {
            overflow: auto;
            /* Enable vertical scrolling */
            height: auto;
            /* Allow height to adjust based on content */
        }

        .carousel-inner,
        .owl-carousel {
            overflow: hidden;
            /* Prevent overflow in carousels */
        }
    </style>

    <!-- Popper.js and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Glider.js -->
    <script src="https://cdn.jsdelivr.net/npm/glider-js@1.7.4/glider.min.js"></script>

    <script>
        window.addEventListener('message', event => {
            alertify.set('notifier', 'position', 'top-right');
            alertify.notify(event.detail.text, event.detail.type);
        });

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
            const stickyImage = document.getElementById('sticky-image');
            const productDetails = document.getElementById('product-details');
            const stickyWrapper = document.querySelector('.sticky-wrapper');

            const offsetTop = 20; // Distance from top when sticky
            const marginBottom = 0; // Space before stopping sticky effect

            function handleStickyImage() {
                const detailsRect = productDetails.getBoundingClientRect();
                const wrapperRect = stickyWrapper.getBoundingClientRect();
                const imageHeight = stickyImage.offsetHeight;

                requestAnimationFrame(() => {
                    if (detailsRect.top <= offsetTop && detailsRect.bottom >= (imageHeight + marginBottom)) {
                        stickyImage.style.position = 'fixed';
                        stickyImage.style.top = `${offsetTop}px`;
                        stickyImage.style.width = `${wrapperRect.width}px`;
                    } else if (detailsRect.bottom < (imageHeight + marginBottom)) {
                        stickyImage.style.position = 'absolute';
                        stickyImage.style.top = `${productDetails.offsetHeight - imageHeight}px`;
                    } else {
                        stickyImage.style.position = 'relative';
                        stickyImage.style.top = '0';
                    }
                });
            }

            // Throttle scroll event for better performance
            let ticking = false;
            window.addEventListener('scroll', () => {
                if (!ticking) {
                    requestAnimationFrame(() => {
                        handleStickyImage();
                        ticking = false;
                    });
                    ticking = true;
                }
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Lazy loading images
            const images = document.querySelectorAll('img[loading="lazy"]');
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    }
                });
            });

            images.forEach(img => imageObserver.observe(img));

            // Optimize scroll performance
            let scrollTimeout;
            window.addEventListener('scroll', () => {
                document.body.classList.add('is-scrolling');
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    document.body.classList.remove('is-scrolling');
                }, 150);
            }, { passive: true });

            // Image Slider and Zoom Preview
            const productImages = document.querySelector('.product-images');
            if (productImages) {
                // Create containers
                const mainImageContainer = document.createElement('div');
                mainImageContainer.className = 'main-image-container';

                const thumbnailsContainer = document.createElement('div');
                thumbnailsContainer.className = 'product-thumbnails';

                const thumbsWrapper = document.createElement('div');
                thumbsWrapper.className = 'thumbs-wrapper';
                thumbnailsContainer.appendChild(thumbsWrapper);

                // Create navigation buttons
                const prevBtn = document.createElement('button');
                prevBtn.className = 'slider-arrow slider-prev';
                prevBtn.setAttribute('aria-label', 'Previous Image');
                prevBtn.innerHTML = '<i class="fa fa-chevron-left"></i>';
                thumbnailsContainer.appendChild(prevBtn);

                const nextBtn = document.createElement('button');
                nextBtn.className = 'slider-arrow slider-next';
                nextBtn.setAttribute('aria-label', 'Next Image');
                nextBtn.innerHTML = '<i class="fa fa-chevron-right"></i>';
                thumbnailsContainer.appendChild(nextBtn);

                // Get all images and setup main image
                const images = Array.from(productImages.querySelectorAll('img'));
                if (images.length > 0) {
                    const mainImage = images[0].cloneNode(true);
                    mainImage.className = 'main-image';
                    mainImageContainer.appendChild(mainImage);

                    // Create thumbnails
                    images.forEach((img, index) => {
                        const thumbWrapper = document.createElement('div');
                        thumbWrapper.className = 'thumbnail-wrapper';
                        const thumb = img.cloneNode(true);
                        thumb.className = 'thumbnail';
                        if (index === 0) thumb.classList.add('active');

                        thumb.addEventListener('click', () => {
                            currentIndex = index;
                            showImage(currentIndex);
                            stopAutoSlide(); // Stop auto-slide on user interaction
                            startAutoSlide(); // Restart the timer
                        });

                        thumbWrapper.appendChild(thumb);
                        thumbsWrapper.appendChild(thumbWrapper);
                    });

                    // Auto slide functionality with preserved vertical scroll position
                    let currentIndex = 0;
                    const autoSlideDelay = 3000; // 3 seconds
                    let autoSlideInterval;

                    function showImage(index) {
                        const mainImage = document.querySelector('.main-image');
                        const scrollY = window.scrollY; // Preserve the current vertical scroll position
                        mainImage.src = images[index].src;
                        mainImage.style.opacity = '0';
                        setTimeout(() => {
                            mainImage.style.opacity = '1';
                        }, 50);
                        thumbsWrapper.querySelectorAll('.thumbnail').forEach((t, i) => {
                            t.classList.toggle('active', i === index);
                        });
                        const activeThumb = thumbsWrapper.querySelectorAll('.thumbnail')[index];
                        activeThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                        window.scrollTo(0, scrollY); // Restore the vertical scroll position
                    }

                    function startAutoSlide() {
                        autoSlideInterval = setInterval(() => {
                            currentIndex = (currentIndex + 1) % images.length;
                            showImage(currentIndex);
                        }, autoSlideDelay);
                    }

                    function stopAutoSlide() {
                        clearInterval(autoSlideInterval);
                    }

                    // Update click handlers to use showImage
                    images.forEach((img, index) => {
                        const thumb = thumbsWrapper.children[index].querySelector('.thumbnail');
                        thumb.addEventListener('click', () => {
                            currentIndex = index;
                            showImage(currentIndex);
                            stopAutoSlide(); // Stop auto-slide on user interaction
                            startAutoSlide(); // Restart the timer
                        });
                    });

                    // Update navigation button handlers
                    prevBtn.addEventListener('click', (e) => {
                        e.preventDefault(); // Prevent default button behavior
                        e.stopPropagation(); // Stop event propagation
                        thumbsWrapper.scrollBy({
                            left: -scrollAmount,
                            behavior: 'smooth'
                        });
                    });

                    nextBtn.addEventListener('click', (e) => {
                        e.preventDefault(); // Prevent default button behavior
                        e.stopPropagation(); // Stop event propagation
                        thumbsWrapper.scrollBy({
                            left: scrollAmount,
                            behavior: 'smooth'
                        });
                    });

                    // Ensure buttons do not cause focus-related scrolling
                    prevBtn.addEventListener('mousedown', (e) => e.preventDefault());
                    nextBtn.addEventListener('mousedown', (e) => e.preventDefault());

                    // Start auto-sliding
                    startAutoSlide();

                    // Pause auto-slide when hovering over the slider
                    mainImageContainer.addEventListener('mouseenter', stopAutoSlide);
                    thumbnailsContainer.addEventListener('mouseenter', stopAutoSlide);
                    mainImageContainer.addEventListener('mouseleave', startAutoSlide);
                    thumbnailsContainer.addEventListener('mouseleave', startAutoSlide);

                    // Slider navigation
                    let scrollAmount = 90; // Width of thumbnail + gap

                    prevBtn.addEventListener('click', () => {
                        thumbsWrapper.scrollBy({
                            left: -scrollAmount,
                            behavior: 'smooth'
                        });
                    });

                    nextBtn.addEventListener('click', () => {
                        thumbsWrapper.scrollBy({
                            left: scrollAmount,
                            behavior: 'smooth'
                        });
                    });
                }

                // Replace original content
                productImages.innerHTML = '';
                productImages.appendChild(mainImageContainer);
                productImages.appendChild(thumbnailsContainer);

                // Setup zoom preview
                if (images.length > 0) {
                    setupZoomPreview(mainImageContainer.querySelector('.main-image'));
                }
            }

            // Enhanced setupZoomPreview function
            function setupZoomPreview(img) {
                const zoomPreview = document.createElement('div');
                zoomPreview.className = 'zoom-preview';
                productImages.appendChild(zoomPreview);

                let previewImg;

                img.addEventListener('mouseenter', () => {
                    previewImg = document.createElement('img');
                    previewImg.src = img.src;
                    zoomPreview.innerHTML = '';
                    zoomPreview.appendChild(previewImg);
                    productImages.classList.add('zooming');
                    zoomPreview.style.display = 'block';
                    zoomPreview.style.opacity = '1';
                });

                img.addEventListener('mousemove', (e) => {
                    const rect = img.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    const xPercent = x / rect.width;
                    const yPercent = y / rect.height;

                    const scale = 2.5; // Zoom level
                    const naturalWidth = previewImg.naturalWidth;
                    const naturalHeight = previewImg.naturalHeight;

                    previewImg.style.width = `${naturalWidth * scale}px`;
                    previewImg.style.height = `${naturalHeight * scale}px`;

                    const moveX = Math.min(
                        Math.max((naturalWidth * scale - zoomPreview.offsetWidth) * xPercent, 0),
                        naturalWidth * scale - zoomPreview.offsetWidth
                    );
                    const moveY = Math.min(
                        Math.max((naturalHeight * scale - zoomPreview.offsetHeight) * yPercent, 0),
                        naturalHeight * scale - zoomPreview.offsetHeight
                    );

                    previewImg.style.transform = `translate(-${moveX}px, -${moveY}px)`;
                });

                img.addEventListener('mouseleave', () => {
                    zoomPreview.style.opacity = '0';
                    setTimeout(() => {
                        zoomPreview.style.display = 'none';
                        productImages.classList.remove('zooming');
                    }, 100); // Delay to allow fade-out effect
                });
            }

            // Touch swipe support for thumbnails
            const thumbnailsContainer = document.querySelector('.product-thumbnails');
            if (thumbnailsContainer) {
                let touchStartX = 0;
                let scrollLeft = 0;

                thumbnailsContainer.addEventListener('touchstart', (e) => {
                    touchStartX = e.touches[0].pageX - thumbnailsContainer.offsetLeft;
                    scrollLeft = thumbnailsContainer.scrollLeft;
                }, { passive: true });

                thumbnailsContainer.addEventListener('touchmove', (e) => {
                    const x = e.touches[0].pageX - thumbnailsContainer.offsetLeft;
                    const walk = (x - touchStartX) * 2;
                    thumbnailsContainer.scrollLeft = scrollLeft - walk;
                }, { passive: true });
            }

            // Add to cart interaction
            const addToCartBtn = document.getElementById('add-to-cart');
            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    addToCartBtn.classList.add('btn-loading');

                    // Simulate API call
                    setTimeout(() => {
                        addToCartBtn.classList.remove('btn-loading');
                        alertify.success('Product added to your list');
                    }, 800);
                });
            }

            // Apply debounced sticky handling
            const debouncedSticky = debounce(handleStickyImage, 150);
            window.addEventListener('resize', debouncedSticky);

            // Make thumbnails keyboard accessible
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.setAttribute('tabindex', '0');
                thumb.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        thumb.click();
                    }
                });
            });
        });

    </script>

    @yield('scripts')
    <script src="{{ asset('assets/exzoom/jquery.exzoom.js') }}"></script>

    @livewireScripts
    <livewire:styles />
    <livewire:scripts />

    @stack('script')

    <!-- Add this modal markup -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white no-hover-effect" id="categoryModalLabel">Categories</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
                        <ol class="breadcrumb" id="category-breadcrumb">
                            <li class="breadcrumb-item active no-hover-effect" aria-current="page">Home</li>
                        </ol>
                    </nav>
                    <div class="nav-categories-wrapper">
                        <div class="nav-categories-container" id="categories-container">
                            <!-- Categories will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
