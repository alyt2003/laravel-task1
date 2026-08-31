<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f5f7;
            color: #1f2933;
            padding: 32px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 24px;
        }

        h2 {
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 12px;
            color: #364152;
        }

        .stats {
            display: flex;
            gap: 16px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid #e4e7eb;
            border-radius: 8px;
            padding: 20px 24px;
            min-width: 180px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        }

        .stat-card .label {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .stat-card .value {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
        }

        .section {
            background: #ffffff;
            border: 1px solid #e4e7eb;
            border-radius: 8px;
            padding: 20px 24px;
            margin-bottom: 24px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: #6b7280;
            border-bottom: 1px solid #e4e7eb;
            padding: 10px 12px;
        }

        tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid #f0f1f3;
            font-size: 14px;
            vertical-align: top;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .empty {
            padding: 16px 12px;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h1>Dashboard</h1>

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
        <h2>Users</h2>
        @if ($users->isEmpty())
            <p class="empty">No users found.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="section">
        <h2>Posts</h2>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->content }}</td>
                            <td>{{ $post->user->name ?? 'Unknown' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
