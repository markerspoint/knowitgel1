@extends('layouts.app')

@section('title', 'Edit Lesson')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h4 mb-0">Edit Lesson: {{ $lesson->title }}</h1>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <h5 class="alert-heading">Validation Errors</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.lessons.update', $lesson) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        {{-- Lesson Details --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $lesson->title) }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Short Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $lesson->description) }}</textarea>
                            <small class="form-text text-muted">A brief summary shown in lists.</small>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Full Content <span class="text-danger">*</span></label>
                            {{-- Consider replacing textarea with a WYSIWYG editor like TinyMCE or CKEditor for a richer editing experience --}}
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" required>{{ old('content', $lesson->content) }}</textarea>
                            <small class="form-text text-muted"></small>
                            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        {{-- Status & Thumbnail --}}
                        <div class="card mb-3">
                            <div class="card-header">Settings</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="active" {{ old('status', $lesson->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $lesson->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">Thumbnail</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="thumbnail" class="form-label">Upload New Thumbnail</label>
                                    <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail" accept="image/*">
                                    <small class="form-text text-muted">Optional. Max 2MB. Recommended dimensions: 800x400px.</small>
                                    @error('thumbnail') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                @if($lesson->thumbnail)
                                <div class="mt-2">
                                    <p class="mb-1"><small>Current Thumbnail:</small></p>
                                    <img src="{{ Storage::url($lesson->thumbnail) }}" alt="Current Thumbnail" class="img-thumbnail" style="max-width: 100%; height: auto;">
                                    {{-- Assuming you used Storage::disk('public')->put(...) --}}
                                    {{-- If you moved the file manually, use: <img src="{{ asset($lesson->thumbnail) }}" ... > --}}
                                </div>
                                @else
                                <p class="text-muted"><small>No current thumbnail.</small></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- Adjusted flex alignment and added margin for spacing --}}
                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Lesson
                    </button>
                    {{-- Moved Cancel button here and added margin-start --}}
                    <a href="{{ route('admin.dashboard') }}#lessons" class="btn btn-secondary ms-2"> {{-- Added ms-2 for spacing --}}
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                </div>
            </form>
        </div> {{-- End card-body --}}
    </div> {{-- End card --}}
</div>
@endsection

{{-- Add any specific CSS or JS needed for this page --}}
{{-- @push('styles')
<style>
    /* Add custom styles if needed */
</style>
@endpush --}}

{{-- @push('scripts')
<script>
    // Add custom scripts if needed, e.g., for a WYSIWYG editor initialization
</script>
@endpush --}}