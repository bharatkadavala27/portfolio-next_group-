<tr>
    <td>{{ $category->id }}</td>
    <td>{{ $category->name }}</td>
    <td>{{ $category->parent ? $category->parent->name : 'N/A' }}</td>
    <td>
        <a href="{{ route('admin.document-category.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('admin.document-category.destroy', $category->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
        </form>
    </td>
</tr>
@if ($category->children)
    @foreach ($category->children as $child)
        @include('admin.document-category.category_item', ['category' => $child, 'level' => $level + 1])
    @endforeach
@endif

<script>
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to delete this category?')) {
                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this)
                }).then(response => {
                    if (response.ok) {
                        window.location.href = "{{ route('admin.document-category.index') }}";
                    }
                });
            }
        });
    });
</script>
