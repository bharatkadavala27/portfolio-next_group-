{{-- Show temporary documents from previous upload attempt --}}
@if(session()->has('temp_files.documents'))
    @foreach(session('temp_files.documents') as $index => $tempDoc)
        <div class="document mb-3" id="document-temp-{{ $index }}">
            <label for="documents[{{ $index }}][type]" class="form-label">Type</label>
            <select name="documents[{{ $index }}][type]" class="form-control">
                <option value="">Select Document Type</option>
                @foreach ($documentTypes as $documentType)
                    <option value="{{ $documentType->id }}"
                        {{ old('documents.'.$index.'.type', $tempDoc['type']) == $documentType->id ? 'selected' : '' }}>
                        {{ $documentType->name }}
                    </option>
                @endforeach
            </select>

            <label for="documents[{{ $index }}][file_path]" class="form-label">File</label>
            <input type="file" name="documents[{{ $index }}][file_path]" class="form-control">
            <input type="hidden" name="temp_documents[{{ $index }}]" value="{{ $tempDoc['file_path'] }}">

            <div class="form-group mt-2">
                <label for="documents[{{ $index }}][path]">Document Path</label>
                <input type="text" name="documents[{{ $index }}][path]" class="form-control"
                    value="{{ old('documents.'.$index.'.path', $tempDoc['path']) }}">
            </div>

            <div class="mt-2">
                <h6>Previously Selected File:</h6>
                <a href="{{ asset('storage/'.$tempDoc['file_path']) }}" target="_blank" class="btn btn-sm btn-info">View Document</a>
            </div>

            <button type="button" class="btn btn-danger remove-document mt-3">Remove</button>
        </div>
    @endforeach
@endif
