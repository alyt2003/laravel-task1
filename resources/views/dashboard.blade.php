@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Admin Dashboard')
@section('page-subtitle', 'Manage users, posts, and application content from one place.')

@section('content')
    @php
        $latestUser = $users->sortByDesc('created_at')->first();
        $latestPost = $posts->first();
    @endphp

    @if (session('status'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    {{-- Stat cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @livewire('users.total-users-card')

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Posts</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalPosts }}</p>
                    <p class="mt-1 text-xs text-gray-400">Published posts</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div class="min-w-0">
                    <p class="text-sm text-gray-500">Latest User</p>
                    <p class="mt-2 truncate text-xl font-semibold text-gray-900">{{ $latestUser->name ?? '—' }}</p>
                    <p class="mt-1 text-xs text-gray-400">
                        {{ $latestUser?->created_at?->diffForHumans() ?? 'No users yet' }}
                    </p>
                </div>
                <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-4a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div class="min-w-0">
                    <p class="text-sm text-gray-500">Latest Post</p>
                    <p class="mt-2 truncate text-xl font-semibold text-gray-900">{{ $latestPost->title ?? '—' }}</p>
                    <p class="mt-1 truncate text-xs text-gray-400">
                        {{ $latestPost ? 'by '.($latestPost->user->name ?? 'Unknown') : 'No posts yet' }}
                    </p>
                </div>
                <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Users section --}}
    <section id="users" class="mt-8 scroll-mt-24">
        @livewire('users.manager')
    </section>

    {{-- Posts section --}}
    <section id="posts" class="mt-8 scroll-mt-24">
        <div class="rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="flex flex-col gap-4 border-b border-gray-100 p-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Posts Management</h2>
                    <p class="mt-0.5 text-sm text-gray-500">Create and manage all posts created by users.</p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input
                            type="text"
                            id="postSearch"
                            placeholder="Search posts by title..."
                            class="w-full rounded-lg border border-gray-200 py-2 pl-9 pr-3 text-sm text-gray-700 placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:w-72"
                        >
                    </div>
                    <a href="{{ route('admin.posts.create') }}" class="inline-flex flex-shrink-0 items-center justify-center gap-1.5 whitespace-nowrap rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add New Post
                    </a>
                </div>
            </div>

            @if ($posts->isEmpty())
                <p class="p-6 text-sm text-gray-500">No posts found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-sm">
                        <thead>
                            <tr class="text-left text-xs font-semibold uppercase tracking-wide text-gray-400">
                                <th class="px-5 py-3">ID</th>
                                <th class="px-5 py-3">Title</th>
                                <th class="px-5 py-3">Content Preview</th>
                                <th class="px-5 py-3">Owner</th>
                                <th class="px-5 py-3">Created At</th>
                                <th class="px-5 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="postsTableBody" class="divide-y divide-gray-100">
                            @foreach ($posts as $post)
                                <tr class="post-row hover:bg-gray-50 transition-colors" data-search="{{ strtolower($post->title) }}">
                                    <td class="px-5 py-3.5 text-gray-500">{{ $post->id }}</td>
                                    <td class="px-5 py-3.5 font-medium text-gray-900">{{ $post->title }}</td>
                                    <td class="px-5 py-3.5 text-gray-500">{{ \Illuminate\Support\Str::limit($post->content, 60) }}</td>
                                    <td class="px-5 py-3.5 text-gray-600">{{ $post->user->name ?? 'Unknown' }}</td>
                                    <td class="px-5 py-3.5 text-gray-500">{{ $post->created_at?->format('M d, Y') ?? '—' }}</td>
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.posts.edit', $post) }}" class="rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Delete this post? This cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p id="postsEmptyState" class="hidden p-6 text-center text-sm text-gray-500">No posts match your search.</p>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function wireTableSearch(inputId, rowSelector, emptyStateId) {
            const input = document.getElementById(inputId);
            if (!input) return;

            input.addEventListener('input', () => {
                const query = input.value.trim().toLowerCase();
                const rows = document.querySelectorAll(rowSelector);
                let visibleCount = 0;

                rows.forEach((row) => {
                    const matches = row.dataset.search.includes(query);
                    row.classList.toggle('hidden', !matches);
                    if (matches) visibleCount++;
                });

                const emptyState = document.getElementById(emptyStateId);
                if (emptyState) emptyState.classList.toggle('hidden', visibleCount !== 0);
            });
        }

        wireTableSearch('userSearch', '.user-row', 'usersEmptyState');
        wireTableSearch('postSearch', '.post-row', 'postsEmptyState');
    </script>
@endsection
