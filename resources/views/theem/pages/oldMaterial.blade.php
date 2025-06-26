@extends('theem.layouts.app')
@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 text-dark">Old Materials</h1>
    </div>

    <!-- Materials Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            @if($materials->isEmpty())
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-folder-open fa-3x mb-2"></i>
                    <p class="mb-0">No materials found.</p>
                    <a href="{{route('materials.create')}}" class="btn btn-info"> Add Material</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Material Name</th>
                                <th>Date</th>
                                <th>Instructor</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materials as $material)
                                <tr>
                                    <td>
                                        <i class="fas
                                            @switch(strtolower(pathinfo($material->file_name, PATHINFO_EXTENSION)))
                                                @case('pdf') fa-file-pdf text-danger @break
                                                @case('doc') @case('docx') fa-file-word text-primary @break
                                                @case('ppt') @case('pptx') fa-file-powerpoint text-warning @break
                                                @case('xls') @case('xlsx') fa-file-excel text-success @break
                                                @case('jpg') @case('jpeg') @case('png') @case('gif') fa-file-image text-purple @break
                                                @default fa-file text-secondary
                                            @endswitch me-2"></i>
                                        {{ $material->file_name }}
                                    </td>
                                    <td>{{ $material->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $material->post->instructor->user->name ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ Storage::url($material->file_path) }}" target="_blank"
                                           class="btn btn-sm btn-outline-primary">
                                           <i class="fas fa-download me-1"></i> Download
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $materials->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .text-purple {
        color: #6f42c1 !important;
    }
</style>
@endpush
