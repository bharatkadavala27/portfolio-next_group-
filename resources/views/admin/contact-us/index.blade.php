@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Contact-Us</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item">Contact Us</li>
                    <li class="breadcrumb-item active">Contact-Us View</li>
                </ol>
            </div>
        </div>
    </div>
</div>



<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">List of Contact Form Submissions</h4>
        </div>
        <div class="card-body">
            @if($submissions->isEmpty())
                <div class="alert alert-warning" role="alert">
                    No form submissions available.
                </div>
            @else
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $submission)
                            <tr>
                                <td>{{ $submission->name }}</td>
                                <td>{{ $submission->email }}</td>
                                <td>{{ $submission->phone }}</td>
                                <td>{{ $submission->message }}</td>
                                <td>{{ $submission->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $submissions->links('pagination::bootstrap-4') }}
                </div> --}}
            @endif
        </div>
    </div>
</div>
@endsection
