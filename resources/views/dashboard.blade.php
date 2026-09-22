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

        @livewire('posts.total-posts-card')

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
        @livewire('posts.manager')
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
