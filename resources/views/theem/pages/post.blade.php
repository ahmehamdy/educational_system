{{-- @extends('theem.layouts.app')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-dark fw-bold">All Posts</h2>
        <a href="{{ route('posts.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i> Create New Post
        </a>
    </div>

    <!-- Posts List -->
    @if (!is_object($posts))
        <div class="alert alert-danger">Invalid post data detected!</div>
    @endif

    @forelse ($posts as $post)
        <div class="card mb-4 border-0 shadow rounded-4 hover:shadow-lg transition-all">
            <!-- Post Info (User Name and Profile Picture) -->
            <div class="card-header bg-white d-flex align-items-center border-0">
                <div class="d-flex align-items-center">
                    @if ($post->instructor->user->image ?? false)
                        <img src="{{ asset("upload/".$post->instructor->user->image) }}" alt="{{ $post->instructor->user->name }}" class="rounded-circle me-3" width="50" height="50">
                    @else
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <div>
                        <h5 class="mb-0 text-dark">{{ $post->instructor->user->name ?? 'Unknown User' }}</h5>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</small>
                    </div>
                </div>
            </div>

            <!-- Post Content -->
            <div class="card-body">
                <p class="text-dark mb-3">{{ $post->content }}</p>

                <!-- Attachments -->
                @if ($post->attachments && count(json_decode($post->attachments, true)))
                    <div class="attachments">
                        @foreach (json_decode($post->attachments, true) as $attachment)
                            <div class="attachment mb-2">
                                <a href="{{ Storage::url($attachment['path']) }}" target="_blank" class="text-dark d-inline-block">
                                    <i class="fas fa-paperclip"></i> {{ $attachment['name'] }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Like and Comment Section -->
            <div class="card-footer bg-light d-flex justify-content-between align-items-center border-0">
                <div class="d-flex">
                    <button class="btn btn-link text-primary hover:text-dark transition-all">
                        <i class="fas fa-thumbs-up"></i> Like
                    </button>
                    <button class="btn btn-link text-primary hover:text-dark transition-all">
                        <i class="fas fa-comment"></i> Comment
                    </button>
                </div>
                <div>
                    <small>{{ $post->comments->count() }} comments</small>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="card-footer bg-transparent border-0">
                @foreach ($post->comments as $comment)
                    <div class="comment mb-3">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('upload/' . $comment->user->image) }}" alt="{{ $comment->user->name }}" class="rounded-circle" width="35" height="35">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="bg-light p-2 rounded shadow-sm">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $comment->user->name }}</strong>
                                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-0">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Add Comment Form -->
                <form action="{{ route('posts.storeComment') }}" method="POST" class="mt-3">
                    @csrf
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            @auth
                                <img src="{{ asset("upload/".auth()->user()->image) }}" class="rounded-circle" width="35" height="35">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endauth
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <input type="text" name="content" class="form-control form-control-sm" placeholder="Write a comment..." required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm ms-2">Post</button>
                    </div>
                </form>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i> No posts found. Start by creating a new post.
        </div>
    @endforelse

    <!-- Pagination -->
    @if ($posts->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection --}}
@extends('theem.layouts.app')

