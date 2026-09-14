<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Post - Dashboard</title>
    <style>
        @include('partials.dashboard-styles')
    </style>
</head>
<body>
    <div class="page-header">
        <h1>New Post</h1>
        <a class="btn btn-secondary" href="/dashboard">Back to Dashboard</a>
    </div>

    <div class="section form-section">
        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/dashboard/posts">
            @csrf

            <div class="field">
                <label for="user_id">Owner</label>
                <select id="user_id" name="user_id" required>
                    <option value="" disabled {{ old('user_id') ? '' : 'selected' }}>Select a user</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected((string) old('user_id') === (string) $user->id)>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            </div>

            <div class="field">
                <label for="content">Content</label>
                <textarea id="content" name="content" required>{{ old('content') }}</textarea>
            </div>

            <div class="actions">
                <button type="submit" class="btn">Create Post</button>
                <a class="btn btn-secondary" href="/dashboard">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
