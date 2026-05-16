<!-- resources/views/admin/category/partials/category_option.blade.php -->

<!-- Display the category itself -->
<option value="{{ $category->id }}" {{ isset($selectedCategoryId) && $selectedCategoryId == $category->id ? 'selected' : '' }}>
    {{ str_repeat('--', $level) }} {{ $category->name }}
</option>

<!-- Recursively display child categories if they exist -->
@foreach ($category->children as $child)
    @include('admin.category.partials.category_option', ['category' => $child, 'level' => $level + 1])
@endforeach
