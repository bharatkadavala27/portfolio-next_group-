@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Filter List</h4>
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="mb-4 d-flex justify-content-between">
                    <a href="{{ route('admin.filters.create') }}" class="btn btn-primary">
                        + Add New Filter
                    </a>
                </div>
                <div class="mb-3">
                    <div class="alert alert-info mb-0" role="alert">
                        Tip: Set the <strong>Sequence</strong> value to <strong>0</strong> to hide that filter option on the frontend.
                    </div>
                </div>

                <form action="{{ route('admin.filters.sequence-update') }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="display dataTable" id="filters-table">
                            <thead>
                                <tr>
                                    <th>Sequence</th>
                                    <th>Download Sequence</th>
                                    <th>Filter Name</th>
                                    <th>Type</th>
                                    <th>Options</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($filters as $filter)
                                    <tr>
                                        <td width="100">
                                            <input type="number" name="sequences[{{ $filter->id }}]"
                                                value="{{ $filter->sequence }}" class="form-control" style="width: 80px;">
                                        </td>
                                        <td width="100">
                                            <input type="number" name="download_sequences[{{ $filter->id }}]"
                                                value="{{ $filter->download_sequence }}" class="form-control"
                                                style="width: 80px;">
                                        </td>
                                        <td>
                                            {{ $filter->name }}
                                            @if($filter->key)
                                                <span class="badge bg-info">System</span>
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($filter->type) }}</td>
                                        <td>
                                            @foreach($filter->options as $option)
                                                <span class="badge bg-secondary">{{ $option->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 5px;">
                                                @if(!$filter->key)
                                                    <a href="{{ route('admin.filters.edit', $filter->id) }}"
                                                        class="btn btn-success btn-sm">Edit</a>
                                                @endif
                                                @if(!$filter->key)
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Are you sure?')) { 
                                                                                                                        event.preventDefault(); 
                                                                                                                        document.getElementById('delete-filter-form').action = '{{ route('admin.filters.destroy', $filter->id) }}'; 
                                                                                                                        document.getElementById('delete-filter-form').submit(); 
                                                                                                                    }">
                                                        Delete
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Update Sequence</button>
                    </div>
                </form>

                <form id="delete-filter-form" action="" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#filters-table').DataTable({
                pageLength: 10,
                searching: true,
                dom: 'rtip',
                language: {
                    paginate: { next: 'Next', previous: 'Previous' }
                }
            });
        });
    </script>
@endpush