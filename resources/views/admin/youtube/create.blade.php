@extends('layouts.admin')

@section('content')

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Videos</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </a>
                        </li>
                        <li class="breadcrumb-item">Videos</li>
                        <li class="breadcrumb-item active">Manage Videos</li>
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
                        <h3>
                            View Videos
                            <button class="btn btn-primary btn-sm text-white float-end" data-bs-toggle="modal"
                                data-bs-target="#videoModal" onclick="openAddModal()">
                                Add Video
                            </button>
                        </h3>
                    </div>

                    <div class="card-body">

                        @if(session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="table-responsive product-table">
                            <table class="display dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Video</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($videos as $video)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $video->title }}</td>
                                            <td>
                                                <div style="width:120px;height:70px;overflow:hidden;border-radius:6px;">
                                                    {!! $video->youtube_embed_code !!}
                                                </div>
                                            </td>
                                            <td>{{ $video->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-success btn-sm"
                                                        onclick='openEditModal(@json($video))'>
                                                        Edit
                                                    </button>

                                                    <form action="{{ url('/admin/videos/delete/' . $video->id) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <div class="alert alert-info mb-0">
                                                    No videos found.
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Video Modal (unchanged logic) --}}
    <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form id="videoForm" method="POST" action="{{ route('videos.store') }}">
                @csrf
                {{-- Hidden input for spoofing PUT method if needed --}}
                <div id="methodField"></div>

                <input type="hidden" name="video_id" id="video_id">

                <div class="modal-content border-0 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">YouTube Embed Code</label>
                            <textarea id="youtube_embed_code" name="youtube_embed_code" class="form-control" rows="4"
                                required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            Save Video
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function openAddModal() {
            // Reset form
            document.getElementById('videoForm').reset();
            document.getElementById('video_id').value = '';
            document.getElementById('methodField').innerHTML = ''; // Clear PUT method spoofing

            // Reset action URL to store route
            document.getElementById('videoForm').action = "{{ route('videos.store') }}";

            // Update modal title and button text
            document.getElementById('modalTitle').innerText = 'Add Video';
            document.getElementById('submitBtn').innerText = 'Save Video';
        }

        function openEditModal(video) {
            // Populate form fields
            document.getElementById('video_id').value = video.id;
            document.getElementById('title').value = video.title;
            document.getElementById('youtube_embed_code').value = video.youtube_embed_code; // If specific characters are escaped, you might need to decode them, but normally val() handles it well.

            // Remove PUT method spoofing since the route is defined as POST
            document.getElementById('methodField').innerHTML = '';

            // Update action URL to update route
            // Assuming your update route is /admin/videos/update/{id}
            let updateUrl = "{{ route('videos.update', ':id') }}";
            updateUrl = updateUrl.replace(':id', video.id);
            document.getElementById('videoForm').action = updateUrl;

            // Update modal title and button text
            document.getElementById('modalTitle').innerText = 'Edit Video';
            document.getElementById('submitBtn').innerText = 'Update Video';

            // Open modal
            var myModal = new bootstrap.Modal(document.getElementById('videoModal'));
            myModal.show();
        }
    </script>
@endsection