{{-- <div class="category-item" data-category-id="{{ $category->id }}">
    <a href="javascript:void(0);" class="category-name">{{ $category->name }}</a>

    @if ($category->children->isNotEmpty())
        <ul class="child">
            @foreach ($category->children as $child)
                @include('partials.child-category', ['category' => $child])
            @endforeach
        </ul>
    @endif 
</div>

<style>
/* Parent category styling */
.category-item {
    position: relative;
    background-color: #2973B9; /* Match the main navbar color */
    border-bottom: 1px solid white; /* Match the main navbar style */
    margin-bottom: 1px;
}

.category-item a {
    padding: 8px 16px;  /* Padding to match the navbar */
    color: white; /* Change text color to white */
    text-decoration: none;
    display: block;
    font-size: 14px;  /* Font size to match the navbar */
}

/* Hover effect: show child categories */
.category-item:hover > .child {
    display: block;
}

/* Child categories (subcategories) styling */
.child {
    display: none;
    background-color: #E4EFF7; /* Match the existing child background color */
    position: absolute;
    left: 100%;  /* Move child to the right */
    top: 0;
    min-width: 150px;  /* Set a smaller width */
    border-left: 1px solid #b5b5b5;
    padding: 0;
    list-style: none;
    margin: 0;
}

.child li {
    line-height: 30px;  /* Smaller line-height */
    border-bottom: 1px solid #b5b5b5;
    border-right: 1px solid #b5b5b5;
}

.child li a {
    color: #000000; /* Text color for child links */
    padding: 8px 16px;  /* Padding to match the navbar */
    text-decoration: none;
    display: block;
    font-size: 13px;  /* Font size for child links */
}

/* Hover effect for child links */
.child li a:hover {
    background-color: #95B4CA; /* Hover color for child links */
}

/* Styling for the parent categories when hovered */
.category-item a:hover {
    background-color: #f0f0f0; /* Hover effect for parent category */
}

/* Optional: add a small arrow to indicate more options */
.expand {
    font-size: 12px;
    float: right;
    margin-right: 5px;
}

</style>

<script>
    document.querySelectorAll('.category-name').forEach(function (categoryNameElement) {
        categoryNameElement.addEventListener('click', function () {
            const parent = this.closest('.category-item'); // Corrected to find the closest .category-item
            const childElement = parent.querySelector('.child'); // This will find the child categories

            // Check if there are no child categories
            if (!childElement || childElement.children.length === 0) {
                const categoryId = parent.getAttribute('data-category-id');
                if (categoryId) {
                    window.location.href = `/category/${categoryId}`; // Redirect to the category page
                }
            }
        });
    });
</script>


 --}}
