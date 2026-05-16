<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h3>{{ $title }}
            <a href="{{ $route_create }}" class="btn btn-danger btn-sm float-end">Add New Slider</a>
          </h3>
          @isset($note)
            <small class="text-muted"> {{ $note }} </small>
          @endisset
        </div>

        <div class="card-body">
          <div class="table-responsive product-table">
            <table class="table table-striped">
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
                @foreach ($items as $item)
                <tr>
                  <td>{{ $item->id }}</td>
                  <td>{{ $item->title }}</td>
                  <td>
                    @if($item->image)
                      <img src="{{ url($image_path . $item->image) }}" alt="{{ $item->title }}" style="width: 70px; height: 70px; border-radius: 50%;">
                    @else
                      <span>No Image</span>
                    @endif
                  </td>
                  <td>{{ $item->description }}</td>
                  <td>
                    <span class="badge {{ $item->status ? 'bg-danger' : 'bg-success' }}">
                      {{ $item->status ? 'Hidden' : 'Visible' }}
                    </span>
                  </td>
                  <td>{{ $item->created_at }}</td>
                  <td>
                    <a href="{{ route($edit_route, $item->id) }}" class="btn btn-success btn-sm">Edit</a>
                    <form action="{{ route($delete_route, $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
