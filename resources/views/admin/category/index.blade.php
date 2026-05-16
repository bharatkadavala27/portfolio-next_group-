@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Modern Header -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h2 class="mb-1 fw-bold text-dark">Categories</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin') }}" class="text-decoration-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item">Category</li>
                        <li class="breadcrumb-item active">All Categories</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary px-4 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add Category
            </a>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Modern Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <!-- Search and Filter Bar -->
            <div class="p-4 border-bottom bg-light">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0" id="searchCategories" placeholder="Search categories...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2 justify-content-md-end">
                            <button class="btn btn-outline-secondary" id="expandAll">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                    <polyline points="17 11 12 6 7 11"></polyline>
                                    <polyline points="17 18 12 13 7 18"></polyline>
                                </svg>
                                Expand All
                            </button>
                            <button class="btn btn-outline-secondary" id="collapseAll">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                    <polyline points="7 13 12 18 17 13"></polyline>
                                    <polyline points="7 6 12 11 17 6"></polyline>
                                </svg>
                                Collapse All
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Tree -->
            <div class="category-tree p-3">
                @foreach ($parentCategories as $category)
                    @include('admin.category.category_item', ['category' => $category, 'level' => 0])
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-color: #0d6efd;
    --hover-bg: #f8f9fa;
    --border-color: #e5e7eb;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.category-tree {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

.category-item {
    margin-bottom: 2px;
}

.category-row {
    display: flex;
    align-items: center;
    padding: 14px 16px;
    background: #fff;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    margin-left: calc(var(--level, 0) * 32px);
    position: relative;
    margin-bottom: 2px;
}

.category-item.level-0 .category-row {
    --level: 0;
    background: linear-gradient(to right, #ffffff 0%, #f9fafb 100%);
    font-weight: 500;
}

.category-item.level-1 .category-row {
    --level: 1;
}

.category-item.level-2 .category-row {
    --level: 2;
}

.category-item.level-3 .category-row {
    --level: 3;
}

.category-item.level-4 .category-row {
    --level: 4;
}

.category-row::before {
    content: '';
    position: absolute;
    left: -16px;
    top: 50%;
    width: 12px;
    height: 1px;
    background: var(--border-color);
    display: none;
}

.category-item:not(.level-0) .category-row::before {
    display: block;
}

.category-row:hover {
    background-color: var(--hover-bg);
    border-color: #cbd5e1;
    transform: translateX(2px);
    box-shadow: var(--shadow-sm);
}

.expand-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    padding: 0;
    margin-right: 12px;
    border: 1px solid var(--border-color);
    background: #fff;
    border-radius: 6px;
    cursor: pointer;
    color: var(--text-secondary);
    transition: all 0.2s ease;
    font-size: 12px;
    flex-shrink: 0;
}

.expand-btn:hover:not(:disabled) {
    color: var(--primary-color);
    background-color: #eff6ff;
    border-color: var(--primary-color);
    transform: scale(1.05);
}

.expand-btn:disabled {
    cursor: default;
    opacity: 0.4;
}

.expand-btn.no-children {
    border-color: transparent;
    background: transparent;
}

.expand-btn {
    position: relative;
}

