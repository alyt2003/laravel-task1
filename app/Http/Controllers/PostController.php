<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
class PostController extends Controller
{


    public function getAllPosts(Request $request){
        return response()->json(Post::all());
    }
    public function createPost(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
    
        $user = $request->user();
    
        $post = Post::create([
            'user_id' => $user->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);
    
        return response()->json($post, 201);
    }
    public function editPost(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
    
        $user = $request->user();
    
        $post = Post::find($id);
    
        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }
    
        if ($post->user_id !== $user->id) {
            return response()->json([
                'message' => 'You are not allowed to edit this post'
            ], 403);
        }
    
        $post->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);
    
        return response()->json($post);
    }
public function deletePost(Request $request, $id)
{
    $user = $request->user();

    $post = Post::find($id);

    if (!$post) {
        return response()->json([
            'message' => 'Post not found'
        ], 404);
    }

    if ($post->user_id !== $user->id) {
        return response()->json([
            'message' => 'You are not allowed to delete this post'
        ], 403);
    }

    $post->delete();

    return response()->json([
        'message' => 'Post deleted successfully'
    ]);
}
    //
}
