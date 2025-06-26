@extends('theem.layouts.app')

@section('title', 'My Instructors')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="text-dark fw-bold mb-0">My Instructors</h2>
            <p class="text-muted mb-0">List of instructors assigned to you</p>
        </div>

        <form method="GET" class="d-flex">
            <input type="text" name="search" class="form-control form-control-sm me-2"
                   placeholder="Search instructors..."
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-search me-1"></i> Search
            </button>
        </form>
    </div>

    <!-- Instructors List -->
    @if(isset($instructors) && $instructors->isNotEmpty())
        <div class="row g-4">
            @foreach($instructors as $instructor)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 hover:shadow transition-all">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                @if($instructor->user->image)
                                    <img src="{{ asset('upload/'.$instructor->user->image) }}"
                                         alt="{{ $instructor->user->name }}"
                                         class="rounded-circle me-3"
                                         width="50"
                                         height="50">
                                @else
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white me-3"
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                                <div>
                                    <h5 class="mb-0 text-dark">{{ $instructor->user->name }}</h5>
                                    <small class="text-muted">{{ $instructor->title ?? 'Instructor' }}</small>
                                </div>
                            </div>

                            <p class="text-muted mb-3 flex-grow-1">
                                {{ Str::limit($instructor->bio, 100, '...') }}
                            </p>

                            <div class="mt-auto">
                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                    <span class="badge bg-primary mb-2">{{ $instructor->department }}</span>

                                    <a href="{{ route('instructors.show', $instructor->id) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        View Profile
                                    </a>
                                </div>

                                @if($instructor->email)
                                    <div class="mt-2">
                                        <small class="text-muted d-flex align-items-center">
                                            <i class="fas fa-envelope me-2"></i> {{ $instructor->email }}
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        {{-- @if ($instructors->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $instructors->appends(request()->query())->links() }}
            </div>
        @endif
    @else
        <div class="alert alert-info text-center rounded-4">
            <i class="fas fa-info-circle me-2"></i>
            You don't have any instructors assigned yet.
        </div>--}}
    @endif
</div>
@endsection
