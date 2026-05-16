<div class="category-item level-{{ $level }} {{ $category->children->count() === 0 ? 'no-children' : '' }}">
    <div class="category-row">
        <button class="expand-btn {{ $category->children->count() === 0 ? 'no-children' : 'expanded' }}" {{ $category->children->count() === 0 ? 'disabled' : '' }}>
        </button>

        <span class="category-name" title="{{ $category->name }}">
            {{ $category->name }}
        </span>

        <div class="category-actions">
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-success btn-sm">Edit</a>
            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this category?');" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>
    </div>

    @if ($category->children->count() > 0)
        <div class="children-container">
            @foreach ($category->children as $child)
                @include('admin.category.category_item', ['category' => $child, 'level' => $level + 1])
            @endforeach
        </div>
    @endif
</div>