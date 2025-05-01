@extends('theem.layouts.app')
@section('content')
    <!-- Main Content -->
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Create New Post</h1>
            <a href="{{ route('posts.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Posts
            </a>
        </div>

        <!-- Post Form -->
        <form class="post-form" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="postContent" class="form-label">Content *</label>
                <textarea id="postContent" name="postContent" class="form-input form-textarea"
                    placeholder="Write your post content here..." required></textarea>
                @error('postContent')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Attachments</label>
                <div class="file-input-container">
                    <label for="postAttachments" class="file-input-label">
                        <i class="fas fa-cloud-upload-alt"
                            style="font-size: 1.5rem; color: #64748b; margin-bottom: 0.5rem;"></i>
                        <div>Click to upload files or drag and drop</div>
                        <div style="font-size: 0.875rem; color: #64748b;">PDF, DOC, PPT, JPG, PNG (Max 10MB each)</div>
                    </label>
                    <input type="file" id="postAttachments" name="postAttachments[]" class="file-input" multiple>
                </div>
                <div class="file-list" id="fileList"></div>
                @error('postAttachments.*')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary"
                    onclick="window.location.href='{{ route('posts.index') }}'">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Publish Post
                </button>
            </div>
        </form>
    </div>
@endsection
