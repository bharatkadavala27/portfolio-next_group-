@extends('layouts.admin')

@section('content')

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h3>All Sliders </h3>
      </div>
      <div class="col-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ url('admin/dashboard') }}" title="Home">
              <i class="feather icon-home"></i>
            </a>
          </li>
          <li class="breadcrumb-item">All Sliders</li>
          <li class="breadcrumb-item active">All Slider View</li>
        </ol>
      </div>
    </div>
  </div>
</div>

@if(session('message'))
  <div class="container-fluid">
    <div class="alert alert-success">{{ session('message') }}</div>
  </div>
@endif
@if(session('error'))
  <div class="container-fluid">
    <div class="alert alert-danger">{{ session('error') }}</div>
  </div>
@endif

@include('admin.slider.partials.slider_section', [
  'title' => 'Home Page Main Slider',
  'route_create' => url('admin/sliders/create'),
  'items' => $sliders,
  'image_path' => 'uploads/slider/',
  'edit_route' => 'admin.sliders.edit',
  'delete_route' => 'admin.sliders.destroy',
  'note' => 'Recommended size: 1600px × 630px'
])

@include('admin.slider.partials.slider_section', [
  'title' => 'Two Image Slider',
  'route_create' => url('admin/twoimageslider/create'),
  'items' => $twoImageSliders,
  'image_path' => 'uploads/two-image-slider/',
  'edit_route' => 'admin.twoimageslider.edit',
  'delete_route' => 'admin.twoimageslider.destroy',
  'note' => 'Recommended size: 700px × 400px'
])

@include('admin.slider.partials.slider_section', [
  'title' => 'Single Page Second Slider',
  'route_create' => route('admin.secondsliders.create'),
  'items' => $secondSlider,
  'image_path' => 'uploads/second-slider/',
  'edit_route' => 'admin.secondsliders.edit',
  'delete_route' => 'admin.secondsliders.destroy',
  'note' => 'Recommended size: 1200px × 350px'
])

@include('admin.slider.partials.slider_section', [
  'title' => 'Three Img Last Slider',
  'route_create' => url('admin/minisiders/create'),
  'items' => $minisiders,
  'image_path' => 'uploads/mini-slider/',
  'edit_route' => 'admin.minisiders.edit',
  'delete_route' => 'admin.minisiders.destroy',
  'note' => 'Recommended size:700px × 400px'
])  


@endsection
