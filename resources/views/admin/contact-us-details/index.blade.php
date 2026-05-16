@extends('layouts.admin')

@section('title', 'Contact Us Details')

@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin">

            @if (session('message'))
            <div class="alert alert-success mb-3">{{session('message')}}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary fs-3">Contact-Us Details</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Loop through contact-us details --}}
                            @foreach ($contactUsDetails as $detail)
                            <tr>
                                <td>{{ $detail->id }}</td>
                                <td>{{ $detail->address }}</td>
                                <td>{{ $detail->phone }}</td>
                                <td>{{ $detail->email }}</td>
                                <td>
                                    <a href="{{ url('admin/contact-us-details/'.$detail->id.'/edit') }}" class="btn btn-primary btn-sm">Edit</a>
                                    {{-- <form action="{{ url('admin/contact-us-details/'.$detail->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form> --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection
