<div class="mb-3">
    <label for="">Brand Name</label>
    <input type="text" wire:model.defer="name" class="form-control">
    @error('name') <small class="text-danger">{{ $message}}</small>@enderror
</div>
<div class="mb-3">
    <label for="">Brand Slug</label>
    <input type="text" wire:model.defer="slug" class="form-control">
    @error('slug') <small class="text-danger">{{ $message}}</small>@enderror
</div>
<div class="mb-3">
    <label for="">Status</label><br>
    <input type="checkbox" wire:model.defer="status"/> Checked=Hidden, Un-Checked= Visible
    @error('slug') <small class="text-danger">{{ $message}}</small>@enderror
</div>