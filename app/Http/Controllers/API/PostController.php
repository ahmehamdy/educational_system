<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['instructor.user', 'comments.user'])
            ->whereHas('instructor')
            ->orderBy('created_at', 'desc')
            ->paginate(3);


        if ($posts->isEmpty()) {
            $response = [
                'status' => 200,
                'message' => "Data is Empty"
            ];
        } else {
            $response = [
                'status' => 200,
                'data' => $posts,
                'message' => 'Get Data Successfully'

            ];
        }

        return response($response, 200);
    }

    public function storeComment(Request $request, $post_id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $post = Post::find($post_id);
        if (!$post) {
            return response()->json([
                'status' => 404,
                'message' => 'This post not found'
            ], 404);
        }

        $comment =  Comment::create([
            'post_id' => $post_id,
            'user_id' =>  auth()->user()->id,
            'content' => $request->content,
        ]);

        return response()->json([
            'status' => 201,
            'data' => $comment,
            'message' => 'Add Comment Successfully'
        ], 201);
    }

    public function updateComment(Request $request, $post_id) {}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'postContent' => 'required|string',
            'postAttachments' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,mp4,mov,avi,mkv,webm|max:10240'
        ]);
        //dd($request->all(), $request->file('postAttachments'));

        try {
            // Handle file uploads
            $attachments = [];

            $files = $request->file('postAttachments');

            // خليها Array دايمًا حتى لو ملف واحد
            if ($files && !is_array($files)) {
                $files = [$files];
            }

            if ($files) {
                foreach ($files as $file) {
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
            $user = auth()->user();
            if (!$user->instructor) {
                return response()->json([
                    'message' => 'You are not an instructor.'
                ], 403);
            }
            $posts = Post::create([
                'content' => $validated['postContent'],
                'attachments' => !empty($attachments) ? json_encode($attachments) : null,
                'instructor_id' => $user->instructor->id
            ]);
            $response = [
                'status' => 200,
                'data' => $posts,
                'message' => 'creat post Successfully'

            ];
            return response($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


    public function myPosts()
    {
        $user = auth()->user();

        if (!$user->instructor) {
            return response()->json([
                'status' => 403,
                'message' => 'This user is not an instructor.'
            ], 403);
        }

        $posts = Post::with(['comments.user'])
            ->where('instructor_id', $user->instructor->id)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($posts->isEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'No posts found for this instructor.'
            ]);
        }

        return response()->json([
            'status' => 200,
            'data' => $posts,
            'message' => 'Instructor posts fetched successfully.'
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'postContent' => 'sometimes|required|string',
            'postAttachments.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:10240'
        ]);

        try {
            $user = auth()->user();
            $post = Post::findOrFail($id);

            if (!$user->instructor || $post->instructor_id !== $user->instructor->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            if ($request->has('postContent')) {
                $post->content = $validated['postContent'];
            }

            $attachments = [];
            $files = $request->file('postAttachments');

            if ($files && !is_array($files)) {
                $files = [$files];
            }

            if ($files) {
                // ✅ حذف المرفقات القديمة من storage
                if ($post->attachments) {
                    $oldAttachments = json_decode($post->attachments, true);
                    foreach ($oldAttachments as $attachment) {
                        if (Storage::disk('public')->exists($attachment['path'])) {
                            Storage::disk('public')->delete($attachment['path']);
                        }
                    }
                }

                // ✅ حفظ المرفقات الجديدة
                foreach ($files as $file) {
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

                $post->attachments = json_encode($attachments);
            }

            $post->save();

            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully',
                'data' => $post
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = auth()->user();
            $post = Post::findOrFail($id);

            // التحقق من صلاحية المستخدم
            if (!$user->instructor || $post->instructor_id !== $user->instructor->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            // حذف المرفقات من storage
            if ($post->attachments) {
                $attachments = json_decode($post->attachments, true);
                foreach ($attachments as $attachment) {
                    if (Storage::disk('public')->exists($attachment['path'])) {
                        Storage::disk('public')->delete($attachment['path']);
                    }
                }
            }

            // حذف البوست نفسه
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
