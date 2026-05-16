@extends('layouts.admin')

@section('content')
    @php $isEdit = isset($filter); @endphp
    <div class="card">
        <div class="card-header">
            <h4>{{ $isEdit ? 'Edit Filter' : 'Create New Filter' }}</h4>
        </div>
        <div class="card-body">
            @if($isEdit)
                {{-- build URL only when $filter exists to avoid route generation errors --}}
                <form action="{{ url('admin/filters/' . $filter->id . '/update') }}" method="POST" id="filter-form">
            @else
                    <form action="{{ route('admin.filters.store') }}" method="POST" id="filter-form">
                @endif
                    @csrf
                    @if($isEdit)
                        @method('PUT')
                    @endif

                    <!-- Filter Name -->
                    <div class="mb-3">
                        <label for="filter_name" class="form-label">Filter Name</label>
                        <input type="text" name="filter_name" id="filter_name" class="form-control"
                            value="{{ old('filter_name', $filter->name ?? '') }}" required>
                        @error('filter_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>



                    <!-- Filter Type -->
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="document" {{ (old('type', $filter->type ?? 'document') == 'document') ? 'selected' : '' }}>Document</option>
                            <option value="product" {{ (old('type', $filter->type ?? '') == 'product') ? 'selected' : '' }}>
                                Product</option>
                            <option value="both" {{ (old('type', $filter->type ?? '') == 'both') ? 'selected' : '' }}>Both
                            </option>
                        </select>
                        @error('type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror



                        <!-- Filter Options -->
                        <div class="mb-3">
                            <label class="form-label">Filter Options</label>
                            <div id="options-wrapper">
                                {{-- Show old submitted existing options first if validation failed --}}
                                @php
                                    $oldExisting = old('options_existing', []);
                                    $oldNew = old('options_new', []);
                                @endphp

                                @if(count($oldExisting) > 0)
                                    @foreach($oldExisting as $id => $val)
                                        <div class="input-group mb-2 option-item" data-existing-id="{{ $id }}">
                                            <input type="text" name="options_existing[{{ $id }}]" class="form-control"
                                                value="{{ $val }}" required>
                                            <button type="button" class="btn btn-danger remove-option"
                                                data-existing-id="{{ $id }}">X</button>
                                        </div>
                                    @endforeach
                                @else
                                    @if($isEdit)
                                        @foreach($filter->options as $option)
                                            <div class="input-group mb-2 option-item" data-existing-id="{{ $option->id }}">
                                                <input type="text" name="options_existing[{{ $option->id }}]" class="form-control"
                                                    value="{{ old('options_existing.' . $option->id, $option->name) }}" required>
                                                <button type="button" class="btn btn-danger remove-option"
                                                    data-existing-id="{{ $option->id }}">X</button>
                                            </div>
                                        @endforeach
                                    @endif
                                @endif

                                {{-- Show any old new inputs --}}
                                @if(count($oldNew) > 0)
                                    @foreach($oldNew as $val)
                                        <div class="input-group mb-2 option-item">
                                            <input type="text" name="options_new[]" class="form-control" value="{{ $val }}"
                                                required>
                                            <button type="button" class="btn btn-danger remove-option">X</button>
                                        </div>
                                    @endforeach
                                @endif

                                {{-- If nothing present, show one empty new input --}}
                                @if(count($oldExisting) === 0 && count($oldNew) === 0 && (!isset($filter) || $filter->options->count() === 0))
                                    <div class="input-group mb-2 option-item">
                                        <input type="text" name="options_new[]" class="form-control"
                                            placeholder="Enter option name" required>
                                        <button type="button" class="btn btn-danger remove-option">X</button>
                                    </div>
                                @endif
                            </div>

                            <button type="button" class="btn btn-secondary" id="add-option">+ Add Option</button>
                            @error('options_new.*')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @error('options_existing.*')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <button type="submit"
                            class="btn btn-primary">{{ $isEdit ? 'Update Filter' : 'Save Filter' }}</button>
                </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // guard to avoid double initialization
            if (window.__filterOptionsInit) return;
            window.__filterOptionsInit = true;

            const wrapper = document.getElementById('options-wrapper');
            const addBtn = document.getElementById('add-option');
            const form = document.getElementById('filter-form');

            // Add new option input
            if (addBtn && wrapper) {
                addBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const div = document.createElement('div');
                    div.classList.add('input-group', 'mb-2', 'option-item');
                    div.innerHTML = `
                            <input type="text" name="options_new[]" class="form-control" placeholder="Enter option name" required>
                            <button type="button" class="btn btn-danger remove-option">X</button>
                        `;
                    wrapper.appendChild(div);
                    // focus the newly added input
                    const input = div.querySelector('input');
                    if (input) input.focus();
                });
            }

            // Remove option input using event delegation
            if (wrapper) {
                wrapper.addEventListener('click', function (e) {
                    if (e.target && e.target.classList.contains('remove-option')) {
                        e.preventDefault();
                        const parent = e.target.closest('.option-item');
                        if (!parent) return;

                        // If this option corresponds to an existing DB option, mark it for deletion by adding a hidden input to the form
                        const existingId = e.target.getAttribute('data-existing-id') || parent.getAttribute('data-existing-id');
                        if (existingId && form) {
                            const hidden = document.createElement('input');
                            hidden.type = 'hidden';
                            hidden.name = 'options_delete[]';
                            hidden.value = existingId;
                            form.appendChild(hidden);
                        }

                        parent.remove();
                    }
                });
            }
        });
    </script>
@endsection