<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Web (Blade) CRUD controller for the admin dashboard's Posts table.
 *
 * This is separate from App\Http\Controllers\PostController, which serves
 * the JSON API and is left untouched.
 */
class PostController extends Controller
{
    public function create()
    {
        $users = User::orderBy('name')->get(['id', 'name']);

        return view('posts.create', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Post::create($validated);

        return redirect('/dashboard')->with('status', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $users = User::orderBy('name')->get(['id', 'name']);

        return view('posts.edit', ['post' => $post, 'users' => $users]);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update($validated);

        return redirect('/dashboard')->with('status', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/dashboard')->with('status', 'Post deleted successfully.');
    }
}
