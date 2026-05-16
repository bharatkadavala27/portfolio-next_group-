<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* Force headings to use default cursor and not be text-selectable */
        h2,
        .category-container h2,
        .authorised-brands h2,
        .youtube-container .container h2,
        .happy-customer-container h2 {
            cursor: default !important;
            /* show default arrow instead of I-beam */
            user-select: none;
            /* prevent text selection on hover */
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }



        /* Make the owl custom arrows visually bold */
        .custom-owl-prev,
        .custom-owl-next,
        .custom-owl-prev2,
        .custom-owl-next2 {
            font-weight: 900;
            /* bold */
            font-size: 28px !important;
            /* slightly larger for prominence */
            line-height: 1;
            /* keeps glyph centered */
            text-shadow: 0 1px 0 rgba(0, 0, 0, 0.25);
            /* gives the glyph visual thickness */
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* optional: if you want them even bolder-looking, use transform scale */
        .custom-owl-prev strong,
        .custom-owl-next strong {
            display: inline-block;
            transform: scale(1.05);
        }

        /* ensure center alignment inside the circular button */
        .custom-owl-prev,
        .custom-owl-next,
        .custom-owl-prev2,
        .custom-owl-next2 {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* General Styles */
        a:hover {
            text-decoration: none !important;
            border: none;
        }

        .mini-slider-shadow>img {
            aspect-ratio: 7 / 4;
            object-fit: contain;
        }

        /* Progress Bar Styles */
        .progress-bar {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.7);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .progress {
            height: 100%;
            background: #2561a8 !important;
            width: 0;
            transform-origin: center;
            animation: rotateProgress 3s linear infinite;
        }

        .progress-number {
            position: absolute;
            font-size: 18px;
            color: white;
            z-index: 11;
        }

        @keyframes rotateProgress {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .full-width-image {
            width: 100vw !important;
            object-fit: cover;
        }

        .owl-carousel .owl-nav button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5) !important;
            color: white !important;
            font-size: 24px !important;
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }

        .owl-carousel .owl-nav button.owl-prev {
            left: 200px;
            visibility: hidden;
        }

        .owl-carousel .owl-nav button.owl-next {
            right: 20px;
            visibility: hidden;
        }

        .container {
            text-align: center;
            width: 100%;
            max-width: 1400px !important;
            margin: 0 auto;
            padding: 0 20px !important;
        }

        h2 {
            margin-bottom: 10px;
        }

        /* Categories Section - Responsive Design */
        .category-container {
            width: 100%;
            padding: 40px 0;
            background: #f8f9fa;
            overflow: hidden;
            /* Prevent overflow issues */
        }

        .category-container h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 30px;
            letter-spacing: 1px;
            text-align: center;
        }

        .categories-wrapper {
            position: relative;
            padding: 0 40px;
            /* Adjusted padding for navigation buttons */
        }

        .category-item {
            flex: 0 0 auto;
            margin: 10px;
            /* Reduced margin for smaller screens */
            min-width: 160px;
            /* Base width for cards */
            width: 160px;
            height: 220px;
            padding: 15px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .category-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }

        .category-item:hover::before {
            left: 100%;
        }

        .category-item:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.15);
        }

        .icon-container {
            width: 100%;
            height: 140px;
            /* Adjusted height for better fit */
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .category-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }

        .category-item:hover .category-img {
            transform: scale(1.05);
            filter: brightness(1.1);
        }

        .category-name {
            font-size: 13px;
            font-weight: 600;
            line-height: 1.2;
            max-height: 2.4em;
            /* Limit to 2 lines */
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            white-space: normal;
        }

        /* Owl Carousel Navigation Styling */
        .categories-slider-ltr,
        .categories-slider-ltr-sub {
            padding: 0;
            overflow: hidden;
            /* Prevent overflow of cards */
        }

        .categories-slider-ltr .owl-nav,
        .categories-slider-ltr-sub .owl-nav {
            display: flex !important;
            justify-content: space-between;
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            pointer-events: none;
            z-index: 10;
        }

        .categories-slider-ltr .owl-nav button,
        .categories-slider-ltr-sub .owl-nav button {
            background: linear-gradient(135deg, #2561a8, #1e4d8a) !important;
            color: #fff !important;
            border-radius: 5%;
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: auto;
            box-shadow: 0 4px 12px rgba(37, 97, 168, 0.3);
            transition: all 0.3s ease;
        }

        .categories-slider-ltr .owl-nav button.owl-prev,
        .categories-slider-ltr-sub .owl-nav button.owl-prev {
            margin-left: 10px;
        }

        .categories-slider-ltr .owl-nav button.owl-next,
        .categories-slider-ltr-sub .owl-nav button.owl-next {
            margin-right: 10px;
        }

        .categories-slider-ltr .owl-dots,
        .categories-slider-ltr-sub .owl-dots {
            text-align: center;
            margin-top: 20px;
        }

        .categories-slider-ltr .owl-dots .owl-dot,
        .categories-slider-ltr-sub .owl-dots .owl-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #bdc3c7;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .categories-slider-ltr .owl-dots .owl-dot.active,
        .categories-slider-ltr-sub .owl-dots .owl-dot.active,
        .categories-slider-ltr .owl-dots .owl-dot:hover,
        .categories-slider-ltr-sub .owl-dots .owl-dot:hover {
            background: #2561a8;
            transform: scale(1.2);
        }

        /* Custom Navigation Arrows */
        .custom-owl-prev,
        .custom-owl-next,
        .custom-owl-prev2,
        .custom-owl-next2 {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 24px;
            color: #fff;
            background: #2561a8;
            border-radius: 5%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .custom-owl-prev,
        .custom-owl-prev2 {
            left: 0;
        }

        .custom-owl-next,
        .custom-owl-next2 {
            right: 0;
        }

        .custom-owl-prev:hover,
        .custom-owl-next:hover,
        .custom-owl-prev2:hover,
        .custom-owl-next2:hover {
            background: #1e4d8a;
        }

        /* Updated CSS for the brands slider */
        .authorised-brands .brands-slider {
            position: relative;
            width: 100%;
            height: 260px;
            overflow: hidden;
            padding: 30px 0;
            background: #2561a8;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .brands-slider.no-scroll {
            overflow: hidden;
            cursor: default;
        }

        .brands-track.scrolling {
            display: flex;
            animation: infiniteScroll 30s linear infinite;
            position: absolute;
            white-space: nowrap;
            will-change: transform;
            gap: 30px;
            padding: 0 15px;
            width: fit-content;
        }

        .brands-track.static {
            display: flex;
            justify-content: center;
            animation: none !important;
            position: relative;
            width: 100%;
            white-space: nowrap;
            gap: 30px;
            padding: 0 15px;
            transition: all 0.3s ease-in-out;
        }

        .brands-track.static .brand-item {
            margin: 10px;
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .brand-item.duplicate {
            transition: opacity 0.3s ease;
        }

        .brand-item {
            flex: 0 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 180px;
            height: 200px;
        }

        .brand-logo {
            width: 140px;
            height: 170px;
            object-fit: contain;
            border-radius: 12px;
            border: 4px solid #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .brand-logo:hover {
            transform: scale(1.1);
            box-shadow: 0px 4px 15px rgba(255, 255, 255, 0.6);
        }

        .brand-name {
            margin-top: 15px;
            width: 160px;
            font-size: 18px;
            font-weight: bold;
            color: white;
            text-align: center;
            white-space: normal;
            word-wrap: break-word;
        }

        .single-slider {
            max-width: 1400px;
            margin: 0 auto;
        }

        @keyframes infiniteScroll {
            0% {
                transform: translate3d(0, 0, 0);
            }

            100% {
                transform: translate3d(-50%, 0, 0);
            }
        }

        .brands-track.scrolling:hover {
            animation-play-state: paused;
        }

        /* Brand Slider Styles */
        :root {
            --card-w: 500px;
            --card-h: 280px;
            --gap: 20px;
        }

        .slider-wrap-brand {
            width: 90%;
            max-width: 1400px;
            margin: 30px auto;
            overflow: hidden;
            position: relative;
            padding: 30px 0;
            touch-action: pan-y;
        }

        .slider-rail-brand {
            display: flex;
            align-items: center;
            transition: transform 0.6s ease;
            will-change: transform;
            padding: 0 var(--gap);
        }

        /* make exactly 5 cards visible across the rail (responsive overrides below) */
        .card-brand {
            /* compute 5 columns: subtract gaps between (4 gaps) from 100% */
            flex: 0 0 calc((100% - (var(--gap) * 4)) / 5);
            height: 100%;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .15);
            transform: scale(0.85);
            opacity: 0.6;
            transition: transform 0.35s ease, opacity 0.35s ease, box-shadow 0.35s ease;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 1px solid rgba(118, 114, 114, 0.2);
        }


        .card-brand.active {
            transform: scale(1);
            opacity: 1;
            z-index: 2;
            box-shadow: 0 12px 28px rgba(0, 0, 0, .25);
        }

        .card-brand img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            background: #fff;
            border-radius: 10px;
        }

        .card-brand .brand-logo {
            width: 100%;
            /* take full width of container */
            aspect-ratio: 1000 / 600;
            /* keep 5:3 ratio */
            object-fit: cover;
            /* fit inside without cropping */
            background: #fff;
            /* optional: keep clean background */
            border-radius: 20px;
            /* optional: rounded corners */
            padding: 6px;
            /* optional: spacing inside */
        }

        .card-brand p {
            text-align: center;
            font-size: 15px;
            font-weight: 600;
            margin: 0;
            color: #222;
            background: #fff;
            height: 10%;
        }

        .arrow-brand {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 40px;
            color: #333;
            background: transparent;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            user-select: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: background 0.3s;
            z-index: 5;
        }

        .arrow-brand:hover {
            background: rgba(255, 255, 255, 0.95);
        }

        .arrow-brand.left-brand {
            left: 10px;
        }

        .arrow-brand.right-brand {
            right: 10px;
        }

        .mini-slider-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .mini-slider-shadow {
            display: inline-block;
            background-color: white;
            border-radius: 10px;
        }

        .mini-slider-image {
            background-color: white;
        }

        .card {
            height: 100%;
        }

        .card-body {
            height: 100%;
            overflow: hidden;
        }

        .col-md-4 {
            height: auto;
            overflow-x: auto;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .category-item {
            animation: fadeInUp 0.6s ease-out;
        }

        .category-item:nth-child(odd) {
            animation-delay: 0.1s;
        }

        .category-item:nth-child(even) {
            animation-delay: 0.2s;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1200px) {
            .category-container h2 {
                font-size: 2.2rem;
            }

            .category-item {
                min-width: 150px;
                width: 150px;
                height: 200px;
                margin: 8px;
            }

            .icon-container {
                height: 120px;
            }

            .category-name {
                font-size: 12px;
            }

            .authorised-brands .brands-slider {
                height: 240px;
                padding: 25px 0;
            }

            .brand-item {
                width: 160px;
                height: 180px;
            }

            .brand-logo {
                width: 120px;
                height: 150px;
            }

            .brand-name {
                width: 140px;
                font-size: 16px;
                margin-top: 12px;
            }

            .brands-track.scrolling {
                gap: 25px;
                animation: infiniteScroll 25s linear infinite;
            }

            :root {
                --card-w: 180px;
                --card-h: 230px;
                --gap: 16px;
            }
        }

        @media (max-width: 992px) {
            .category-container {
                padding: 30px 0;
            }

            .category-item {
                min-width: 140px;
                width: 140px;
                height: 180px;
                margin: 6px;
                padding: 12px;
            }

            .category-container h2 {
                font-size: 2rem;
            }

            .icon-container {
                height: 100px;
            }

            .category-name {
                font-size: 11px;
            }

            .categories-wrapper {
                padding: 0 30px;
            }

            .custom-owl-prev,
            .custom-owl-next,
            .custom-owl-prev2,
            .custom-owl-next2 {
                width: 35px;
                height: 35px;
                font-size: 20px;
            }

            .authorised-brands .brands-slider {
                height: 220px;
                padding: 20px 0;
            }

            .brand-item {
                width: 140px;
                height: 160px;
            }

            .brand-logo {
                width: 100px;
                height: 130px;
                border: 3px solid #fff;
            }

            .brand-name {
                width: 120px;
                font-size: 14px;
                margin-top: 10px;
            }

            .brands-track.scrolling {
                gap: 20px;
                animation: infiniteScroll 28s linear infinite;
            }

            :root {
                --card-w: 150px;
                --card-h: 200px;
                --gap: 12px;
            }

            .arrow-brand {
                width: 40px;
                height: 40px;
                font-size: 28px;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 15px !important;
            }

            .category-container {
                padding: 20px 0;
            }

            .category-item {
                min-width: 130px;
                width: 130px;
                height: 170px;
                margin: 5px;
                padding: 10px;
            }

            .category-container h2 {
                font-size: 1.8rem;
            }

            .icon-container {
                height: 90px;
            }

            .category-name {
                font-size: 10px;
                max-height: 2.4em;
            }

            .categories-wrapper {
                padding: 0 25px;
            }

            .custom-owl-prev,
            .custom-owl-next,
            .custom-owl-prev2,
            .custom-owl-next2 {
                width: 35px;
                height: 35px;
                font-size: 20px;
            }

            .authorised-brands .brands-slider {
                height: 200px;
                padding: 15px 0;
                border-radius: 8px;
            }

            .brand-item {
                width: 120px;
                height: 140px;
            }

            .brand-logo {
                width: 85px;
                height: 110px;
                border: 2px solid #fff;
                border-radius: 8px;
            }

            .brand-name {
                width: 100px;
                font-size: 12px;
                margin-top: 8px;
                line-height: 1.2;
            }

            .brands-track.scrolling {
                gap: 15px;
                padding: 0 10px;
                animation: infiniteScroll 32s linear infinite;
            }

            .brand-logo:hover {
                transform: scale(1.05);
            }

            :root {
                --card-w: 150px;
                --card-h: 200px;
                --gap: 12px;
            }
        }

        @media (max-width: 576px) {
            .category-container {
                padding: 15px 0;
            }

            .category-item {
                min-width: 120px;
                width: 120px;
                height: 160px;
                margin: 4px;
                padding: 8px;
            }

            .category-container h2 {
                font-size: 1.6rem;
                margin-bottom: 15px;
            }

            .icon-container {
                height: 80px;
            }

            .category-name {
                font-size: 9px;
                max-height: 2.2em;
            }

            .categories-wrapper {
                padding: 0 46px;
                margin: 0 10px;
            }

            .custom-owl-prev,
            .custom-owl-next,
            .custom-owl-prev2,
            .custom-owl-next2 {
                width: 30px;
                height: 30px;
                font-size: 18px;
            }

            .categories-slider-ltr .owl-dots,
            .categories-slider-ltr-sub .owl-dots {
                margin-top: 15px;
            }

            .categories-slider-ltr .owl-dots .owl-dot,
            .categories-slider-ltr-sub .owl-dots .owl-dot {
                width: 8px;
                height: 8px;
                margin: 0 4px;
            }

            .authorised-brands .brands-slider {
                height: 160px;
                padding: 10px 0;
                margin: 0 auto;
                border-radius: 0;
            }

            .brand-item {
                width: 90px;
                height: 124px;
            }

            .brand-logo {
                width: 70px;
                height: 90px;
                border: 2px solid #fff;
                border-radius: 6px;
            }

            .brand-name {
                width: 85px;
                font-size: 11px;
                margin-top: 6px;
                line-height: 1.1;
            }

            .brands-track.scrolling {
                gap: 12px;
                padding: 0 8px;
                animation: infiniteScroll 35s linear infinite;
            }

            /* Make brand slider show 1 card per view on small screens */
            .slider-rail-brand {
                justify-content: center;
                /* center the single card */
                padding: 0;
                /* remove side padding so card can use full width */
            }

            /* Make the visible card slightly narrower than full width so it's visually centered with breathing room */
            .card-brand {
                flex: 0 0 86% !important;
                max-width: 86% !important;
                margin: 0 7px;
            }

            /* Reduce rail padding and gaps on mobile to avoid horizontal overflow */
            .slider-rail-brand {
                padding: 0 6px;
                gap: 10px;
            }

            /* Smaller arrows and tuck them inside the rail on mobile */
            .arrow-brand {
                width: 38px;
                height: 38px;
                font-size: 26px;
                top: 50%;
                transform: translateY(-50%);
                background: rgba(255,255,255,0.95);
            }

            :root {
                --card-w: 130px;
                --card-h: 180px;
                --gap: 10px;
            }
        }

        @media (max-width: 400px) {
            .category-container {
                padding: 10px 0;
            }

            .category-item {
                min-width: 110px;
                width: 110px;
                height: 140px;
                margin: 3px;
                padding: 6px;
            }

            .category-container h2 {
                font-size: 1.4rem;
            }

            .icon-container {
                height: 70px;
            }

            .category-name {
                font-size: 8px;
            }

            .categories-wrapper {
                padding: 0 15px;
            }

            .custom-owl-prev,
            .custom-owl-next,
            .custom-owl-prev2,
            .custom-owl-next2 {
                width: 28px;
                height: 28px;
                font-size: 16px;
            }

            .authorised-brands .brands-slider {
                height: 140px;
                padding: 8px 0;
            }

            .brand-item {
                width: 85px;
                height: 105px;
            }

            .brand-logo {
                width: 60px;
                height: 75px;
                border: 1px solid #fff;
                border-radius: 4px;
            }

            .brand-name {
                width: 70px;
                font-size: 10px;
                margin-top: 5px;
                line-height: 1;
            }

            .brands-track.scrolling {
                gap: 10px;
                padding: 0 5px;
                animation: infiniteScroll 40s linear infinite;
            }

            /* Slightly narrower card on very small screens to maintain small side padding */
            .card-brand {
                flex: 0 0 92% !important;
                max-width: 92% !important;
                margin: 0 6px;
            }

            :root {
                --card-w: 130px;
                --card-h: 180px;
                --gap: 10px;
            }
        }
    </style>

    <div class="container-fluid p-0">
        
        <?php if(isset($sliders) && $sliders->count() > 0): ?>
            <div class="first-slider" style="position: relative;">
                <div class="container-fluid p-0">
                    <div id="main-slider" class="owl-carousel owl-theme" style="position: relative;">
                        <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sliderItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="item">
                                <div class="slider-image-container">
                                    <img src="<?php echo e(url('/uploads/slider/' . $sliderItem->image)); ?>"
                                        class="slider-image full-width-image" alt="Slider Image">
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        
        <?php if(isset($twoImageSliders) && $twoImageSliders->count() > 0): ?>
            <div class="mini-slider-container">
                <div class="container mt-5">
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <div id="two-image-slider-0" class="owl-carousel owl-theme">
                                <?php $__currentLoopData = $twoImageSliders->filter(function ($item, $index) {
                                    return $index % 2 == 0; }); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sliderItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="item mini-slider-wrapper">
                                        <div class="mini-slider-shadow">
                                            <img src="<?php echo e(url('uploads/two-image-slider/' . $sliderItem->image)); ?>"
                                                alt="<?php echo e($sliderItem->title); ?>" class="img-fluid mini-slider-image"
                                                style="width: 100vw;">
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div id="two-image-slider-1" class="owl-carousel owl-theme">
                                <?php $__currentLoopData = $twoImageSliders->filter(function ($item, $index) {
                                    return $index % 2 == 1; }); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sliderItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="item mini-slider-wrapper">
                                        <div class="mini-slider-shadow">
                                            <img src="<?php echo e(url('uploads/two-image-slider/' . $sliderItem->image)); ?>"
                                                alt="<?php echo e($sliderItem->title); ?>" class="img-fluid mini-slider-image"
                                                style="width: 100vw;">
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        
        <div class="category-container">
            <div class="container">
                <h2 class="text-center mb-2 mt-4 text-dark">Categories</h2>

                
                <div class="categories-wrapper position-relative">
                    <!-- Left Arrow -->
                    <div class="custom-owl-prev position-absolute start-0 top-50 translate-middle-y">
                        &#10094;
                    </div>

                    <!-- Categories Carousel -->
                    <div class="categories-slider-ltr owl-carousel owl-theme">
                        <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="category-item text-center">
                                <div class="icon-container">
                                    <a href="<?php echo e(route('category.main', ['id' => $cat->id])); ?>">
                                        <img src="<?php echo e(asset('uploads/category/' . $cat->image)); ?>" alt="<?php echo e($cat->name); ?>"
                                            class="category-img mt-4">
                                    </a>
                                </div>
                                <h5 class="category-name"><?php echo e($cat->name); ?></h5>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Right Arrow -->
                    <div class="custom-owl-next position-absolute end-0 top-50 translate-middle-y">
                        &#10095;
                    </div>
                </div>


                <h2 class="text-center mb-2 mt-4 text-dark">Sub Categories</h2>

                <!-- Subcategories Slider -->
                <div class="categories-wrapper position-relative mt-4">
                    <!-- Left Arrow -->
                    <div class="custom-owl-prev2 position-absolute start-0 top-50 translate-middle-y">
                        &#10094;
                    </div>

                    <!-- Subcategories Carousel -->
                    <div class="categories-slider-ltr-sub owl-carousel owl-theme">
                        <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="category-item text-center">
                                <div class="icon-container">
                                    <a href="<?php echo e(route('category.main', ['id' => $cat->id])); ?>">
                                        <?php if(!empty($cat->image) && file_exists(public_path('uploads/category/' . $cat->image))): ?>
                                            <img src="<?php echo e(asset('uploads/category/' . $cat->image)); ?>" alt="<?php echo e($cat->name); ?>"
                                                class="category-img mt-4">
                                        <?php else: ?>
                                            <span class="mt-4 d-block text-center text-muted">No Image</span>
                                        <?php endif; ?>
                                    </a>

                                </div>
                                <h5 class="category-name"><?php echo e($cat->name); ?></h5>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Right Arrow -->
                    <div class="custom-owl-next2 position-absolute end-0 top-50 translate-middle-y">
                        &#10095;
                    </div>
                </div>
            </div>


            
            <?php if(isset($secondSlider) && $secondSlider->count() > 0): ?>
                <div class="single-slider">
                    <div class="owl-carousel owl-theme mt-5">
                        <?php $__currentLoopData = $secondSlider; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sliderItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="item">
                                <?php if($sliderItem->image): ?>
                                    <img src="<?php echo e(url('/uploads/second-slider/' . $sliderItem->image)); ?>" alt="Image" class="w-100"
                                        style="height: 350px; object-fit:cover;">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>




            <h2><span>Authorized Brands</span></h2>


            <div class="slider-wrap-brand">
                <div class="arrow-brand left-brand" id="prev">&#10094;</div>
                <div class="arrow-brand right-brand" id="next">&#10095;</div>

                <?php
                    // Use the full brand list so the JS cloning creates a natural continuous loop
                    $brandsForSlider = $brand->values()->all();
                ?>

                <div class="slider-rail-brand" id="rail">
                    <?php $__currentLoopData = $brandsForSlider; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="card-brand">
                            <a href="<?php echo e(url('/brand/' . $b->id . '/products')); ?>">
                                <img src="<?php echo e(asset($b->image)); ?>" alt="<?php echo e($b->name); ?>" class="brand-logo">
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                </a>

            </div>


            
                            
                            
                            
                            



            
            <?php if(isset($minislider) && $minislider->count() > 0): ?>
                <div class="mini-slider-container">
                    <div class="container mt-5">
                        <div class="row g-4">
                            <div class="col-12 col-md-6">
                                <div id="mini-slider-0" class="owl-carousel owl-theme">
                                    <?php $__currentLoopData = $minislider->filter(function ($item, $index) {
                                        return $index % 2 == 0; }); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="item mini-slider-wrapper">
                                            <div class="mini-slider-shadow">
                                                <img src="<?php echo e(url('uploads/mini-slider/' . $image->image)); ?>" alt="Slider Image"
                                                    class="img-fluid mini-slider-image" style="width: 100vw;">
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div id="mini-slider-1" class="owl-carousel owl-theme">
                                    <?php $__currentLoopData = $minislider->filter(function ($item, $index) {
                                        return $index % 2 == 1; }); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="item mini-slider-wrapper">
                                            <div class="mini-slider-shadow">
                                                <img src="<?php echo e(url('uploads/mini-slider/' . $image->image)); ?>" alt="Slider Image"
                                                    class="img-fluid mini-slider-image" style="width: 100vw;">
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            
            <div class="youtube-container">
                <div class="container mt-5">
                    <?php if($videos->count() > 3): ?>
                        <div class="owl-carousel owl-theme video-slider">
                            <?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="item">
                                    <div class="card" style="width: 100%; height: auto;">
                                        <div class="ratio ratio-16x9">
                                            <?php echo $video->youtube_embed_code; ?>

                                        </div>
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <a href="#" target="_blank" class="text-danger"
                                                style="font-size: 1.5rem; text-decoration: none;">
                                                <i class="fab fa-youtube"></i>
                                            </a>
                                            <h5 class="card-title mb-0" style="font-size: 1rem;"><?php echo e($video->title); ?></h5>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="row justify-content-center">
                            <?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-4 mb-3">
                                    <div class="card" style="width: 100%; height: auto;">
                                        <div class="ratio ratio-16x9">
                                            <?php echo $video->youtube_embed_code; ?>

                                        </div>
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <a href="#" target="_blank" class="text-danger"
                                                style="font-size: 1.5rem; text-decoration: none;">
                                                <i class="fab fa-youtube"></i>
                                            </a>
                                            <h5 class="card-title mb-0" style="font-size: 1rem;"><?php echo e($video->title); ?></h5>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="happy-customer-container">
                <div class="container mt-1" id="customers">
                    <div class="row justify-content-center">
                        <h2 class="text-center mb-4">Our Happy Customers</h2>

                        <div class="col-md-4 mb-4 h-100">
                            <div class="card text-center">
                                <div class="card-body">
                                    <img src="<?php echo e(asset('uploads/customer.jpg')); ?>" alt="" class="rounded-circle"
                                        style="width: 120px; height: 120px;">
                                    <h5 class="card-title mt-3">Our Mission</h5>
                                    <p class="card-text">Vashi Integrated Solutions (Formerly Next Solution) has a very
                                        transparent business policy and we have been working with them for our electrical
                                        needs.</p>
                                    <b>Siddharth Shah - Reliance</b>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4 h-100">
                            <div class="card text-center">
                                <div class="card-body">
                                    <img src="<?php echo e(asset('uploads/c2.jpg')); ?>" class="rounded-circle"
                                        style="width: 120px; height: 120px;">
                                    <h5 class="card-title mt-3">Our Vision</h5>
                                    <p class="card-text">Vashi Integrated Solutions (Formerly Next Solution) is not just a
                                        vendor but a valued business partner. We are very happy to associate with Next
                                        Solution.</p>
                                    <b>Kiran Pawaskar - Sun Pharma</b>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4 h-100">
                            <div class="card text-center">
                                <div class="card-body">
                                    <img src="<?php echo e(asset('uploads/c3.jpg')); ?>" class="rounded-circle"
                                        style="width: 120px; height: 120px;">
                                    <h5 class="card-title mt-3">Our Values</h5>
                                    <p class="card-text">We are very much satisfied with Vashi Integrated Solutions
                                        (Formerly Next Solution) because of their swift service & commissioning of ABB
                                        Drives.</p>
                                    <b>Pradeep Pancholi - Swastik Techno Pack</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <script>
            $(document).ready(function () {
                // First Slider with Progress Bar
                $('#main-slider').owlCarousel({
                    loop: true,
                    margin: 0,
                    nav: false,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 3000,
                    autoplayHoverPause: false,
                    items: 1,
                    navText: ["<span class='prev'>&#10094;</span>", "<span class='next'>&#10095;</span>"],
                    onInitialized: addProgressBar,
                    onTranslate: resetProgressBar,
                    onTranslated: startProgressBar
                });

                function addProgressBar() {
                    var progressBar = $('<div class="progress-barr"><div class="progress"></div><div class="progress-number">3</div></div>');
                    $('#main-slider').append(progressBar);
                    startProgressBar();
                }

                function startProgressBar() {
                    $('.progress').css({
                        width: '100%',
                        transition: 'width 3000ms linear'
                    });
                    rotateProgressNumber();
                }

                function resetProgressBar() {
                    $('.progress').css({
                        width: 0,
                        transition: 'width 0s'
                    });
                    $('.progress-number').text('3');
                }

                function rotateProgressNumber() {
                    var number = 3;
                    var interval = setInterval(function () {
                        number--;
                        if (number <= 0) {
                            clearInterval(interval);
                        } else {
                            $('.progress-number').text(number);
                        }
                    }, 1000);
                }

                // Category Slider
                var owl1 = $(".categories-slider-ltr").owlCarousel({
                    loop: true,
                    margin: 15,
                    nav: false,
                    dots: false,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    autoplayHoverPause: true,
                    smartSpeed: 800,
                    responsive: {
                        0: { items: 1, margin: 10, nav: false, dots: false },
                        400: { items: 2, margin: 10, nav: false, dots: false },
                        460: { items: 3, margin: 10, nav: false, dots: false },
                        560: { items: 4, margin: 10, nav: false, dots: false },
                        760: { items: 5, margin: 12, nav: true, dots: false },
                        920: { items: 5, margin: 15, nav: true, dots: false },
                        1060: { items: 6, margin: 15, nav: true, dots: false },
                        1300: { items: 6, margin: 2, nav: true, dots: false },
                        1400: { items: 7, margin: 2, nav: true, dots: false },
                        1550: { items: 7, margin: 2, nav: true, dots: false },
                        1850: { items: 7, margin: 2, nav: true, dots: false },
                        1950: { items: 7, margin: 2, nav: true, dots: false },
                        2100: { items: 7, margin: 2, nav: true, dots: false },
                        // 2300: { items: 9, margin: 20, nav: true, dots: false },
                        // 2600: { items: 11, margin: 20, nav: true, dots: false }
                    },
                    onInitialized: function (event) {
                        $('.category-item').addClass('loaded');
                    },
                    onChanged: function (event) {
                        $('.category-item').removeClass('loaded');
                        setTimeout(function () {
                            $('.category-item').addClass('loaded');
                        }, 100);
                    }
                });

                // Subcategory Slider
                var owl2 = $(".categories-slider-ltr-sub").owlCarousel({
                    loop: true,
                    margin: 15,
                    nav: false,
                    dots: false,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    autoplayHoverPause: true,
                    smartSpeed: 800,
                    responsive: {
                        0: { items: 1, margin: 10, nav: false, dots: false },
                        400: { items: 2, margin: 10, nav: false, dots: false },
                        460: { items: 3, margin: 10, nav: false, dots: false },
                        560: { items: 4, margin: 10, nav: false, dots: false },
                        760: { items: 5, margin: 12, nav: true, dots: false },
                        920: { items: 5, margin: 15, nav: true, dots: false },
                        1060: { items: 6, margin: 15, nav: true, dots: false },
                        1300: { items: 6, margin: 2, nav: true, dots: false },
                        1400: { items: 7, margin: 2, nav: true, dots: false },
                        1550: { items: 7, margin: 2, nav: true, dots: false },
                        1850: { items: 7, margin: 2, nav: true, dots: false },
                        1950: { items: 7, margin: 2, nav: true, dots: false },
                        2100: { items: 7, margin: 2, nav: true, dots: false },
                        // 2300: { items: 9, margin: 20, nav: true, dots: false },
                        // 2600: { items: 11, margin: 20, nav: true, dots: false }
                    },
                    onInitialized: function (event) {
                        $('.category-item').addClass('loaded');
                    },
                    onChanged: function (event) {
                        $('.category-item').removeClass('loaded');
                        setTimeout(function () {
                            $('.category-item').addClass('loaded');
                        }, 100);
                    }
                });

                // Category slider arrows
                $(".custom-owl-prev").click(function () {
                    owl1.trigger('prev.owl.carousel');
                });
                $(".custom-owl-next").click(function () {
                    owl1.trigger('next.owl.carousel');
                });

                // Subcategory slider arrows
                $(".custom-owl-prev2").click(function () {
                    owl2.trigger('prev.owl.carousel');
                });
                $(".custom-owl-next2").click(function () {
                    owl2.trigger('next.owl.carousel');
                });

                // Touch/Swipe support for better mobile experience
                $('.categories-slider-ltr, .categories-slider-ltr-sub').on('touchstart', function (e) {
                    $(this).addClass('touching');
                });

                $('.categories-slider-ltr, .categories-slider-ltr-sub').on('touchend', function (e) {
                    $(this).removeClass('touching');
                });

                // Keyboard navigation support
                $('.categories-slider-ltr, .categories-slider-ltr-sub').on('keydown', function (e) {
                    if (e.keyCode === 37) { // Left arrow
                        $(this).trigger('prev.owl.carousel');
                    } else if (e.keyCode === 39) { // Right arrow
                        $(this).trigger('next.owl.carousel');
                    }
                });

                // Accessibility improvements
                $('.category-item').attr('tabindex', '0');
                $('.category-item').on('keydown', function (e) {
                    if (e.keyCode === 13 || e.keyCode === 32) { // Enter or Space
                        $(this).find('a')[0].click();
                    }
                });

                // Smooth scrolling for category links
                $('.category-item a').on('click', function (e) {
                    $(this).closest('.category-item').addClass('clicked');
                    setTimeout(function () {
                        // Navigation will proceed normally
                    }, 200);
                });

                // Handle window resize for dynamic adjustments
                $(window).on('resize', function () {
                    $('.categories-slider-ltr, .categories-slider-ltr-sub').trigger('refresh.owl.carousel');
                });

                // All other carousels (except main slider, category, and subcategory sliders)
                $(".owl-carousel").not("#main-slider, .categories-slider-ltr, .categories-slider-ltr-sub, .video-slider").owlCarousel({
                    loop: true,
                    margin: 10,
                    nav: false,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 3000,
                    responsive: {
                        0: { items: 1 },
                        600: { items: 1 },
                        1000: { items: 1 }
                    }
                });

                // Mini sliders
                $("#mini-slider-0, #mini-slider-1").owlCarousel({
                    loop: true,
                    margin: 15,
                    nav: false,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 3000,
                    autoplayHoverPause: true,
                    responsive: {
                        0: { items: 1 },
                        600: { items: 2 },
                        1000: { items: 2 }
                    }
                });

                // Video Slider
                $(".video-slider").owlCarousel({
                    loop: true,
                    margin: 15,
                    nav: false,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    autoplayHoverPause: true,
                    responsive: {
                        0: { items: 1 },
                        600: { items: 2 },
                        1000: { items: 3 }
                    }
                });
            });

            // Brand Slider (for Authorized Brands)
            document.addEventListener('DOMContentLoaded', function () {
                const rail = document.getElementById('rail');
                if (!rail) return;
                const originals = Array.from(rail.querySelectorAll('.card-brand'));
                const total = originals.length;

                if (total <= 1) {
                    originals[0]?.classList.add('active');
                    document.getElementById('prev').style.display = 'none';
                    document.getElementById('next').style.display = 'none';
                    return;
                }

                // ---- clone before (in correct order) ----
                for (let i = originals.length - 1; i >= 0; i--) {
                    rail.insertBefore(originals[i].cloneNode(true), rail.firstChild);
                }
                // ---- clone after (normal order) ----
                originals.forEach(c => rail.appendChild(c.cloneNode(true)));

                const allCards = Array.from(rail.querySelectorAll('.card-brand'));

                function stepWidth() {
                    const cw = allCards[0].offsetWidth;
                    const style = getComputedStyle(allCards[0]);
                    const gap = parseFloat(style.marginLeft) + parseFloat(style.marginRight);
                    return cw + (isNaN(gap) ? 0 : gap);
                }

                let step = stepWidth();
                let wrapWidth = rail.parentElement.clientWidth;

                function visibleCount() {
                    return Math.max(1, Math.floor(wrapWidth / step));
                }

                // Choose initial index so the ORIGINAL set appears on load (e.g. A B C)
                const vc = visibleCount();
                const startOriginalIndex = vc >= total ? Math.floor(total / 2) : 0;
                let current = total + startOriginalIndex; // allCards index (middle set)

                function centerCardByAllIndex(idx, animate = true) {
                    step = stepWidth();
                    wrapWidth = rail.parentElement.clientWidth;
                    const padLeft = parseFloat(getComputedStyle(rail).paddingLeft) || 0;

                    // Use the target card's actual position to compute precise centering
                    const card = allCards[idx];
                    const cardCenter = (card ? (card.offsetLeft + card.offsetWidth / 2) : (idx * step + step / 2 + padLeft));
                    const delta = cardCenter - (wrapWidth / 2);

                    if (!animate) {
                        // Disable ALL transitions on rail AND cards during snap-back
                        rail.style.transition = 'none';
                        allCards.forEach(c => c.style.transition = 'none');

                        rail.style.transform = `translateX(${-delta}px)`;

                        // Update active classes
                        allCards.forEach(c => c.classList.remove('active', 'left-card', 'right-card'));
                        const mid = allCards[idx];
                        if (mid) mid.classList.add('active');
                        if (allCards[idx - 1]) allCards[idx - 1].classList.add('left-card');
                        if (allCards[idx + 1]) allCards[idx + 1].classList.add('right-card');

                        // Force reflow to flush all style changes before re-enabling transitions
                        rail.getBoundingClientRect();

                        // Re-enable transitions on next frame
                        requestAnimationFrame(() => {
                            rail.style.transition = 'transform 0.6s cubic-bezier(.22,.9,.35,1)';
                            allCards.forEach(c => c.style.transition = '');
                        });
                    } else {
                        rail.style.transition = 'transform 0.6s cubic-bezier(.22,.9,.35,1)';
                        rail.style.transform = `translateX(${-delta}px)`;

                        allCards.forEach(c => c.classList.remove('active', 'left-card', 'right-card'));
                        const mid = allCards[idx];
                        if (mid) mid.classList.add('active');
                        if (allCards[idx - 1]) allCards[idx - 1].classList.add('left-card');
                        if (allCards[idx + 1]) allCards[idx + 1].classList.add('right-card');
                    }
                }

                // Single transitionend listener with guard to avoid bubbling from card transitions
                rail.addEventListener('transitionend', (e) => {
                    if (e.target !== rail) return;

                    if (current >= total * 2) {
                        current -= total;
                        centerCardByAllIndex(current, false);
                    } else if (current < total) {
                        current += total;
                        centerCardByAllIndex(current, false);
                    }
                });

                function goNext() {
                    current++;
                    centerCardByAllIndex(current, true);
                }
                function goPrev() {
                    current--;
                    centerCardByAllIndex(current, true);
                }

                // (duplicate transitionend listener removed — single guarded listener above handles snap-back)

                // autoplay + controls + touch
                let auto = null;
                function startAuto() { stopAuto(); auto = setInterval(goNext, 2500); }
                function stopAuto() { if (auto) clearInterval(auto); }

                document.getElementById('next').addEventListener('click', () => { stopAuto(); goNext(); startAuto(); });
                document.getElementById('prev').addEventListener('click', () => { stopAuto(); goPrev(); startAuto(); });

                // simple touch swipe
                let startX = 0, isDragging = false;
                const parent = rail.parentElement;
                parent.addEventListener('touchstart', e => { stopAuto(); startX = e.touches[0].clientX; isDragging = true; });
                parent.addEventListener('touchend', e => {
                    if (!isDragging) return;
                    const diff = e.changedTouches[0].clientX - startX;
                    if (Math.abs(diff) > 50) { if (diff > 0) goPrev(); else goNext(); }
                    isDragging = false;
                    startAuto();
                });

                window.addEventListener('resize', () => {
                    step = stepWidth();
                    wrapWidth = rail.parentElement.clientWidth;
                    centerCardByAllIndex(current, false);
                });

                // init
                centerCardByAllIndex(current, false);
                startAuto();
            });

        </script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2026 -BK\NEXT SOLUTION\FEBRUARY\28-02-2026\next-solutions new\resources\views/index.blade.php ENDPATH**/ ?>