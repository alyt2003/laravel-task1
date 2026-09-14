<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New User - Dashboard</title>
    <style>
        @include('partials.dashboard-styles')
    </style>
</head>
<body>
    <div class="page-header">
        <h1>New User</h1>
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

        <form method="POST" action="/dashboard/users">
            @csrf

            <div class="field">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required minlength="8">
            </div>

            <div class="actions">
                <button type="submit" class="btn">Create User</button>
                <a class="btn btn-secondary" href="/dashboard">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
