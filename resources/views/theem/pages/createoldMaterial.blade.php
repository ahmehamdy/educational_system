@extends('theem.layouts.app')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 text-dark">Add New Material</h1>
        <a href="{{ route('materials.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Materials
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">Material Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>


                <!-- File Upload -->
                <div class="mb-3">
                    <label for="file" class="form-label">Upload File</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                    <small class="text-muted">Allowed types: pdf, doc, docx, ppt, xlsx, jpg, png</small>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload me-2"></i> Upload Material
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