@section('content')
    <div class="container py-8">
        <!-- Page Header -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <h2 class="text-dark fw-bold ">All Posts</h2>
            @auth
                @if (auth()->user()->instructor)
                    <a href="{{ route('posts.create') }}" class="btn btn-primary shadow-sm d-inline-flex align-items-center">
                        <i class="fas fa-plus me-2"></i> Create New Post
                    </a>
                @endif
            @endauth

        </div>

        <!-- Posts List -->
        @if (isset($posts) && $posts instanceof \Illuminate\Pagination\LengthAwarePaginator)
            @forelse ($posts as $post)
                <div class="card mb-4 border-0 shadow rounded-4 transition-all hover:shadow-xl">
                    <!-- Post Info (User Name and Profile Picture) -->
                    <div class="card-header bg-white d-flex align-items-center border-0">
                        <div class="d-flex align-items-center">
                            @php
                                $user = $post->instructor?->user;
                                $userName = $user?->name ?? 'Unknown User';
                                $userImage = $user?->image ? asset('upload/' . $user->image) : null;
                            @endphp

                            @if ($userImage)
                                <img src="{{ $userImage }}" alt="{{ $userName }}" class="rounded-circle me-3"
                                    width="50" height="50" loading="lazy">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white me-3"
                                    style="width: 50px; height: 50px;" aria-hidden="true">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif

                            <div>
                                <h5 class="mb-0 text-dark">{{ $userName }}</h5>
                                <small class="text-muted" datetime="{{ $post->created_at }}">
                                    {{ \Carbon\Carbon::parse($post->created_at)->timezone('Africa/Cairo')->diffForHumans() }}
                                </small>

                            </div>
                        </div>
                    </div>

                    <!-- Post Content -->
                    <div class="card-body">
                        <p class="text-dark mb-3">{{ $post->content }}</p>

                        <!-- Attachments -->
                        @if ($post->attachments)
                            @php
                                $attachments = json_decode($post->attachments, true);
                                $validAttachments = is_array($attachments)
                                    ? array_filter($attachments, function ($attachment) {
                                        return isset($attachment['path'], $attachment['name']);
                                    })
                                    : [];
                            @endphp

                            @if (!empty($validAttachments))
                                <div class="attachments mt-3">
                                    <h6 class="text-muted mb-2">Attachments:</h6>
                                    <ul class="list-unstyled">
                                        @foreach ($validAttachments as $attachment)
                                            <li class="mb-1">
                                                <a href="{{ Storage::url($attachment['path']) }}" target="_blank"
                                                    class="text-primary d-inline-flex align-items-center"
                                                    rel="noopener noreferrer">
                                                    <i class="fas fa-paperclip me-1"></i>
                                                    <span>{{ $attachment['name'] }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- Like and Comment Section -->
                    <div class="card-footer bg-light d-flex justify-content-between align-items-center border-0">
                        <div class="d-flex">
                            <button class="btn btn-link text-primary hover:text-dark transition-all p-2" type="button"
                                aria-label="Like this post">
                                <i class="fas fa-thumbs-up" aria-hidden="true"></i> Like
                            </button>
                            <button class="btn btn-link text-primary hover:text-dark transition-all p-2" type="button"
                                aria-label="Comment on this post">
                                <i class="fas fa-comment" aria-hidden="true"></i> Comment
                            </button>
                        </div>
                        <div>
                            <small>{{ $post->comments->count() }}
                                {{ Str::plural('comment', $post->comments->count()) }}</small>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="card-footer bg-transparent border-0">
                        @if ($post->comments->isNotEmpty())
                            <div class="comments-section mb-3">
                                @foreach ($post->comments as $comment)
                                    <div class="comment mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                @php
                                                    $commentUser = $comment->user;
                                                    $commentUserImage = $commentUser?->image
                                                        ? asset('upload/' . $commentUser->image)
                                                        : null;
                                                @endphp

                                                @if ($commentUserImage)
                                                    <img src="{{ $commentUserImage }}"
                                                        alt="{{ $commentUser?->name ?? 'User' }}" class="rounded-circle"
                                                        width="35" height="35" loading="lazy">
                                                @else
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                                        style="width: 35px; height: 35px;" aria-hidden="true">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="bg-light p-2 rounded shadow-sm">
                                                    <div class="d-flex justify-content-between">
                                                        <strong>{{ $commentUser?->name ?? 'Anonymous' }}</strong>
                                                        <small class="text-muted" datetime="{{ $comment->created_at }}">
                                                            {{ $comment->created_at->diffForHumans() }}
                                                        </small>
                                                    </div>
                                                    <p class="mb-0">{{ $comment->content }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Add Comment Form -->
                        @auth
                            <form action="{{ route('posts.storeComment') }}" method="POST" class="mt-3">
                                @csrf
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('upload/' . auth()->user()->image) }}"
                                            alt="{{ auth()->user()->name }}" class="rounded-circle" width="35"
                                            height="35" loading="lazy">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <div class="position-relative">
                                            <input type="text" name="content"
                                                class="form-control form-control-sm @error('content') is-invalid @enderror"
                                                placeholder="Write a comment..." required aria-label="Your comment">
                                            @error('content')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm ms-2" aria-label="Post comment">
                                        Comment
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="mt-3 text-center text-muted">
                                <small>Please <a href="{{ route('login') }}" class="text-primary">login</a> to leave a
                                    comment.</small>
                            </div>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center rounded-4">
                    <i class="fas fa-info-circle me-2" aria-hidden="true"></i>
                    No posts found. Start by creating a new post.
                </div>
            @endforelse

            <!-- Pagination -->
            @if ($posts->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $posts->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif
        @else
            <div class="alert alert-danger rounded-4">
                <i class="fas fa-exclamation-triangle me-2" aria-hidden="true"></i>
                Invalid post data detected! Please try refreshing the page or contact support if the issue persists.
            </div>
        @endif
    </div>
@endsection
