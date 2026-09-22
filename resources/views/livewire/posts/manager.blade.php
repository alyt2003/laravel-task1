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
            <button type="button" wire:click="openModal" class="inline-flex flex-shrink-0 items-center justify-center gap-1.5 whitespace-nowrap rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Add New Post
            </button>
        </div>
    </div>

    @if ($successMessage)
        <div class="mx-5 mt-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
            {{ $successMessage }}
        </div>
    @endif

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
                        <tr wire:key="post-{{ $post->id }}" class="post-row hover:bg-gray-50 transition-colors" data-search="{{ strtolower($post->title) }}">
                            <td class="px-5 py-3.5 text-gray-500">{{ $post->id }}</td>
                            <td class="px-5 py-3.5 font-medium text-gray-900">{{ $post->title }}</td>
                            <td class="px-5 py-3.5 text-gray-500">{{ \Illuminate\Support\Str::limit($post->content, 60) }}</td>
                            <td class="px-5 py-3.5 text-gray-600">{{ $post->user->name ?? 'Unknown' }}</td>
                            <td class="px-5 py-3.5 text-gray-500">{{ $post->created_at?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" wire:click="openEditModal({{ $post->id }})" class="rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                                        Edit
                                    </button>
                                    <button type="button" wire:click="deletePost({{ $post->id }})" wire:confirm="Delete this post? This cannot be undone." class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p id="postsEmptyState" class="hidden p-6 text-center text-sm text-gray-500">No posts match your search.</p>
        </div>
    @endif

    {{-- Add / Edit Post modal --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="fixed inset-0 bg-black/40" wire:click="closeModal"></div>

            <div class="relative w-full max-w-md rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="mb-5 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $editingId ? 'Edit Post' : 'Add New Post' }}</h3>
                    <button type="button" wire:click="closeModal" class="rounded-lg p-1 text-gray-400 hover:bg-gray-50 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-3.5 text-sm text-red-700">
                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form wire:submit="save" class="space-y-5">
                    <div>
                        <label for="post-owner" class="mb-1.5 block text-sm font-medium text-gray-700">Owner</label>
                        <select id="post-owner" wire:model="userId" required
                            class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            <option value="" disabled>Select a user</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="post-title" class="mb-1.5 block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="post-title" wire:model="title" required
                            class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="post-content" class="mb-1.5 block text-sm font-medium text-gray-700">Content</label>
                        <textarea id="post-content" wire:model="content" required rows="6"
                            class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-colors disabled:opacity-60">
                            <span wire:loading.remove wire:target="save">{{ $editingId ? 'Save Changes' : 'Create Post' }}</span>
                            <span wire:loading wire:target="save">Saving...</span>
                        </button>
                        <button type="button" wire:click="closeModal" class="inline-flex items-center justify-center rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
