<option value="{{ $category->id }}"
    {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
    {{ str_repeat('--', $level) }} {{ $category->name }}
</option>
@if ($category->children)
    @foreach ($category->children as $childCategory)
        @include('admin.product.partials.category-options', ['category' => $childCategory, 'level' => $level + 1])
    @endforeach
@endif
