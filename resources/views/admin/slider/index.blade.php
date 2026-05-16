@extends('layouts.admin')

@section('content')


<!-- Page Title -->
<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h3>Main Silder</h3>
      </div>
      <div class="col-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html" data-bs-original-title="" title=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
          <li class="breadcrumb-item">Main Slider</li>
          <li class="breadcrumb-item active"> Main Slider View</li>
        </ol>
      </div>
    </div>
  </div>
</div>


<!-- Loop through sliders -->
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h3>Add Main Slider
              <a href="{{ url('admin/sliders/create')}}" class="btn btn-danger btn-sm text-white float-end">Add</a>
          </h3>
        </div>

        @if(session('message'))
            <div class="alert alert-success">{{session('message')}}</div>
        @endif   

        @if(session('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
        @endif 
        
        <div class="card-body">
          <div class="table-responsive product-table">
            <table class="display dataTable no-footer">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Image</th>
                  <th>Details</th>
                  <th>Status</th>
                  <th>Created At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($sliders as $slider)
                <tr>
                  <td>{{ $slider->id }}</td>
                  <td>{{ $slider->title }}</td>
                  <td>
                    @if(isset($slider->image) && $slider->image)
                        <img src="{{ asset('/uploads/slider/' . $slider->image) }}" alt="{{ $slider->title }}" style="width: 70px; height: 70px; border-radius: 50%;">
                    @else
                        <span>No Image Available</span>
                    @endif
                </td>

                  <td>
                    <p>{{ $slider->description }}</p>
                  </td>
                  <td>{{ $slider->status }}</td>
                  <td>{{ $slider->created_at }}</td>
                  <td>
                    <!-- Edit Button -->
                    <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-success btn-sm">
                      Edit
                    </a>

                    <!-- Delete Button (Form Approach) -->
                    <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this slider?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">
                          Delete
                      </button>
                  </form>

                </td>

                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
