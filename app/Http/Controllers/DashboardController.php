<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalPosts = Post::count();

        $users = User::select('id', 'name', 'email')->get();
        $posts = Post::with('user:id,name')->latest()->get();

        return view('dashboard', [
            'totalUsers' => $totalUsers,
            'totalPosts' => $totalPosts,
            'users' => $users,
            'posts' => $posts,
        ]);
    }
}
