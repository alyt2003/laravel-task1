<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User - Dashboard</title>
    <style>
        @include('partials.dashboard-styles')
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Edit User</h1>
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

        <form method="POST" action="/dashboard/users/{{ $user->id }}">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" minlength="8">
                <div class="hint">Leave blank to keep the current password.</div>
            </div>

            <div class="actions">
                <button type="submit" class="btn">Save Changes</button>
                <a class="btn btn-secondary" href="/dashboard">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
