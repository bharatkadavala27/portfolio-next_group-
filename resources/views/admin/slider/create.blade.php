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
            <li class="breadcrumb-item"><a href="index.html" data-bs-original-title="" title=""> <svg
                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-home">
                  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                  <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg></a></li>
            <li class="breadcrumb-item">Main Silder</li>
            <li class="breadcrumb-item active">Main Silder Add</li>
          </ol>
        </div>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3>Add Main Slider
            <a href="{{ url('admin/sliders')}}" class="btn btn-danger btn-sm text-white float-end">Back</a>
          </h3>
        </div>
        <div class="card-body">
          <form action="{{ url('admin/sliders/create')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 row">
              <label class="col-sm-3 col-form-label">Title</label>
              <div class="col-sm-9">
                <input class="form-control" type="text" name="title">
              </div>
            </div>
            <div class="mb-3 row">
              <label class="col-sm-3 col-form-label">Description</label>
              <div class="col-sm-9">
                <input class="form-control" type="text" name="description">
              </div>
            </div>
            <div class="mb-3 row">
              <label class="col-sm-3 col-form-label">Upload File</label>
              <div class="col-sm-9">
                <input class="form-control" type="file" name="image">
              </div>
            </div>
            <div class="mb-3 row">
              <label class="col-sm-3 col-form-label">Status</label>
              <div class="col-sm-9">
                <input class="checkbox_animated" name="status" id="chk-ani" type="checkbox"> Checked=Hidden ,
                UnChecked=Visiable
              </div>
            </div>
            <div class="mb-3">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
@endsection