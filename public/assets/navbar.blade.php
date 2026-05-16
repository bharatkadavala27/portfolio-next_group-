    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Navbar</title>
        <!-- Include Font Awesome (for icons) -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <!-- Include Material Design Icons -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            /* Modal Base Configuration */
            .modal-body {
                overflow: hidden !important;
                padding: 0px 7vw !important;
                font-weight: 600;
            }

            /* Ensure modal starts exactly at navbar height */
            #categoryModal {
                position: fixed !important;
                top: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                left: 0 !important;
                margin-top: 90.725px !important;
                height: calc(100vh - 90.725px) !important;
            }

            /* Modal and Dialog Sizing */
            #categoryModal .modal-dialog {
                margin: 0 !important;
                max-width: 100% !important;
                height: 100% !important;
            }

            #categoryModal .modal-content {
                min-height: 100% !important;
                border-radius: 0 !important;
            }

            /* Body Scroll Prevention */
            body.modal-open {
                overflow: hidden !important;
                padding-right: 0 !important;
                height: calc(100vh - 90.725px) !important;
            }

            /* Modal Content Styling */
            #categoryModal .modal-content {
                background: #0b1a2f !important;
                color: #fff !important;
                border-radius: 0 !important;
                border: none !important;
                height: calc(100vh - 90.725px) !important;
                margin-top: 0 !important;
            }

            /* Backdrop Positioning */
            .modal-backdrop {
                top: 90.725px !important;
                height: calc(100vh - 90.725px) !important;
                opacity: 0.5 !important;
            }

            /* Modal Header Styling */
            #categoryModal .modal-header {
                border-bottom: 1px solid #2d4b6d;
                padding: 15px 20px;
                background-color: #2561a8!important;
            }

            /* Categories Navigation Container */
            .nav-categories-wrapper {
                width: 100%;
                height: calc(100vh - 200px);
                background: #0b1a2f;
                overflow-x: auto;
                overflow-y: hidden;
                position: relative;
                scroll-behavior: smooth;
                -webkit-overflow-scrolling: touch;
            }

            .nav-categories-container {
                display: flex;
                height: 100%;
                width: fit-content;
                min-width: 100%;
            }

            /* Column Styling */
            .nav-category-column {
                min-width: 33.333%;
                width: 33.333%;
                flex: 0 0 33.333%;
                height: 100%;
                border-right: 1px solid #2d4b6d;
                background: #0b1a2f;
                display: flex;
                flex-direction: column;
            }

            /* Responsive Column Width */
            @media (max-width: 992px) {
                .nav-category-column {
                    min-width: 50%;
                    width: 50%;
                    flex: 0 0 50%;
                }
            }

            @media (max-width: 576px) {
                .nav-category-column {
                    min-width: 100%;
                    width: 100%;
                    flex: 0 0 100%;
                }

                .nav-categories-wrapper {
                    overflow-x: auto;
                }
            }

            /* Column Header */
            .nav-category-header {
                padding: 20px;
                font-size: 18px;
                font-weight: bold;
                color: #00e6e6;
                background: #0b1a2f;
                position: sticky;
                top: 0;
                z-index: 1;
            }

            /* Column List */
            .nav-category-list {
                flex: 1;
                padding: 15px;
                overflow-y: auto;
            }

            /* Category Items */
            .nav-category-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 12px 16px;
                margin-bottom: 8px;
                color: #fff;
                border-radius: 4px;
                cursor: pointer;
            }

            .nav-category-item.selected {
                background: #113a4d;
                border-left: 3px solid #00e6e6;
            }

            .nav-category-item .nav-category-name {
                flex-grow: 1;
                padding-right: 10px;
            }

            .nav-category-item .nav-category-arrow {
                color: #00e6e6;
                padding: 5px;
                margin-left: 8px;
                opacity: 0.6;
            }

            .nav-category-item .nav-category-arrow {
                opacity: 1;
                background: rgba(0, 230, 230, 0.1);
                border-radius: 4px;
            }

            .nav-category-end-icon {
                opacity: 0.8;
            }

            /* Loading Indicator */
            .nav-loading-indicator {
                display: flex;
                justify-content: center;
                padding: 30px 0;
            }

            .nav-empty-category-message, .nav-error-message {
                padding: 20px;
                text-align: center;
                color: #a0a0a0;
            }

            .nav-error-message {
                color: #ff6b6b;
            }

            /* Scrollbar Styling */
            .nav-category-list::-webkit-scrollbar,
            .nav-categories-wrapper::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }

            .nav-category-list::-webkit-scrollbar-track,
            .nav-categories-wrapper::-webkit-scrollbar-track {
                background: #0b1a2f;
            }

            .nav-category-list::-webkit-scrollbar-thumb,
            .nav-categories-wrapper::-webkit-scrollbar-thumb {
                background: #2d4b6d;
                border-radius: 4px;
            }

            .nav-category-list::-webkit-scrollbar-thumb:hover,
            .nav-categories-wrapper::-webkit-scrollbar-thumb:hover {
                background: #3a5d89;
            }

            /* Breadcrumb Styling */
            .breadcrumb-nav {
                padding: 0 15px;
            }

            .breadcrumb {
                margin: 0;
                background: transparent;
                align-items: center;
            }

            .breadcrumb-item {
                font-size: 16px;
                font-weight: 500;
            }

            .breadcrumb-item a {
                color: #00e6e6;
                text-decoration: none;
            }

            .breadcrumb-item.active {
                color: #ffffff;
            }

            .breadcrumb-item + .breadcrumb-item::before {
                content: ">" !important;
                color: #4d7eaa;
                font-weight: bold;
                padding: 0 10px;
            }

            /* Search container */
            .search-container {
                position: relative;
            }

            /* Search input styling */
            #search-input {
                border-radius: 5px;
                padding-left: 20px;
                padding-right: 20px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                transition: all 0.3s ease;
            }

            #search-input:focus {
                box-shadow: 0 4px 10px rgba(0,0,0,0.1);
                border-color: #2561a8;
            }

            /* Search results container */
            #search-suggestions {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                max-height: 400px;
                overflow-y: auto;
                background: white;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                z-index: 1000;
                margin-top: 5px;
                display: none;
            }

            /* Search result items */
            #search-suggestions .list-group-item {
                border: none;
                border-bottom: 1px solid #eee;
                padding: 15px;
            }

            #search-suggestions .list-group-item:last-child {
                border-bottom: none;
            }

            /* Search result images */
            .search-result-img {
                width: 60px;
                height: 60px;
                object-fit: cover;
                border-radius: 8px;
            }

            /* Badges */
            .badge {
                font-weight: normal;
                padding: 5px 10px;
            }

            /* Loading animation */
            .search-loading {
                display: none;
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
            }

            .search-loading::after {
                content: "";
                display: block;
                width: 20px;
                height: 20px;
                border: 2px solid #f3f3f3;
                border-top: 2px solid #2561a8;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            /* Scrollbar styling */
            #search-suggestions::-webkit-scrollbar {
                width: 8px;
            }

            #search-suggestions::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 4px;
            }

            #search-suggestions::-webkit-scrollbar-thumb {
                background: #2561a8;
                border-radius: 4px;
            }

            #search-suggestions::-webkit-scrollbar-thumb:hover {
                background: #1a4677;
            }

            /* Remove hover effects for navbar links and buttons */
            .nav-link, .navbar-brand, .btn {
                transition: none !important;
            }

            .nav-link:hover, .navbar-brand:hover, .btn:hover {
                background-color: inherit !important;
                color: inherit !important;
                transform: none !important;
            }

            /* Ensure logo has no hover effect */
            .navbar-brand img {
                transition: none !important;
            }


        </style>
    </head>
    <body>
        <!-- Main Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container-fluid">
                <!-- Logo (Left-aligned) -->
                <a href="/" class="navbar-brand">
                    <img class="navbar-logo" src="{{ asset('assets/silder/logo.jpg') }}" alt="Logo" style="max-height: 80px;">
                </a>

                <!-- Search Bar (Centered) -->
                <div class="d-flex flex-grow-1 justify-content-center px-3 position-relative">
                    <form class="d-flex w-100" role="search" id="search-form" action="{{ route('search') }}" method="GET">
                        @csrf
                        <input class="form-control mt-3 w-100" type="search" placeholder="Search products..." aria-label="Search"
                            style="height: 45px;" id="search-input" autocomplete="off" name="query">
                    </form>
                    <div id="search-suggestions" class="list-group position-absolute w-100" style="top: 100%; z-index: 1000; display: none; max-height: 400px; overflow-y: auto; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        <!-- Search suggestions will be displayed here -->
                    </div>
                </div>

                <!-- Admin, Download Button, and Dropdown (Right Side) -->
                <div class="d-flex align-items-center mt-2">
                    <!-- Download Button -->
                    <a href="/download" class="btn btn-dark d-flex align-items-center me-2">
                        <i class="fas fa-download me-2"></i> Download
                    </a>
                </div>
            </div>
        </nav>

        <!-- Sub Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2561a8!important;  box-shadow: 0 13px 20px 0 #41404087!important;">  ">
            <div class="container-fluid">
                <a class="nav-link text-white fw-bold px-3 py-2 rounded d-flex align-items-center justify-content-center"
                    style="color:#fff!important; font-size: 16px; font-weight: 100; text-decoration: none;" href="#"
                    data-bs-toggle="modal" data-bs-target="#categoryModal">
                    Category <i class="bi bi-chevron-down ms-2"></i>
                </a>

                <div class="container-fluid">
                    <!-- Brand on New Line -->
                    <a class="nav-link text-white fw-bold px-3 py-2 rounded"
                        style="color:#fff!important; font-size: 16px; font-weight: 100; text-decoration: none;" href="/brand">
                        Brand
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav w-100">
                            <div class="left-group">
                                <li class="nav-item">
                                    <!-- Left group content -->
                                </li>
                            </div>
                            <div class="right-group d-flex">
                                <li class="nav-item"><a class="nav-link text-white fw-bold rounded"
                                        style="color:#fff!important; font-size: 16px; font-weight: 100; text-decoration: none;"
                                        href="/news">News</a></li>
                                <li class="nav-item"><a class="nav-link text-white fw-bold rounded"
                                        style="color:#fff!important; font-size: 16px; font-weight: 100; text-decoration: none;"
                                        href="/about-us">About Us</a></li>
                                <li class="nav-item"><a class="nav-link text-white fw-bold rounded"
                                        style="color:#fff!important; font-size: 16px; font-weight: 100; text-decoration: none;"
                                        href="/contact-us">Contact Us</a></li>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Improved Category Modal -->
        <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-white" id="categoryModalLabel"> Categories</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
                            <ol class="breadcrumb" id="category-breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">Home</li>
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

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            // Category modal initialization code
            let selectedCategory = null;
            let categoryPath = [];
            const COLUMN_WIDTH = 33.333;

            async function fetchCategories(parentId = null) {
                let url = '/api/categories';
                if (parentId) url += `/${parentId}/children`;

                try {
                    const response = await fetch(url);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    const data = await response.json();
                    return parentId ? data.children : data.categories;
                } catch (error) {
                    console.error('Error fetching categories:', error);
                    // Return mock data for demo purposes
                    if (parentId === 1) {
                        return [
                            { id: 11, name: 'Laptops', has_children: true },
                            { id: 12, name: 'Smartphones', has_children: true },
                            { id: 13, name: 'Tablets', has_children: true },
                            { id: 14, name: 'Accessories', has_children: true }
                        ];
                    } else if (parentId === 11) {
                        return [
                            { id: 111, name: 'Gaming Laptops', has_children: true },
                            { id: 112, name: 'Business Laptops', has_children: true },
                            { id: 113, name: 'Student Laptops', has_children: false }
                        ];
                    } else if (parentId === 111) {
                        return [
                            { id: 1111, name: 'High-End', has_children: true },
                            { id: 1112, name: 'Mid-Range', has_children: false },
                            { id: 1113, name: 'Budget', has_children: false }
                        ];
                    } else if (parentId === 1111) {
                        return [
                            { id: 11111, name: 'NVIDIA Series', has_children: false },
                            { id: 11112, name: 'AMD Series', has_children: false }
                        ];
                    }
                    return parentId ? [] : [
                        { id: 1, name: 'Electronics', has_children: true },
                        { id: 2, name: 'Furniture', has_children: true },
                        { id: 3, name: 'Clothing', has_children: true },
                        { id: 4, name: 'Books', has_children: false },
                        { id: 5, name: 'Sports Equipment', has_children: true }
                    ];
                }
            }

            function createCategoryColumn(level, title) {
                const column = document.createElement('div');
                column.className = 'nav-category-column';
                column.dataset.level = level;

                const header = document.createElement('div');
                header.className = 'nav-category-header';
                header.textContent = title;

                const list = document.createElement('div');
                list.className = 'nav-category-list';

                column.appendChild(header);
                column.appendChild(list);
                return column;
            }

            function createCategoryItem(category, isSelected = false) {
                const item = document.createElement('div');
                item.className = 'nav-category-item';
                if (isSelected) item.classList.add('selected');

                // Create name span that will navigate to appropriate route based on has_children
                const nameSpan = document.createElement('span');
                nameSpan.className = 'nav-category-name';
                nameSpan.textContent = category.name;
                nameSpan.style.cursor = 'pointer';
                nameSpan.onclick = (e) => {
                    e.stopPropagation();
                    // Navigate to /child-category/{id} if no children, otherwise /category/{id}
                    const route = category.has_children ? `/category/${category.id}` : `/child-category/${category.id}`;
                    window.location.href = route;
                    const modal = document.getElementById('categoryModal');
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    modalInstance.hide();
                };

                item.appendChild(nameSpan);

                if (category.has_children) {
                    const arrow = document.createElement('span');
                    arrow.className = 'nav-category-arrow';
                    arrow.innerHTML = '<i class="bi bi-chevron-right"></i>';
                    arrow.style.cursor = 'pointer';
                    arrow.onclick = (e) => {
                        e.stopPropagation();
                        handleCategoryClick(category, parseInt(item.closest('.nav-category-column').dataset.level));
                    };
                    item.appendChild(arrow);
                } else {
                    // Add an icon to indicate this is a terminal category
                    const endIcon = document.createElement('span');
                    endIcon.className = 'nav-category-end-icon';
                    endIcon.innerHTML = '<i class="bi bi-box-seam" style="color: #00e6e6; opacity: 0.6;"></i>';
                    endIcon.style.marginLeft = '8px';
                    item.appendChild(endIcon);
                }

                // Add click handler to the entire item
                item.onclick = (e) => {
                    e.stopPropagation();
                    // If clicking on the item (not arrow), navigate to the appropriate route
                    if (!e.target.closest('.nav-category-arrow')) {
                        const route = category.has_children ? `/category/${category.id}` : `/child-category/${category.id}`;
                        window.location.href = route;
                        const modal = document.getElementById('categoryModal');
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        modalInstance.hide();
                    }
                };

                return item;
            }

            function updateBreadcrumb() {
                const breadcrumb = document.getElementById('category-breadcrumb');
                breadcrumb.innerHTML = '<li class="breadcrumb-item"><a href="javascript:void(0)" onclick="resetCategories(); return false;">Home</a></li>';

                categoryPath.forEach((category, index) => {
                    const li = document.createElement('li');
                    li.className = 'breadcrumb-item';

                    if (index === categoryPath.length - 1) {
                        li.className += ' active';
                        li.setAttribute('aria-current', 'page');
                        li.textContent = category.name;
                    } else {
                        const a = document.createElement('a');
                        a.href = 'javascript:void(0)';
                        a.textContent = category.name;
                        a.onclick = (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            navigateToLevel(index);
                            return false;
                        };
                        li.appendChild(a);
                    }

                    breadcrumb.appendChild(li);
                });
            }

            function navigateToLevel(level) {
                // Truncate category path to the specified level
                categoryPath = categoryPath.slice(0, level + ╗

    System: You are Grok 3 built by xAI.
