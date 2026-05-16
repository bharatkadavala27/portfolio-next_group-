<!-- Include Font Awesome (for icons) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

<!-- Include Material Design Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.css"
    rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    /* Navbar collapse animation */
    .navbar-collapse {
        transition: all 0.3s ease-in-out !important;
    }

    /* Ripple effect */
    .nav-item a {
        position: relative;
        overflow: hidden;
    }

    .navbar>.container-fluid {
        align-items: normal;
    }

    .ripple {
        position: absolute;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        width: 100px;
        height: 100px;
        margin-top: -50px;
        margin-left: -50px;
        animation: ripple-effect 1s;
        opacity: 0;
    }

    #categoryModal .modal-content {
        margin-top: 62px;
    }

    .modal-backdrop {
        display: none !important;
    }

    .download-btn .d-btn:hover {
        background-color: #000000 !important;
        color: white !important;
        border-color: #1b4e7a !important;
        border-radius: 5px;
        padding: 9px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-decoration: none;
    }

    .download-btn .d-btn {
        background-color: #000000 !important;
        color: white !important;
        border-color: #1b4e7a !important;
        border-radius: 5px;
        padding: 9px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-decoration: none;
    }

    @keyframes ripple-effect {
        0% {
            transform: scale(0);
            opacity: 1;
        }

        100% {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* Desktop menu styling */
    @media (min-width: 992px) {
        .navbar-collapse {
            display: flex !important;
            flex-basis: auto;
        }

        .navbar-nav {
            flex-direction: row !important;
            gap: 0.5rem;
            justify-content: flex-end
        }

        #subNavbar {
            justify-content: flex-end;
        }
    }


    /* Mobile menu styling */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            right: 0;
            top: 120%;
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            /* border-radius: 16px; */
            /* box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37); */
            /* border: 1px solid rgba(255, 255, 255, 0.18); */
            padding: 0.75rem;
            /* margin-top: 0.5rem; */
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
        }

        .no-hover-effect {
            text-align: right;
        }

        .navbar-collapse.show {
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
            top: 100%;
        }


        #subNavbar.navbar-collapse {
            /* background: rgba(37, 97, 168, 0.95); */
            background: #2561a8 !important;
        }

        .navbar-nav {
            padding: 0.5rem;
            flex-direction: column !important;
            gap: 0.5rem;
        }

        .nav-item {
            padding: 0;
            border: none;
            width: 100%;
            transition: all 0.2s ease;
        }

        .nav-item a {
            display: block;
            width: 100%;
            padding: 0.75rem 1.25rem;
            border-radius: 12px;
            transition: all 0.2s ease;
            font-weight: 500 !important;
        }

        .nav-item a:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        /* Cool hover effect for menu items */
        .nav-item a::before {
            content: '';
            position: absolute;
            left: 0;
            width: 3px;
            height: 0;
            background: white;
            transition: height 0.2s ease;
        }

        .nav-item a:hover::before {
            height: 100%;
        }

        /* Navbar toggler animation */
        .navbar-toggler {
            padding: 0.5rem;
            transition: transform 0.3s ease;
        }

        .navbar-toggler[aria-expanded="true"] {
            transform: rotate(180deg);
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        /* Overlay when menu is open */
        .navbar-collapse.show::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            /* height: 100vh; */
            /* background: rgba(0, 0, 0, 0.5);
             */
            background: #2561a8 !important;
            z-index: -1;
            animation: fadeIn 0.3s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Mobile icons styling */
        .btn-link {
            padding: 0.25rem 0.5rem;
            color: #333 !important;
        }

        .btn-link:hover {
            color: #2561a8 !important;
        }

        /* Container positioning for dropdown */
        .container-fluid {
            position: relative;
        }

        .navbar-toggler {
            transition: transform 1s ease;
        }

        .navbar-toggler[aria-expanded="true"] {
            /* transform: rotate(90deg); */
        }
    }

    /* Smooth transitions for interactive elements */
    .nav-link,
    .navbar-toggler,
    .btn {
        transition: all 0.2s ease-in-out;
    }

    .nav-category-arrow i.bi-chevron-right {
        font-size: 1.2em;
        /* slightly larger */
        font-weight: 900;
        /* make it bold */
        -webkit-text-stroke: 1px currentColor;
        /* adds thickness */
        color: #333;
        /* adjust color */
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .nav-category-arrow i.bi-chevron-right:hover {
        transform: scale(1.1);
        color: #000;
        /* darker on hover */
    }

    .nav-category-item:hover {
        background: rgb(0 216 227 / 87%);
        transition: background 0.3s ease;
    }
</style>

<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container-fluid">
        <!-- Logo -->
        <a href="/" class="no-hover-effect navbar-brand">
            <img class="navbar-logo" src="{{ asset('assets/silder/logo.jpg') }}" alt="Logo" style="max-height: 80px;">
        </a>

        <!-- Search and Download Icons for Mobile -->
        <div class="d-flex d-lg-none align-items-center">
            <button type="button" class="btn btn-link text-dark me-2" data-bs-toggle="modal"
                data-bs-target="#searchModal">
                <i class="fas fa-search fs-5"></i>
            </button>
            <a href="/download" class="btn btn-link text-dark">
                <i class="fas fa-download m-2 fs-5"></i>
            </a>
        </div>

        {{-- <!-- Desktop Search and Download -->
        <div class="d-none d-lg-flex flex-grow-1 justify-content-center px-3 position-relative">
            <form class="d-flex w-100" role="search" id="search-form" action="{{ route('search') }}" method="GET">
                @csrf
                <input class="form-control mt-3 w-100" type="search" placeholder="Search products..."
                    aria-label="Search" style="height: 45px;" id="search-input" autocomplete="off" name="query">
            </form>
            <div id="search-suggestions" class="list-group position-absolute w-100"
                style="top: 100%; z-index: 10000; display: none; max-height: 400px; overflow-y: auto; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <!-- Search suggestions will be displayed here -->
            </div>
        </div>
        <div class="d-none download-btn d-lg-flex align-items-center mt-2 ms-auto">
            <a href="/download" class="btn btn-dark d-flex align-items-center me-2">
                <i class="fas fa-download me-2"></i> Download
            </a>
        </div> --}}

        <!-- Desktop Search and Download -->
        <div class="d-none d-lg-flex flex-grow-1 justify-content-center px-3 position-relative">
            <form class="d-flex w-100 position-relative" role="search" id="search-form" action="{{ route('search') }}"
                method="GET">
                @csrf
                <input class="form-control mt-3 w-100 pe-5" type="search" placeholder="Search products..."
                    aria-label="Search" style="height: 45px;" id="search-input" autocomplete="off" name="query">

                <!-- Search Icon inside input -->
                <button type="submit" class="btn border-0 bg-transparent position-absolute"
                    style="right: 10px; top: 50%; transform: translateY(-50%);">
                    <i class="fas fa-search text-muted"></i>
                </button>
            </form>

            <div id="search-suggestions" class="list-group position-absolute w-100"
                style="top: 100%; z-index: 10000; display: none; max-height: 400px; overflow-y: auto; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <!-- Search suggestions will be displayed here -->
            </div>
        </div>

        <!-- Download button -->
        <div class="d-none download-btn d-lg-flex align-items-center  ms-auto">
            <a href="/download" class="d-btn btn-dark d-flex align-items-center me-2">
                <i class="fas fa-download me-2"></i> Download
            </a>
        </div>

    </div>
</nav>

<!-- Mobile Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="searchModalLabel">Search Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="search" action="{{ route('search') }}" method="GET">
                    @csrf
                    <input class="form-control" type="search" placeholder="Search products..." aria-label="Search"
                        style="height: 45px;" autocomplete="off" name="query">
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Sub Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark"
    style="background-color: #2561a8!important; box-shadow: 0px 20px 30px 0px #00000021 !important; z-index: 9999;">
    <div class="container-fluid">
        <!-- Left side menu items (always visible) -->
        <div class="d-flex align-items-center">
            <a class="no-hover-effect nav-link text-white fw-bold px-3 py-2 rounded d-flex align-items-center"
                style="color:#fff!important; font-size: 16px; font-weight: 100; text-decoration: none;" href="#"
                data-bs-toggle="modal" data-bs-target="#categoryModal">
                Category <i class="bi bi-chevron-down ms-2"></i>
            </a>
            <a class="no-hover-effect nav-link text-white fw-bold px-3 py-2 rounded"
                style="color:#fff!important; font-size: 16px; font-weight: 100; text-decoration: none;" href="/brand">
                Brand
            </a>
        </div>

        <!-- Mobile toggle button -->
        <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#subNavbar" aria-controls="subNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Right side menu items -->
        <div class="collapse navbar-collapse" id="subNavbar">
            <ul class="navbar-nav ms-auto d-flex flex-row flex-wrap">
                <li class="nav-item"><a class="no-hover-effect nav-link text-white fw-bold rounded px-3"
                        style="color:#fff!important; font-size: 16px; font-weight: 100; text-decoration: none;"
                        href="/news">News</a></li>
                <li class="nav-item"><a class="no-hover-effect nav-link text-white fw-bold rounded px-3"
                        style="color:#fff!important; font-size: 16px; font-weight: 100; text-decoration: none;"
                        href="/about-us">About Us</a></li>
                <li class="nav-item"><a class="no-hover-effect nav-link text-white fw-bold rounded px-3"
                        style="color:#fff!important; font-size: 16px; font-weight: 100; text-decoration: none;"
                        href="/contact-us">Contact Us</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Improved Category Modal -->
<div class="modal " id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h5 class="modal-title text-white no-hover-effect " id="categoryModalLabel"> Categories</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div> --}}
            <div class="modal-body">
                <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3 mt-2">
                    <ol class="breadcrumb" id="category-breadcrumb">
                        <li class="breadcrumb-item active no-hover-effect " aria-current="page">Home</li>
                        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"
                            aria-label="Close"></button>
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
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize collapse functionality
        const subNavbar = document.getElementById('subNavbar');
        const subToggler = document.querySelector('[data-bs-toggle="collapse"][data-bs-target="#subNavbar"]');

        if (subToggler && subNavbar) {
            const bsCollapse = new bootstrap.Collapse(subNavbar, {
                toggle: false
            });

            subToggler.addEventListener('click', function (e) {
                e.preventDefault();
                if (subNavbar.classList.contains('show')) {
                    bsCollapse.hide();
                } else {
                    bsCollapse.show();
                }
            });

            // Close menu when clicking outside
            document.addEventListener('click', function (e) {
                if (!subNavbar.contains(e.target) && !subToggler.contains(e.target) && subNavbar.classList.contains('show')) {
                    bsCollapse.hide();
                }
            });

            // Add animation class when menu state changes
            subNavbar.addEventListener('show.bs.collapse', function () {
                subToggler.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            });

            subNavbar.addEventListener('hide.bs.collapse', function () {
                subToggler.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            });
        }

        // Add ripple effect to menu items
        const menuItems = document.querySelectorAll('.nav-item a');
        menuItems.forEach(item => {
            item.addEventListener('click', function (e) {
                const rect = item.getBoundingClientRect();
                const ripple = document.createElement('div');
                ripple.className = 'ripple';
                ripple.style.left = `${e.clientX - rect.left}px`;
                ripple.style.top = `${e.clientY - rect.top}px`;
                item.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 1000);
            });
        });

        // Close menus when clicking outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.navbar')) {
                document.getElementById('mainNavbar').classList.remove('show');
                document.getElementById('subNavbar').classList.remove('show');
            }
        });
    });
