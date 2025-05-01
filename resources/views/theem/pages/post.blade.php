@extends('theem.layouts.app')
@section('content')
    <div class="container py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 text-dark">All Posts</h1>
            <a href="{{ route('posts.create') }}" class="btn btn-primary d-flex align-items-center">
                <i class="fas fa-plus me-2"></i> Create New Post
            </a>
        </div>

        <!-- Posts List -->
        <div class="mb-4">
            @if (!is_object($posts))
                <div class="alert alert-danger">Invalid post data detected!</div>
            @endif

            @forelse ($posts as $post)
                <div class="card mb-4 shadow-sm hover-shadow">
                    <!-- Instructor Info -->
                    <div class="card-header bg-light d-flex align-items-center">
                        @if ($post->instructor->user->profile_photo ?? false)
                            <img src="{{ Storage::url($post->instructor->user->image) }}"
                                alt="{{ $post->instructor->user->name }}" class="rounded-circle me-3" width="40"
                                height="40">
                        @else
                            <div class="rounded-circle bg-secondary me-3 d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                <i class="fas fa-user text-light"></i>
                            </div>
                        @endif
                        <div>
                            <h5 class="mb-0 text-dark">{{ $post->instructor->user->name ?? 'Unknown User' }}</h5>
                            <div class="post-meta">
                                <span>{{ \Carbon\Carbon::parse($post->created_at) }}
                                </span>
                            </div>
                        </div>

                        <!-- Post Content -->
                        <div class="card-body">
                            <p class="post-content">{{ $post->content }}</p>
                        </div>

                        <!-- Attachments -->
                        @if ($post->attachments && count(json_decode($post->attachments, true)))
                            <div class="card-body pt-0">
                                <h6 class="text-muted mb-3">
                                    <i class="fas fa-paperclip me-2"></i> Attachments
                                </h6>
                                <div class="row g-2">
                                    @foreach (json_decode($post->attachments, true) as $attachment)
                                        <div class="col-md-6">
                                            <a href="{{ Storage::url($attachment['path']) }}" target="_blank"
                                                class="d-flex align-items-center p-2 border rounded text-decoration-none hover-bg-light">
                                                <i
                                                    class="fas
                                            @switch(strtolower(pathinfo($attachment['name'], PATHINFO_EXTENSION)))
                                                @case('pdf') fa-file-pdf text-danger me-2 @break
                                                @case('doc') @case('docx') fa-file-word text-primary me-2 @break
                                                @case('ppt') @case('pptx') fa-file-powerpoint text-warning me-2 @break
                                                @case('xls') @case('xlsx') fa-file-excel text-success me-2 @break
                                                @case('jpg') @case('jpeg') @case('png') @case('gif') fa-file-image text-purple me-2 @break
                                                @default fa-file text-secondary me-2
                                            @endswitch"></i>
                                                <span class="text-truncate flex-grow-1">{{ $attachment['name'] }}</span>
                                                <small class="text-muted ms-2">{{ round($attachment['size'] / 1024) }}
                                                    KB</small>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Comments Section -->
                        <div class="card-footer bg-transparent">
                            <h6 class="comments-title">
                                <i class="fas fa-comments me-2"></i> Comments
                            </h6>

                            <!-- Existing Comments -->
                            <div class="mb-3">
                                @foreach ($post->comments->take(2) as $comment)
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0">
                                            @if ($comment->user->profile_photo)
                                                <img src="{{ Storage::url($comment->user->profile_photo) }}"
                                                    class="rounded-circle" width="32" height="32">
                                            @else
                                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                                    style="width: 32px; height: 32px;">
                                                    <i class="fas fa-user text-light" style="font-size: 0.8rem;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="bg-light p-3 rounded">
                                                <div class="d-flex justify-content-between">
                                                    <strong class="text-dark">{{ $comment->user->name }}</strong>
                                                    <small
                                                        class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                </div>
                                                <p class="mb-0 text-muted">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- View All Comments Link -->
                            @if ($post->comments->count() > 2)
                                <a href="#" class="d-block text-primary mb-3 small">
                                    View all {{ $post->comments->count() }} comments
                                </a>
                            @endif

                            <!-- Add Comment Form -->
                            <form action="{{ route('posts.storeComment') }}" method="POST" class="comment-form">
                                @csrf
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        @auth
                                            @if (auth()->user()->profile_photo)
                                                <img src="{{ Storage::url(auth()->user()->profile_photo) }}"
                                                    class="rounded-circle" width="32" height="32">
                                            @else
                                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                                    style="width: 32px; height: 32px;">
                                                    <i class="fas fa-user text-light" style="font-size: 0.8rem;"></i>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>
                                    <div class="flex-grow-1 ms-3 d-flex">
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <input type="text" name="content"
                                            class="form-control form-control-sm rounded-pill me-2"
                                            placeholder="Write a comment..." required>
                                        <button type="submit" class="btn btn-sm btn-outline-primary rounded-circle"
                                            style="width: 32px; height: 32px;">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="card text-center py-5">
                        <div class="card-body">
                            <i class="fas fa-info-circle text-muted mb-3" style="font-size: 3rem;"></i>
                            <h3 class="h5 text-dark mb-2">No Posts Found</h3>
                            <p class="text-muted">Posts will appear here when created</p>
                        </div>
                    </div>
            @endforelse
        </div>

        @if ($posts->hasPages())
            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

@endsection
