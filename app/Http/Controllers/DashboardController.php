<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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

    /**
     * Read-only view of the actual registered API routes (routes/api.php),
     * with a small metadata map for human-readable descriptions and
     * expected body fields. This does not affect API behavior in any way -
     * it only reflects what is already registered in the router.
     */
    public function apiEndpoints()
    {
        $descriptions = [
            'App\Http\Controllers\AuthController@register' => 'Register a new user account.',
            'App\Http\Controllers\AuthController@login' => 'Log in with email and password. Returns the user and a Sanctum bearer token.',
            'App\Http\Controllers\AuthController@logout' => 'Revoke the current access token (logs the user out).',
            'App\Http\Controllers\UserController@getAllUsers' => 'List all users, including their posts.',
            'App\Http\Controllers\PostController@getAllPosts' => 'List all posts.',
            'App\Http\Controllers\PostController@createPost' => 'Create a new post owned by the authenticated user.',
            'App\Http\Controllers\PostController@editPost' => 'Update a post. Only the post\'s owner may edit it.',
            'App\Http\Controllers\PostController@deletePost' => 'Delete a post. Only the post\'s owner may delete it.',
        ];

        $bodyFields = [
            'App\Http\Controllers\AuthController@register' => [
                ['name' => 'name', 'type' => 'string', 'required' => true],
                ['name' => 'email', 'type' => 'string (email)', 'required' => true],
                ['name' => 'password', 'type' => 'string (min:8)', 'required' => true],
            ],
            'App\Http\Controllers\AuthController@login' => [
                ['name' => 'email', 'type' => 'string (email)', 'required' => true],
                ['name' => 'password', 'type' => 'string', 'required' => true],
            ],
            'App\Http\Controllers\PostController@createPost' => [
                ['name' => 'title', 'type' => 'string', 'required' => true],
                ['name' => 'content', 'type' => 'string', 'required' => true],
            ],
            'App\Http\Controllers\PostController@editPost' => [
                ['name' => 'title', 'type' => 'string', 'required' => true],
                ['name' => 'content', 'type' => 'string', 'required' => true],
            ],
        ];

        $endpoints = collect(Route::getRoutes())
            ->filter(fn ($route) => str_starts_with($route->uri(), 'api/'))
            ->map(function ($route) use ($descriptions, $bodyFields) {
                // Routes declared via Route::middleware(...)->post(...) etc. can report
                // their action with a leading backslash (\App\...) instead of App\...,
                // so normalize before looking up metadata.
                $action = ltrim($route->getActionName(), '\\');

                return [
                    'methods' => array_values(array_diff($route->methods(), ['HEAD'])),
                    'uri' => '/'.ltrim($route->uri(), '/'),
                    'action' => $action,
                    'description' => $descriptions[$action] ?? 'No description available.',
                    'auth' => in_array('auth:sanctum', $route->gatherMiddleware(), true),
                    'route_params' => $route->parameterNames(),
                    'body' => $bodyFields[$action] ?? [],
                ];
            })
            ->sortBy('uri')
            ->values();

        return view('dashboard-endpoints', [
            'endpoints' => $endpoints,
        ]);
    }
}