.expand-btn::after {
    content: '▶';
    position: absolute;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.expand-btn.collapsed::after {
    transform: rotate(0deg);
}

.expand-btn.expanded::after {
    transform: rotate(90deg);
}

.category-name {
    flex: 1;
    font-weight: 500;
    color: var(--text-primary);
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.category-name::before {
    content: '';
    width: 6px;
    height: 6px;
    /* background: var(--primary-color); */
    border-radius: 50%;
    display: inline-block;
    opacity: 0.6;
}

.category-item.level-0 .category-name::before {
    width: 8px;
    height: 8px;
    opacity: 1;
}

.category-actions {
    display: flex;
    gap: 8px;
    margin-left: auto;
    flex-shrink: 0;
    opacity: 1;
    transition: opacity 0.2s ease;
}

.category-actions .btn {
    padding: 6px 14px;
    font-size: 13px;
    white-space: nowrap;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.category-actions .btn-success {
    background: #10b981;
    border-color: #10b981;
}

.category-actions .btn-success:hover {
    background: #059669;
    border-color: #059669;
    transform: translateY(-1px);
}

.category-actions .btn-danger {
    background: #ef4444;
    border-color: #ef4444;
}

.category-actions .btn-danger:hover {
    background: #dc2626;
    border-color: #dc2626;
    transform: translateY(-1px);
}

.children-container {
    max-height: 999999px;
    overflow: visible;
    transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
    opacity: 1;
}

.children-container.collapsed {
    max-height: 0;
    overflow: hidden;
    opacity: 0;
}

.category-item.no-children .expand-btn::after {
    content: '•';
    opacity: 0.3;
    font-size: 14px;
}

/* Modern Alert Styling */
.alert-success {
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    color: #065f46;
    border-radius: 8px;
    display: flex;
    align-items: center;
}

/* Card Enhancements */
.card {
    border-radius: 12px;
    overflow: hidden;
}

/* Search Input Styling */
.input-group-text {
    color: var(--text-secondary);
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
}

/* Button Styling */
.btn-outline-secondary {
    border-color: var(--border-color);
    color: var(--text-secondary);
}

.btn-outline-secondary:hover {
    background: var(--hover-bg);
    border-color: #cbd5e1;
    color: var(--text-primary);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle expand/collapse buttons
    const expandButtons = document.querySelectorAll('.expand-btn');
    
    expandButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const container = this.closest('.category-item').querySelector('.children-container');
            
            if (container) {
                this.classList.toggle('collapsed');
                this.classList.toggle('expanded');
                container.classList.toggle('collapsed');
            }
        });
    });

    // Initialize: set all containers as COLLAPSED by default
    document.querySelectorAll('.expand-btn').forEach(btn => {
        const container = btn.closest('.category-item').querySelector('.children-container');
        if (container && container.children.length > 0) {
            btn.classList.add('collapsed');
            btn.classList.remove('expanded');
            container.classList.add('collapsed');
        }
    });

    // Expand All functionality
    document.getElementById('expandAll').addEventListener('click', function() {
        document.querySelectorAll('.expand-btn').forEach(btn => {
            const container = btn.closest('.category-item').querySelector('.children-container');
            if (container && container.children.length > 0) {
                btn.classList.remove('collapsed');
                btn.classList.add('expanded');
                container.classList.remove('collapsed');
            }
        });
    });

    // Collapse All functionality
    document.getElementById('collapseAll').addEventListener('click', function() {
        document.querySelectorAll('.expand-btn').forEach(btn => {
            const container = btn.closest('.category-item').querySelector('.children-container');
            if (container && container.children.length > 0) {
                btn.classList.add('collapsed');
                btn.classList.remove('expanded');
                container.classList.add('collapsed');
            }
        });
    });

    // Search functionality
    document.getElementById('searchCategories').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const categories = document.querySelectorAll('.category-item');
        
        categories.forEach(category => {
            const categoryName = category.querySelector('.category-name').textContent.toLowerCase();
            const categoryRow = category.querySelector('.category-row');
            
            if (categoryName.includes(searchTerm)) {
                categoryRow.style.display = 'flex';
                // Show parent categories
                let parent = category.parentElement;
                while (parent) {
                    if (parent.classList.contains('children-container')) {
                        parent.classList.remove('collapsed');
                        const expandBtn = parent.previousElementSibling?.querySelector('.expand-btn');
                        if (expandBtn) {
                            expandBtn.classList.remove('collapsed');
                            expandBtn.classList.add('expanded');
                        }
                    }
                    parent = parent.parentElement;
                }
            } else {
                categoryRow.style.display = searchTerm ? 'none' : 'flex';
            }
        });
    });
});
</script>

@endsection