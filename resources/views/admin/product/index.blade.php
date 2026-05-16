@extends('layouts.admin')

@section('content')
    <style>
        .product-name {
            max-width: 200px;
            white-space: normal;
            word-wrap: break-word;
        }
    </style>
    <div class="container-fluid mt-5">
        <!-- Page Title and Breadcrumb -->
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Product List</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('dashboard') }}" title="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </a>
                        </li>
                        <li class="breadcrumb-item">Products</li>
                        <li class="breadcrumb-item active">Product List</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Add New Product Button -->
        <div class="mb-4 text-right">
            <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add New Product</a>
        </div>

        <!-- Product Table -->
        <div class="card">
            <div class="card-header">
                <h5>Individual column searching (text inputs)</h5>
                <span>The searching functionality provided by DataTables is useful for quickly search through the information in the table - however the search is global, and you may wish to present controls that search on specific columns.</span>
            </div>
            <div class="card-body">
                <!-- Success/Error Message -->
                @if (session('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive product-table">
                    <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                        <table class="display dataTable" id="basic-1">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="product-name">{{ $product->name }}</td>
                                        <td>${{ number_format($product->price, 2) }}</td>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        <td>
                                            <div style="display: flex; gap: 5px;">
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Edit">
                                                    Edit
                                                </a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        data-bs-toggle="tooltip" title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                                        Delete
                                                    </button>
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
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#basic-1').DataTable({
            pageLength: 10,
            searching: true,
            dom: 'rtip', // This removes the default "Show X entries" dropdown
            language: {
                paginate: {
                    next: 'Next',
                    previous: 'Previous'
                }
            }
        });
    });
</script>
@endpush
