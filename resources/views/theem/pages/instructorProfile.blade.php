@extends('theem.layouts.app')

@section('title', 'Profile - ' . $instructor->user->name)

@section('content')
<div class="container py-5">
    <!-- Profile Header -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-dark fw-bold mb-0">Instructor Profile</h2>
    </div>

    <!-- Instructor Info -->
    <div class="card border-0 shadow-sm mb-4 overflow-hidden">
        <div class="row g-0">
            <div class="col-md-4 text-center bg-light d-flex flex-column align-items-center justify-content-center p-4">
                @if($instructor->user->image)
                    <img src="{{ asset('upload/' . $instructor->user->image) }}"
                         alt="{{ $instructor->user->name }}"
                         class="rounded-circle mb-3 shadow"
                         width="150"
                         height="150"
                         loading="lazy">
                @else
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white mb-3"
                         style="width: 150px; height: 150px;">
                        <i class="fas fa-user" style="font-size: 3rem;"></i>
                    </div>
                @endif

                <h5 class="mb-1">{{ $instructor->user->name }}</h5>
                <p class="text-muted mb-0">{{ $instructor->title ?? 'Instructor' }}</p>

                @if($instructor->specialization)
                    <span class="badge bg-primary mt-2">{{ $instructor->specialization }}</span>
                @endif
            </div>

            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title mb-3">About Me</h5>

                    <p class="card-text text-muted">
                        {{ $instructor->bio ?? 'No bio available for this instructor.' }}
                    </p>

                    <hr class="my-4">

                    <div class="row g-3">
                        @if($instructor->email)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-envelope me-2"></i>
                                    <span>{{ $instructor->email }}</span>
                                </div>
                            </div>
                        @endif

                        @if($instructor->phone)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-phone me-2"></i>
                                    <span>{{ $instructor->phone }}</span>
                                </div>
                            </div>
                        @endif

                        @if($instructor->experience)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-briefcase me-2"></i>
                                    <span>{{ $instructor->experience }} years of experience</span>
                                </div>
                            </div>
                        @endif

                        @if($instructor->education)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-graduation-cap me-2"></i>
                                    <span>{{ $instructor->education }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Taught -->
    {{-- @if($instructor->courses->isNotEmpty())
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">Courses Taught</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($instructor->courses as $course)
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-dark">{{ $course->title }}</h6>
                                    <p class="card-text text-muted small">
                                        {{ Str::limit($course->description, 100, '...') }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-success">{{ $course->level }}</span>
                                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-outline-primary btn-sm">
                                            View Course
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif --}}

    <!-- Student Feedback (Optional) -->
    {{-- @if($instructor->reviews->isNotEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">Student Feedback</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($instructor->reviews as $review)
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded">
                                <div class="d-flex justify-content-between mb-2">
                                    <strong>{{ $review->student->user->name }}</strong>
                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="text-warning mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $review->rating ? '' : '-outline-alt' }}"></i>
                                    @endfor
                                </div>
                                <p class="mb-0">{{ $review->comment }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif --}}
</div>
@endsection
