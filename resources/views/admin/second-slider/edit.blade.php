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
            <li class="breadcrumb-item active">Edit Sigle Slider</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

<div class="row">
    <div class="col-md-12">
        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3>Edit Sigle Slider
                    <a href="{{ url('admin/secondsliders') }}" class="btn btn-danger btn-sm float-end">Back</a>
                </h3>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.secondsliders.update', $secondSlider->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Title</label>
                        <div class="col-sm-9">
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" value="{{ old('title', $secondSlider->title) }}">
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $secondSlider->description) }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Current Image</label>
                        <div class="col-sm-9">                            @if ($secondSlider->image)
                                <img src="{{ url('uploads/second-slider/' . $secondSlider->image) }}" alt="Second Slider Image" style="height: 100px;">
                            @else
                                <p>No image available</p>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Update Image</label>
                        <div class="col-sm-9">
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select name="status" class="form-select">
                                <option value="0" {{ $secondSlider->status == 0 ? 'selected' : '' }}>Visible</option>
                                <option value="1" {{ $secondSlider->status == 1 ? 'selected' : '' }}>Hidden</option>
                            </select>
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
