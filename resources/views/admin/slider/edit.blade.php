@extends('layouts.admin')

@section('content')


<div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-6">
          <h3>Main Silder</h3>
        </div>
        <div class="col-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html" data-bs-original-title="" title="">                                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
            <li class="breadcrumb-item">Main Slider</li>
            <li class="breadcrumb-item active">Main Slider Edit</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Edit Main Slider
                    <a href="{{ url('admin/sliders') }}" class="btn btn-danger btn-sm float-end">Back</a>
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Title</label>
                        <div class="col-sm-9">
                        <input class="form-control" type="text" name="title" value="{{ $slider->title }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                        <input class="form-control" type="text" name="description" value="{{ $slider->description }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Image</label>
                        <div class="col-sm-9">
                            <img src="{{ asset('uploads/slider/' . $slider->image) }}" alt="Slider Image" style="height: 100px;">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Update Image</label>
                        <div class="col-sm-9">
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Status</label>
                          <div class="col-sm-9">
                          <input class="checkbox_animated" name="status" id="chk-ani" type="checkbox" {{ $slider->status == '1' ? 'checked' : '' }}> Checked=Hidden , UnChecked=Visiable
                          </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
