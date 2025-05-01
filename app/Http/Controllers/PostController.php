<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Instructor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['instructor.user'])
            ->whereHas('instructor')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('theem.pages.post', ['posts' => $posts]);
    }

    public function storeComment(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'content' => 'required|string',
        ]);

        Comment::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);
        return back();
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('theem.pages.createpost');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the request data
        $validated = $request->validate([
            'postContent' => 'required|string',
            'postAttachments.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:10240'
        ]);

        try {
            // Handle file uploads
            $attachments = [];
            if ($request->hasFile('postAttachments')) {
                foreach ($request->file('postAttachments') as $file) {
                    // Generate unique filename
                    $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                        . '.' . $file->getClientOriginalExtension();

                    $path = $file->storeAs('post_attachments', $filename, 'public');

                    $attachments[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'mime_type' => $file->getClientMimeType(),
                        'size' => $file->getSize(),
                        'storage_name' => $filename
                    ];
                }
            }

            // Create the post
            $posts = Post::create([
                'content' => $validated['postContent'],
                'attachments' => !empty($attachments) ? json_encode($attachments) : null,
                'instructor_id' => 1
            ]);

            return redirect()->route('posts.index');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post->load('user'),
            'attachments' => $post->attachments ? json_decode($post->attachments, true) : []
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