</script>

@push('scripts')
    <script>
        // Category modal initialization code
        let selectedCategory = null;
        let categoryPath = [];
        const COLUMN_WIDTH = 33.333;

        async function fetchCategories(parentId = null) {
            // Pagination support: returns { items, hasMore }
            const perPage = 10;
            let url = '/api/categories';
            if (parentId) url += `/${parentId}/children`;
            url += `?per_page=${perPage}`;
            // Track page in the calling function
            if (typeof fetchCategories.page === 'undefined') fetchCategories.page = {};
            const page = fetchCategories.page[parentId || 'root'] || 1;
            url += `&page=${page}`;
            try {
                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                let items = parentId ? data.children : data.categories;
                let hasMore = data.has_more !== undefined ? data.has_more : (items.length === perPage);
                return { items, hasMore };
            } catch (error) {
                console.error('Error fetching categories:', error);
                // Return mock data for demo purposes
                let items;
                let hasMore = false;
                if (parentId === 1) {
                    items = [
                        { id: 11, name: 'Laptops', has_children: true },
                        { id: 12, name: 'Smartphones', has_children: true },
                        { id: 13, name: 'Tablets', has_children: true },
                        { id: 14, name: 'Accessories', has_children: true }
                    ];
                } else if (parentId === 11) {
                    items = [
                        { id: 111, name: 'Gaming Laptops', has_children: true },
                        { id: 112, name: 'Business Laptops', has_children: true },
                        { id: 113, name: 'Student Laptops', has_children: false }
                    ];
                } else if (parentId === 111) {
                    items = [
                        { id: 1111, name: 'High-End', has_children: true },
                        { id: 1112, name: 'Mid-Range', has_children: false },
                        { id: 1113, name: 'Budget', has_children: false }
                    ];
                } else if (parentId === 1111) {
                    items = [
                        { id: 11111, name: 'NVIDIA Series', has_children: false },
                        { id: 11112, name: 'AMD Series', has_children: false }
                    ];
                } else {
                    items = parentId ? [] : [
                        { id: 1, name: 'Electronics', has_children: true },
                        { id: 2, name: 'Furniture', has_children: true },
                        { id: 3, name: 'Clothing', has_children: true },
                        { id: 4, name: 'Books', has_children: false },
                        { id: 5, name: 'Sports Equipment', has_children: true }
                    ];
                }
                return { items, hasMore };
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
                // Get the level of this category from the column
                const parentId = category.parent_id ?? null;
                let route;
                if (parentId === null) {
                    route = `/category/${category.id}`;
                } else {
                    route = `/sub-category/${category.id}`;
                }
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

                // Add hover event to load subcategories
                arrow.onmouseenter = (e) => {
                    e.stopPropagation();
                    handleCategoryClick(category, parseInt(item.closest('.nav-category-column').dataset.level));
                };

                // Keep onclick for touch devices
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
                    const parentId = category.parent_id ?? null;
                    let route;
                    if (parentId === null) {
                        route = `/category/${category.id}`;
                    } else {
                        route = `/sub-category/${category.id}`;
                    }
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
            breadcrumb.innerHTML = ''; // Clear existing content

            // Add Home breadcrumb item
            const homeItem = document.createElement('li');
            homeItem.className = 'breadcrumb-item';
            const homeLink = document.createElement('a');
            homeLink.href = 'javascript:void(0)';
            homeLink.textContent = 'Home';
            homeLink.onclick = (e) => {
                e.preventDefault();
                e.stopPropagation();
                resetCategories();
                return false;
            };
            homeItem.appendChild(homeLink);
            breadcrumb.appendChild(homeItem);

            // Add category path items
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

            // Add close button
            const closeButton = document.createElement('button');
            closeButton.type = 'button';
            closeButton.className = 'btn-close btn-close-white ms-auto';
            closeButton.setAttribute('data-bs-dismiss', 'modal');
            closeButton.setAttribute('aria-label', 'Close');
            breadcrumb.appendChild(closeButton);
        } function navigateToLevel(level) {
            // Truncate category path to the specified level
            categoryPath = categoryPath.slice(0, level + 1);

            // Re-render the categories based on the new path
            const container = document.getElementById('categories-container');
            const columns = container.querySelectorAll('.nav-category-column');

            // Remove columns after the target level
            columns.forEach(col => {
                if (parseInt(col.dataset.level) > level) {
                    col.remove();
                }
            });

            // Update the breadcrumb
            updateBreadcrumb();

            // Reset container position if needed
            adjustContainerPosition();
        }

        function adjustContainerPosition() {
            const container = document.getElementById('categories-container');
            const columns = container.querySelectorAll('.nav-category-column');

            // If more than 3 columns, show horizontal scrollbar
            if (columns.length > 3) {
                // No transform needed - we'll rely on natural overflow scrolling
                container.style.transform = 'none';

                // Ensure the wrapper shows scrollbar
                const wrapper = document.querySelector('.nav-categories-wrapper');
                wrapper.scrollLeft = (columns.length - 3) * wrapper.clientWidth / 3;
            } else {
                container.style.transform = 'none';
            }
        }

        async function handleCategoryClick(category, level) {
            const container = document.getElementById('categories-container');
            const wrapper = document.querySelector('.nav-categories-wrapper');

            // Remove any columns after the current level before adding new ones
            const existingColumns = container.querySelectorAll('.nav-category-column');
            existingColumns.forEach(col => {
                if (parseInt(col.dataset.level) > level) {
                    col.remove();
                }
            });

            // Update selected category
            selectedCategory = category;

            // Update category path
            if (categoryPath.length > level) {
                categoryPath = categoryPath.slice(0, level);
            }
            categoryPath.push(category);

            // Calculate scroll position for mobile
            if (window.innerWidth <= 576) {
                const columnWidth = 325; // Fixed width for mobile
                const scrollPosition = columnWidth * level;
                wrapper.scrollTo({
                    left: scrollPosition,
                    behavior: 'smooth'
                });
            }

            // Update breadcrumb
            updateBreadcrumb();

            // Remove any columns after the current level
            const columns = container.querySelectorAll('.nav-category-column');
            columns.forEach(col => {
                if (parseInt(col.dataset.level) > level) {
                    col.remove();
                }
            });

            // Update selection state in current column
            const currentColumn = container.querySelector(`[data-level="${level}"]`);
            if (currentColumn) {
                currentColumn.querySelectorAll('.nav-category-item').forEach(item => {
                    item.classList.remove('selected');
                });
                // Find the clicked item and add selected class
                const items = currentColumn.querySelectorAll('.nav-category-item');
                items.forEach(item => {
                    if (item.querySelector('.nav-category-name').textContent.trim() === category.name) {
                        item.classList.add('selected');
                    }
                });
            }

            if (category.has_children) {
                // Create new column for subcategories
                const newColumn = createCategoryColumn(level + 1, category.name);
                container.appendChild(newColumn);

                // No loading indicator

                // Pagination state
                let currentPage = 1;
                let allSubcategories = [];
                let hasMore = false;

                async function loadPage(page) {
                    const { items, hasMore: more } = await fetchCategories(category.id);
                    allSubcategories = allSubcategories.concat(items);
                    hasMore = more;
                    const list = newColumn.querySelector('.nav-category-list');
                    list.innerHTML = '';
                    if (allSubcategories.length === 0) {
                        const emptyMessage = document.createElement('div');
                        emptyMessage.className = 'nav-empty-category-message';
                        emptyMessage.textContent = 'No subcategories found';
                        list.appendChild(emptyMessage);
                    } else {
                        allSubcategories.forEach(subcat => {
                            const item = createCategoryItem(subcat);
                            list.appendChild(item);
                        });
                        if (hasMore) {
                            const loadMoreBtn = document.createElement('button');
                            loadMoreBtn.className = 'btn btn-outline-info w-100 mt-2';
                            loadMoreBtn.textContent = 'Load More';
                            loadMoreBtn.onclick = function (e) {
                                e.stopPropagation();
                                currentPage++;
                                loadMoreBtn.disabled = true;
                                loadMoreBtn.textContent = 'Loading...';
                                loadPage(currentPage).then(() => {
                                    loadMoreBtn.disabled = false;
                                    loadMoreBtn.textContent = 'Load More';
                                });
                            };
                            list.appendChild(loadMoreBtn);
                        }
                    }
                    adjustContainerPosition();
                }
                // Initial load
                await loadPage(currentPage);

                // Helper to center a column inside wrapper with clamping
                function centerColumn(wrapperEl, colEl, percentFromLeft = 0.25) {
                    // Place the column so its center is at `percentFromLeft` of the wrapper width
                    if (!wrapperEl || !colEl) return;
                    const wrapperWidth = wrapperEl.clientWidth;
                    const colOffset = colEl.offsetLeft; // relative to container
                    const colWidth = colEl.offsetWidth;

                    // target so that col center is at wrapperWidth * percentFromLeft
                    const desiredCenterX = wrapperWidth * percentFromLeft;
                    let target = colOffset + (colWidth / 2) - desiredCenterX;

                    // Clamp to bounds
                    const maxScroll = Math.max(0, wrapperEl.scrollWidth - wrapperWidth);
                    if (target < 0) target = 0;
                    if (target > maxScroll) target = maxScroll;

                    wrapperEl.scrollTo({ left: target, behavior: 'smooth' });
                }

                // After content is rendered, center the newly added column on mobile
                if (window.innerWidth <= 576) {
                    const columns = container.querySelectorAll('.nav-category-column');
                    const newCol = columns[columns.length - 1];

                    // Try a few times to ensure layout has settled (rendering may be async on some devices)
                    let attempts = 0;
                    const tryCenter = () => {
                        attempts++;
                        requestAnimationFrame(() => {
                            const wrapperEl = document.querySelector('.nav-categories-wrapper');
                            if (!wrapperEl || !newCol) return;

                            // If wrapper scrollWidth isn't large enough yet, retry shortly
                            if (wrapperEl.scrollWidth <= wrapperEl.clientWidth && attempts < 5) {
                                setTimeout(tryCenter, 80);
                                return;
                            }

                            // position column slightly left-of-center to reveal next column; tweak percent as needed
                            centerColumn(wrapperEl, newCol, 0.28);
                        });
                    };

                    // Small initial delay then attempt centering
                    setTimeout(tryCenter, 60);
                }
            }
        }

        function resetCategories() {
            const container = document.getElementById('categories-container');
            container.innerHTML = ''; // Clear existing content

            // Reset category path
            categoryPath = [];

            // Update breadcrumb
            updateBreadcrumb();

            // Re-initialize categories
            initializeCategories();
        }

        async function initializeCategories() {
            const container = document.getElementById('categories-container');
            container.innerHTML = ''; // Clear existing content

            // Create and append main category column
            const mainColumn = createCategoryColumn(0, 'Products & Services');
            container.appendChild(mainColumn);

            // Reset container position
            container.style.transform = 'none';

            // No loading indicator

            // Pagination state for main categories
            let currentPage = 1;
            let allCategories = [];
            let hasMore = false;

            async function loadPage(page) {
                const { items, hasMore: more } = await fetchCategories(null);
                allCategories = allCategories.concat(items);
                hasMore = more;
                const list = mainColumn.querySelector('.nav-category-list');
                list.innerHTML = '';
                if (allCategories.length === 0) {
                    const emptyMessage = document.createElement('div');
                    emptyMessage.className = 'nav-empty-category-message';
                    emptyMessage.textContent = 'No categories found';
                    list.appendChild(emptyMessage);
                } else {
                    allCategories.forEach(category => {
                        const item = createCategoryItem(category);
                        list.appendChild(item);
                    });
                    if (hasMore) {
                        const loadMoreBtn = document.createElement('button');
                        loadMoreBtn.className = 'btn btn-outline-info w-100 mt-2';
                        loadMoreBtn.textContent = 'Load More';
                        loadMoreBtn.onclick = function (e) {
                            e.stopPropagation();
                            currentPage++;
                            loadMoreBtn.disabled = true;
                            loadMoreBtn.textContent = 'Loading...';
                            loadPage(currentPage).then(() => {
                                loadMoreBtn.disabled = false;
                                loadMoreBtn.textContent = 'Load More';
                            });
                        };
                        list.appendChild(loadMoreBtn);
                    }
                }
            }
            // Initial load
            loadPage(currentPage);
        }

        // Initialize when modal opens
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('categoryModal');
            const categoryLink = document.querySelector('a[data-bs-target="#categoryModal"]');
            const categoryIcon = categoryLink.querySelector('i.bi');

            // When modal opens, change to chevron-up
            modal.addEventListener('show.bs.modal', () => {
                categoryIcon.classList.remove('bi-chevron-down');
                categoryIcon.classList.add('bi-chevron-up');
                document.body.style.overflow = 'hidden';
            });

            // When modal closes, change back to chevron-down
            modal.addEventListener('hidden.bs.modal', () => {
                categoryIcon.classList.remove('bi-chevron-up');
                categoryIcon.classList.add('bi-chevron-down');
                document.body.style.overflow = '';
            });
            modal.addEventListener('show.bs.modal', initializeCategories);

            // Add touch events for better mobile scrolling
            if (wrapper) {
                wrapper.addEventListener('scroll', () => {
                    wrapper.dataset.lastScrollPosition = wrapper.scrollLeft;
                });

                // Restore scroll position after any DOM updates
                const observer = new MutationObserver(() => {
                    if (window.innerWidth <= 576 && wrapper.dataset.lastScrollPosition) {
                        wrapper.scrollLeft = parseInt(wrapper.dataset.lastScrollPosition);
                    }
                });

                observer.observe(wrapper, { childList: true, subtree: true });
            }

            // Ensure proper body behavior when modal is shown/hidden
            modal.addEventListener('show.bs.modal', () => {
                document.body.style.overflow = 'hidden';
            });

            modal.addEventListener('hidden.bs.modal', () => {
                document.body.style.overflow = '';
            });
        });
        // Search functionality
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            const searchSuggestions = document.getElementById('search-suggestions');
            const searchForm = document.getElementById('search-form');
            let searchTimeout;

            // Handle form submission
            searchForm.addEventListener('submit', function (e) {
                if (searchInput.value.length < 2) {
                    e.preventDefault();
                    return false;
                }
            });

            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                const query = this.value;

                if (query.length < 2) {
                    searchSuggestions.style.display = 'none';
                    return;
                }

                searchTimeout = setTimeout(() => {
                    fetch(`/search?query=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                        .then(response => response.text())
                        .then(html => {
                            // Create a temporary container to parse the HTML
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = html;

                            // Remove all <img> elements and elements with class search-result-img
                            tempDiv.querySelectorAll('img, .search-result-img').forEach(img => img.remove());

                            // Set the modified HTML to the suggestions container
                            searchSuggestions.innerHTML = tempDiv.innerHTML;
                            searchSuggestions.style.display = tempDiv.innerHTML ? 'block' : 'none';
                        });
                }, 300);
            });

            // Hide suggestions when clicking outside
            document.addEventListener('click', function (e) {
                if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                    searchSuggestions.style.display = 'none';
                }
            });
        });

    </script>
    <style>
        #search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            max-height: 400px;
            overflow-y: auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            margin-top: 5px;
            display: none;
        }

        /* Search result items */
        #search-suggestions .list-group-item {
            border: none;
            border-bottom: 1px solid #eee;
            padding: 15px;
            transition: all 0.2s ease;
        }

        #search-suggestions .list-group-item:last-child {
            border-bottom: none;
        }

        #search-suggestions .list-group-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
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
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
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

        .no-hover-effect {
            text-decoration: none !important;
            color: inherit !important;
            border: none !important;
            background: none !important;
            box-shadow: none !important;
            opacity: 1 !important;
        }
    </style>
@endpush

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
        overflow: hidden !important;
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
        background: #2561a8 !important;
        color: #fff !important;
        border-radius: 0 !important;
        border: none !important;
        height: calc(100vh - 90.725px) !important;
        margin-top: 55px !important;
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
        background-color: #2561a8 !important;
    }

    /* Categories Navigation Container */
    .nav-categories-wrapper {
        width: 100%;
        height: calc(100vh - 200px);
        background: #2561a8 !important;
        overflow-x: auto;
        /* Horizontal scrollbar enabled */
        overflow-y: hidden;
        position: relative;
        scroll-behavior: smooth;
        /* Smooth scrolling */
        -webkit-overflow-scrolling: touch;
        /* For iOS */
    }

    .nav-categories-container {
        display: flex;
        height: 100%;
        width: fit-content;
        /* Let it grow based on content */
        min-width: 100%;
        /* At least as wide as parent */
        background: #2561a8 !important;
    }

    /* Column Styling */
    .nav-category-column {
        min-width: 33.333%;
        width: 33.333%;
        flex: 0 0 33.333%;
        height: 100%;
        border-right: 1px solid #2d4b6d;
        background: #2561a8 !important;
        display: flex;
        flex-direction: column;
        max-width: 33.333% !important;
    }

    /* Responsive Column Width */
    @media (max-width: 992px) {
        .nav-category-column {
            min-width: 50%;
            width: 50%;
            flex: 0 0 50%;
            max-width: 50% !important;
        }
    }

    @media (max-width: 576px) {
        .nav-category-column {
            min-width: 325px;
            width: 325px;
            flex: 0 0 325px;
            max-width: 325px !important;
        }
    }

    /* Column Header */
    .nav-category-header {
        padding: 20px;
        font-size: 18px;
        font-weight: bold;
        color: #00e6e6;
        background: #2561a8 !important;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    /* Column List */
    .nav-category-list {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        width: 100%;
    }

    @media (max-width: 576px) {
        .nav-category-list {
            width: 325px;
            max-width: 325px;
        }
    }

    /* Category Items */
    .nav-category-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        /* padding: 12px 16px; */
        padding-left: 16px;
        margin-bottom: 8px;
        color: #fff;
        border-radius: 4px;
        transition: background-color 0.2s ease;
        cursor: pointer;
    }

    .nav-category-item:hover {
        background: #2a88b4;
    }

    .nav-category-item.selected {
        background: #2a88b4;
        border-left: 3px solid #00e6e6;
    }

    .nav-category-item .nav-category-name {
        flex-grow: 1;
        padding-right: 10px;
    }

    .nav-category-item .nav-category-name:hover {
        /* color: #00e6e6; */
    }

    .nav-category-item .nav-category-arrow {
        color: #000000;
        padding: 10px 20px;
        margin-left: 8px;
        opacity: 0.6;
        transition: opacity 0.2s;
    }

    .nav-category-item .nav-category-arrow {
        opacity: 1;
        /* background: rgb(0 216 227 / 87%); */
        border-radius: 4px;
    }

    .nav-category-item .nav-category-arrow:hover {
        opacity: 1;
        background: rgb(0 216 227 / 87%);
        border-radius: 4px;
    }

    .nav-category-end-icon {
        opacity: 0.8;
        padding: 10px 20px;
    }

    /* Loading Indicator */


    .nav-empty-category-message,
    .nav-error-message {
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
        background: #e0000000;
    }

    .nav-category-list::-webkit-scrollbar-thumb,
    .nav-categories-wrapper::-webkit-scrollbar-thumb {
        background: rgb(0 216 227 / 87%);
        /* border-radius: 4px; */
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

    /* Ensure modal/navbar breadcrumbs keep their teal/white colors even if other pages
       override global .breadcrumb styles (increase specificity and use !important).
       This prevents document/listing pages from turning navbar breadcrumbs grey. */
    #categoryModal .breadcrumb-item a,
    .breadcrumb-nav .breadcrumb-item a {
        color: #00e6e6 !important;
    }

    #categoryModal .breadcrumb-item.active,
    .breadcrumb-nav .breadcrumb-item.active {
        color: #ffffff !important;
    }

    .breadcrumb-item.active {
        color: #ffffff;
    }

    .breadcrumb-item+.breadcrumb-item::before {
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
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    #search-input:focus {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        margin-top: 5px;
        display: none;
    }

    /* Search result items */
    #search-suggestions .list-group-item {
        border: none;
        border-bottom: 1px solid #eee;
        padding: 15px;
        transition: all 0.2s ease;
    }

    #search-suggestions .list-group-item:last-child {
        border-bottom: none;
    }

    #search-suggestions .list-group-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
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
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
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

    .no-hover-effect {
        text-decoration: none:important;
        color: inherit !important;
        border: none !important;
        background: none !important;
        box-shadow: none !important;
        opacity: 1 !important;
    }

    .btn:hover {
        background-color: rgb(28, 26, 26);
        color: white !important;
    }
</style>