@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-6">
          <h3>Sigle Silder</h3>
        </div>
        <div class="col-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html" data-bs-original-title="" title="">                                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
            <li class="breadcrumb-item">Sigle Slider</li>
            <li class="breadcrumb-item active">View Sigle Slider</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3>Sigle Slider
                        <a href="{{ route('admin.secondsliders.create') }}" class="btn btn-danger btn-sm float-end">Add New</a>
                    </h3>
                </div>
                
                <div class="card-body">
                    @if(session('message'))
                    <div class="alert alert-success">{{session('message')}}</div>
                @endif   
        
                @if(session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
                @endif 

                    <div class="table-responsive product-table">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($secondSlider as $slider)
                                    <tr>
                                        <td>{{ $slider->id }}</td>
                                        <td>{{ $slider->title }}</td>
                                        <td>
                                            @if ($slider->image)
                                            <img src="{{ asset('/uploads/second-slider/' . $slider->image) }}" alt="Slider Image" style="width: 70px; height: 70px; border-radius: 50%;">
                                            @else
                                            <span>No Image Available</span>
                                            @endif
                                        </td>
                                        <td>{{ $slider->description }}</td>
                                        <td>
                                            <span class="badge {{ $slider->status ? 'bg-danger' : 'bg-success' }}">
                                                {{ $slider->status ? 'Hidden' : 'Visible' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.secondsliders.edit', $slider->id) }}" class="btn btn-success btn-sm">Edit</a>
                                            <form action="{{ route('admin.secondsliders.destroy', $slider->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this slider?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Add Pagination if applicable -->
                        {{-- {{ $secondSlider->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
