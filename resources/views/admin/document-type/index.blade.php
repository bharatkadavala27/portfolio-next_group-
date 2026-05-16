@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <h3>Download Types</h3>
    </div>

    <div class="card">
        <div class="card-header">
            <!-- <h5>Download Types</h5> -->
            <a href="{{ route('admin.document-types.create') }}" class="btn btn-primary btn-sm float-end">Add New</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Serial Number</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documentTypes as $documentType)
                        <tr>
                            <td>{{ $documentType->id }}</td>
                            <td>{{ $documentType->name }}</td>
                            <td>{{ $documentType->serial_number }}</td>
                            <td>{{ $documentType->description }}</td>
                            <td>
                                @if($documentType->image)
                                    <img src="{{ asset('document-types/' . $documentType->image) }}" alt="{{ $documentType->name }}" class="img-thumbnail" style="max-width: 100px;">
                                @endif
                            </td>
                            <td class="text-nowrap">
                                <div class="d-flex align-items-center gap-1">
                                    <a href="{{ route('admin.document-types.edit', $documentType->id) }}" class="btn btn-success btn-sm">Edit</a>
                                    <form action="{{ route('admin.document-types.destroy', $documentType->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this document type?');" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
