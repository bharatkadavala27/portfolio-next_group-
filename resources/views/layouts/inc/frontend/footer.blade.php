<!-- Professional Mobile Responsive Footer -->
<div class="container-fluid container-footer mt-4">
    <footer class="professional-footer">
        <div class="footer-container">
            <!-- Main Footer Content -->
            <div class="footer-content">
                <!-- Company Info Section -->
                <div class="footer-column company-column">
                    <div class="company-info">
                        <div class="logo-container">
                            <img src="{{ asset('assets/logoF.jpg') }}" class="footer-logo" alt="NeXT Solution">
                        </div>
                        <div class="company-description">
                            <p>Founded in 2013, "NeXT SOLUTION" is an ISO-certified company based in Rajkot, Gujarat,
                                providing innovative electrical and automation solutions.</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Links Section -->
                <div class="footer-column">
                    <div class="footer-section">
                        <h6 class="footer-title">Quick Links</h6>
                        <ul class="footer-links">
                            <li><a href="/">Home</a></li>
                            <li><a href="/about-us">About Us</a></li>
                            <li><a href="/contact-us">Contact Us</a></li>
                            <li><a href="/news">News</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Top Categories Section -->
                <div class="footer-column">
                    <div class="footer-section">
                        <h6 class="footer-title">Top Categories</h6>
                        <ul class="footer-links">
                            @if ($footerCategories->isEmpty())
                                <li>No categories available.</li>
                            @else
                                @foreach ($footerCategories as $categoryItem)
                                    <li>
                                        <a href="{{ url('/category/' . $categoryItem->id) }}">
                                            {{ $categoryItem->name }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Top Brands Section -->
                <div class="footer-column">
                    <div class="footer-section">
                        <h6 class="footer-title">Top Brands</h6>
                        <ul class="footer-links">
                            @if ($footerBrands->isEmpty())
                                <li>No brands available.</li>
                            @else
                                @foreach ($footerBrands as $brand)
                                    <li>
                                        <a href="{{ url('/brand/' . $brand->slug) }}">
                                            {{ $brand->name }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="footer-column contact-column">
                    <div class="footer-section">
                        <h6 class="footer-title">Get In Touch</h6>
                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt contact-icon"></i>
                                <div class="contact-text">
                                    <strong>Address:</strong><br>
                                    Maruti Industrial Area, Ramwadi 2,<br>
                                    Rolex Road, Near Maldhari Railway Crossing,<br>
                                    Rajkot-4, Gujarat, India
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-envelope contact-icon"></i>
                                <div class="contact-text">
                                    <strong>Email:</strong><br>
                                    <a href="mailto:support@nextgroup.in">support@nextgroup.in</a>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-phone contact-icon"></i>
                                <div class="contact-text">
                                    <strong>Phone:</strong><br>
                                    <a href="tel:+918200501951">+91 82005 01951</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom Section -->
            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <div class="copyright-section">
                        <p>&copy; <span class="cYear">2024</span> All rights reserved. Design & Developed by
                            <a href="https://www.fuertedevelopers.in/" target="_blank" class="developer-link">
                                <strong>Fuerte Developers</strong>
                            </a>
                        </p>
                    </div>
                    <div class="social-section">
                        <div class="social-links">
                            <a href="#" class="social-link" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<style>
    .container-footer {
        padding: 0;
    }

    /* Professional Footer Styles */
    .professional-footer {
        background: #2561a8 !important;
        color: #ffffff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin-top: 50px;
    }

    .footer-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .footer-content {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1fr 1.5fr;
        gap: 40px;
        padding: 60px 0 40px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .footer-column {
        min-width: 0;
        /* Prevents grid overflow */
    }

    /* Company Info Section */
    .company-column {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .logo-container {
        margin-bottom: 20px;
    }

    .footer-logo {
        position: relative;
        display: inline-block;
        overflow: hidden;
    }

    .footer-logo img {
        display: block;
        max-width: 100%;
        height: auto;
    }

    .footer-logo::after {
        content: "";
        position: absolute;
        top: 0;
        left: -75%;
        width: 50%;
        height: 100%;
        background: linear-gradient(120deg,
                transparent,
                rgba(255, 255, 255, 0.6),
                transparent);
        transform: skewX(-20deg);
    }

    .footer-logo:hover::after {
        animation: logoShine 1s forwards;
    }

    .copyright-section>a {
        border-bottom: none !important;
    }

    @keyframes logoShine {
        100% {
            left: 125%;
        }
    }


    .footer-logo {
        max-width: 200px;
        height: auto;
        border: 3px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        padding: 10px;
        background: rgb(255, 255, 255);
        transition: all 0.3s ease;
    }

    .footer-logo:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .company-description p {
        font-size: 18px;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.8);
        margin: 0;
        max-width: 280px;
    }

    /* Footer Titles */
    .footer-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #ffffff;
        position: relative;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .footer-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #ffffff, #ffffff, #ffffff);
        border-radius: 2px;
    }

    /* Footer Links */
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 4px;
        transition: all 0.3s ease;
    }

    .footer-links a {
        color: #ffffff;
        text-decoration: none;
        font-size: 18px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        display: inline-block;
    }

    .footer-links a:hover {
        border-bottom: none !important;
    }

    /* .footer-links a::before {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 1px;
        background: linear-gradient(90deg, rgb(139, 139, 140), #ffffff, #2561a8);
        transition: width 0.3s ease;
    } */

    /* .footer-links a:hover {
    color: #ffffff;
    transform: translateX(5px);
} */

    /* .footer-links a:hover::before {
    width: 100%;
} */

    /* Contact Section */
    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .contact-icon {
        color: #ffffff;
        font-size: 18px;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .contact-text {
        font-size: 16px;
        line-height: 1;
        color: rgba(255, 255, 255, 0.8);
    }

    .contact-text strong {
        color: #ffffff;
        display: block;
        margin-bottom: 3px;
    }

    .contact-text a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .contact-text a:hover {
        color: #ffffff;
    }

    /* Footer Bottom */
    .footer-bottom {
        padding: 30px 0;
    }

    .footer-bottom-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .copyright-section p {
        margin: 0;
        font-size: 16px;
        color: rgba(255, 255, 255, 0.8);
    }

    .developer-link {
        color: #fff;
        text-decoration: none;
        position: relative;
        display: inline-block;
        vertical-align: middle;
        /* keeps it aligned with surrounding text */
        transition: color 0.3s ease;
        background: linear-gradient(90deg, #ffffff, #F57C00);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        overflow: hidden;
        font-size: 18px;
    }

    .developer-link::after {
        content: "";
        position: absolute;
        top: 0;
        left: -75%;
        width: 50%;
        height: 100%;
        background: linear-gradient(120deg,
                transparent,
                rgba(255, 255, 255, 0.6),
                transparent);
        transform: skewX(-20deg);
    }

    .developer-link:hover::after {
        animation: shine 0.8s forwards;
    }

    /* Smooth bold hover only for Top Categories & Top Brands */
    /* .footer-column:nth-child(3) .footer-links a,
    .footer-column:nth-child(4) .footer-links a {
        font-weight: 500;
        transition: all 0.3s ease;
    } */

    /* .footer-links>li>a:hover,
    .footer-column:nth-child(3) .footer-links a:hover,
    .footer-column:nth-child(4) .footer-links a:hover {
        color: #ffffff;
        font-weight: 600;
        transform: scale(1.03);
    } */


    @keyframes shine {
        100% {
            left: 125%;
        }
    }


    /* Social Links */
    .social-links {
        display: flex;
        gap: 15px;
    }

    .social-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        color: #ffffff;
        text-decoration: none;
        font-size: 18px;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .social-link:hover {
        transform: translateY(-3px) scale(1.1);
    }

    /* Brand Colors on Hover */
    .social-link[aria-label="Facebook"]:hover {
        background: #1877F2;
        color: #ffffff;
        box-shadow: 0 5px 15px rgba(24, 119, 242, 0.4);
        border-color: #1877F2;
    }

 .social-link[aria-label="Instagram"]:hover {
    background: linear-gradient(
        45deg,
        #fdf497,
        #fd5949,
        #d6249f,
        #285AEB
    );
    background-size: 300% 300%;
    animation: instaGradient 3s ease infinite;
    color: #ffffff;
    border: none;
}

    .social-link[aria-label="LinkedIn"]:hover {
        background: #0A66C2;
        color: #ffffff;
        box-shadow: 0 5px 15px rgba(10, 102, 194, 0.4);
        border-color: #0A66C2;
    }

    .social-link[aria-label="YouTube"]:hover {
        background: #FF0000;
        color: #ffffff;
        box-shadow: 0 5px 15px rgba(255, 0, 0, 0.4);
        border-color: #FF0000;
    }


    /* Responsive Design */
    @media (max-width: 1200px) {
        .footer-content {
            grid-template-columns: 1.2fr 1fr 1fr 1fr 1.2fr;
            gap: 30px;
            padding: 50px 0 35px;
        }

        .footer-logo {
            max-width: 180px;
        }
    }

    @media (max-width: 992px) {
        .footer-content {
            grid-template-columns: 1fr 1fr 1fr;
            gap: 30px;
        }

        .company-column {
            grid-column: 1 / -1;
            text-align: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .contact-column {
            grid-column: 1 / -1;
            margin-top: 20px;
        }

        .footer-logo {
            max-width: 200px;
        }

        .company-description p {
            max-width: 400px;
            text-align: justify;
        }
    }

    @media (max-width: 768px) {
        .footer-container {
            padding: 0 15px;
        }

        .footer-content {
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            padding: 40px 0 30px;
        }

        .company-column {
            grid-column: 1 / -1;
            margin-bottom: 15px;
        }

        .contact-column {
            grid-column: 1 / -1;
            margin-top: 15px;
        }

        .footer-title {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .footer-links a {
            font-size: 13px;
        }

        .footer-bottom-content {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }

        .copyright-section {
            order: 2;
        }

        .social-section {
            order: 1;
        }
    }

    @media (max-width: 576px) {
        .footer-content {
            grid-template-columns: 1fr;
            gap: 20px;
            padding: 35px 0 25px;
        }

        .company-column,
        .contact-column {
            grid-column: auto;
            margin: 0;
        }

        .footer-logo {
            max-width: 160px;
        }

        .footer-title {
            font-size: 15px;
            text-align: left;
        }

        .footer-title::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .footer-links {
            text-align: left;
        }

        .contact-info {
            gap: 15px;
        }

        .contact-item {
            /* justify-content: center;  */
            text-align: left;
        }

        .social-link {
            width: 35px;
            height: 35px;
            font-size: 16px;
        }

        .footer-bottom {
            padding: 20px 0;
        }

        .copyright-section p {
            font-size: 12px;
            line-height: 1.4;
        }
    }

    @media (max-width: 400px) {
        .footer-container {
            padding: 0 10px;
        }

        .footer-content {
            padding: 30px 0 20px;
        }

        .footer-logo {
            max-width: 140px;
        }

        .company-description p {
            font-size: 13px;
        }

        .footer-title {
            font-size: 16px;
        }

        .footer-links a {
            font-size: 12px;
        }

        .contact-text {
            font-size: 13px;
        }

        .social-links {
            gap: 10px;
        }

        .social-link {
            width: 32px;
            height: 32px;
            font-size: 13px;
        }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .footer-column {
        animation: fadeInUp 0.6s ease-out;
    }

    .footer-column:nth-child(1) {
        animation-delay: 0.1s;
    }

    .footer-column:nth-child(2) {
        animation-delay: 0.2s;
    }

    .footer-column:nth-child(3) {
        animation-delay: 0.3s;
    }

    .footer-column:nth-child(4) {
        animation-delay: 0.4s;
    }

    .footer-column:nth-child(5) {
        animation-delay: 0.5s;
    }

    /* Hover effects */
    .footer-section:hover .footer-title::after {
        /* width: 100px;a */
        transition: width 0.3s ease;
    }

    /* Accessibility */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>