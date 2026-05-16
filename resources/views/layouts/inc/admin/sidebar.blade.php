<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('admin.dashboard') }}">
                <img class="img-fluid for-light" style="height: 52px;" src="{{ asset('assets/silder/logo.jpg') }}"
                    alt="">
                {{-- <img class="img-fluid for-dark" src="{{ asset('admin/logo/logo_dark.png') }}" alt=""> --}}

            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            {{-- <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div> --}}
        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid"
                    src="{{ asset('admin/images/logo/logo-icon.png') }}" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="#"><img class="img-fluid"
                                src="{{ asset('admin/images/logo/logo-icon.png') }}" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-main-title mt-3">
                        <div>
                            <h6 class="lan-1">General</h6>
                            <p class="lan-2">Dashboards,widgets & layout.</p>
                        </div>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                            <i data-feather="home"></i><span class="lan-3">Dashboard</span>
                        </a>
                    </li>


                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                                data-feather="airplay"></i><span>Brands</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ url('admin/brands/create') }}">Add Brand</a></li>
                            <li><a href="{{ url('admin/brands') }}">View Brand</a></li>
                        </ul>
                    </li>



                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i
                                data-feather="layout"></i><span>Category</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ url('admin/categories/create') }}">Add Category</a></li>
                            <li><a href="{{ url('admin/categories') }}">View Category</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i data-feather="book"></i><span>News</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.news.create') }}">Add News</a></li>
                            <li><a href="{{ route('admin.news') }}">View News</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i data-feather="shopping-bag"></i><span>Product</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ url('admin/products/create') }}">Add Product</a></li>
                            <li><a href="{{ url('/admin/products') }}">View Product</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i data-feather="filter"></i><span>Filters</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.filters.create') }}">Create Filter</a></li>
                            <li><a href="{{ route('admin.filters.index') }}">View Filter</a></li>
                            <!-- <li><a href="{{ route('admin.filters.index') }}">Filter Sequence</a></li> -->

                        </ul>
                    </li>


                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"
                            data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-settings">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 5 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                            </svg>
                            <span>Setting</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: none;">
                            <li><a href="{{ url('admin/settings/about-us') }}">About-Us</a></li>
                            <li><a href="{{ url('admin/contact-us-details/index') }}">View Contact-us-Details</a></li>
                            <li><a class="submenu-title" href="#" data-bs-original-title=""
                                    title="">HomePage
                                    Setting<span class="sub-arrow"><i class="fa fa-angle-right"></i></span>
                                    <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content" style="display: none;">
                                    <li><a href="{{ url('admin/all-slider') }}">View Sliders</a></li>
                                    <li><a href="{{ url('admin/videos') }}">Add YT Video</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>


                    <li class="sidebar-list mb-4">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i data-feather="file-text"></i><span>Downloads Section</span>
                        </a>
                        <ul class="sidebar-submenu mb-4">
                            
                            <li>
                                <a class="submenu-title" href="#">Download Type<span class="sub-arrow"><i class="fa fa-angle-right"></i></span>
                                    <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content" style="display: none;">
                                    <li><a href="{{ route('document-types.create') }}">Add Download Type</a></li>
                                    <li><a href="{{ url('admin/document-types') }}">View Download Type</a></li>
                                </ul>
                            </li>

                            <li>
                                <a class="submenu-title" href="#">Download Brand<span class="sub-arrow"><i class="fa fa-angle-right"></i></span>
                                    <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content" style="display: none;">
                                    <li><a href="{{ route('admin.document-brands.create') }}">Add Download Brand</a></li>
                                    <li><a href="{{ route('admin.document-brands.index') }}">View Download Brand</a></li>
                                </ul>
                            </li>

                            <li>
                                <a class="submenu-title" href="#">Download Category<span class="sub-arrow"><i class="fa fa-angle-right"></i></span>
                                    <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content" style="display: none;">
                                    <li><a href="{{ route('admin.document-category.create') }}">Add Download Category</a></li>
                                    <li><a href="{{ route('admin.document-category.index') }}">View Download Category</a></li>
                                </ul>
                            </li>

                            <li><a href="{{ route('admin.documents-sections.create') }}">Add Download</a></li>
                            <li><a href="{{ route('admin.documents-sections.index') }}">View Download</a></li>
                            
                        </ul>
                    </li>

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>