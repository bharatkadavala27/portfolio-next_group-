<div class="category-item level-{{ $level }}">
    <div class="category-row">

        {{-- Expand --}}
        <button class="expand-btn
            {{ $category->children->count() ? 'collapsed' : 'no-children' }}">
        </button>

        {{-- Name --}}
        <div class="category-name">
            {{ $category->name }}
        </div>

        {{-- Actions --}}
        <div class="category-actions">
            <a href="{{ route('admin.document-categories.edit', $category->id) }}"
               class="btn btn-success btn-sm">
                Edit
            </a>

            <form action="{{ route('admin.document-categories.destroy', $category->id) }}"
                  method="POST"
                  class="delete-form">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">
                    Delete
                </button>
            </form>
        </div>
    </div>

    {{-- Children --}}
    @if($category->children->count())
        <div class="children-container collapsed">
            @foreach($category->children as $child)
                @include('admin.document-category.tree-item', [
                    'category' => $child,
                    'level' => $level + 1
                ])
            @endforeach
        </div>
    @endif
</div>
