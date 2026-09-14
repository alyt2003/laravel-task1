<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <style>
        @include('partials.dashboard-styles')
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Dashboard</h1>
        <a class="btn" href="{{ route('dashboard.endpoints') }}">API Endpoints</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="stats">
        <div class="stat-card">
            <div class="label">Total Users</div>
            <div class="value">{{ $totalUsers }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Total Posts</div>
            <div class="value">{{ $totalPosts }}</div>
        </div>
    </div>

    <div class="section">
        <div class="section-header">
            <h2>Users</h2>
            <a class="btn btn-sm" href="/dashboard/users/create">+ New User</a>
        </div>
        @if ($users->isEmpty())
            <p class="empty">No users found.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="col-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="col-actions">
                                <div class="row-actions">
                                    <a class="btn btn-secondary btn-sm" href="/dashboard/users/{{ $user->id }}/edit">Edit</a>
                                    <form class="action-form" method="POST" action="/dashboard/users/{{ $user->id }}" onsubmit="return confirm('Delete this user? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="section">
        <div class="section-header">
            <h2>Posts</h2>
            <a class="btn btn-sm" href="/dashboard/posts/create">+ New Post</a>
        </div>
        @if ($posts->isEmpty())
            <p class="empty">No posts found.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Owner</th>
                        <th class="col-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->content }}</td>
                            <td>{{ $post->user->name ?? 'Unknown' }}</td>
                            <td class="col-actions">
                                <div class="row-actions">
                                    <a class="btn btn-secondary btn-sm" href="/dashboard/posts/{{ $post->id }}/edit">Edit</a>
                                    <form class="action-form" method="POST" action="/dashboard/posts/{{ $post->id }}" onsubmit="return confirm('Delete this post? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
