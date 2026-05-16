@extends('layouts.admin')

@push('styles')
<style>
    .table td, .table th {
        white-space: nowrap !important;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }

    .table td:first-child {
        width: 50px !important;
        min-width: 50px !important;
    }

    .table td:last-child {
        white-space: nowrap !important;
        width: 150px !important;
        min-width: 150px !important;
    }

    .table {
        table-layout: fixed !important;
        width: 100% !important;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
        white-space: nowrap;
    }

    .action-buttons form {
        margin: 0;
    }

    .action-buttons .btn {
        min-width: 60px;
        white-space: nowrap;
    }

    .card .card-body{
        padding: 10px!important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-header">
                    <h4>Downloads Sections
                        <a href="{{ route('admin.documents-sections.create') }}" class="btn btn-primary float-end">Add Document</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Brand</th>
                                {{-- <th>Files</th> --}}
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $index => $document)
                                <tr>
                                    <td style="word-break:keep-all!important">{{ $index + 1 }}</td>
                                    <td>{{ $document->document_name }}</td>
                                    <td>{{ $document->document_type }}</td>
                                    <td>{{ $document->category_display }}</td>
                                    <td>{{ $document->document_brand }}</td>
                                    {{-- <td>
                                        @if($document->documents)
                                            @foreach(explode(',', $document->documents) as $index => $file)
                                                <div>
                                                    <a href="{{ url(explode(',', $document->file_path)[$index] ?? '') }}" target="_blank">
                                                        {{ $file }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif
                                    </td> --}}
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.documents-sections.edit', $document->id) }}"
                                               class="btn btn-success btn-sm">Edit</a>
                                            <form action="{{ route('admin.documents-sections.destroy', $document->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this document?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No documents found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
