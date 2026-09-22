<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use App\Models\User;
use Livewire\Component;

/**
 * Powers the "Posts Management" card on the admin dashboard: add / edit /
 * delete posts and the posts table itself, with no full page reload.
 *
 * One modal serves both Add and Edit: $editingId is null when adding and
 * holds the post's id when editing. Mirrors Users\Manager.
 *
 * Dispatches "post-created" / "post-updated" / "post-deleted" after a
 * successful action so sibling components (see TotalPostsCard) can refresh.
 *
 * Every action re-checks that the caller is an admin — Livewire actions are
 * plain HTTP requests to /livewire/update, so they must not rely only on the
 * page's route middleware.
 */
class Manager extends Component
{
    public bool $showModal = false;

    public ?int $editingId = null;

    // Kept as a string because the <select>'s empty option submits "".
    public string $userId = '';

    public string $title = '';

    public string $content = '';

    public ?string $successMessage = null;

    protected function rules(): array
    {
        return [
            'userId' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'userId' => 'owner',
        ];
    }

    public function openModal(): void
    {
        $this->authorizeAdmin();

        $this->resetForm();
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $this->authorizeAdmin();

        $post = Post::findOrFail($id);

        $this->resetForm();
        $this->editingId = $post->id;
        $this->userId = (string) $post->user_id;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save(): void
    {
        $this->authorizeAdmin();

        $validated = $this->validate();

        $data = [
            'user_id' => (int) $validated['userId'],
            'title' => $validated['title'],
            'content' => $validated['content'],
        ];

        if ($this->editingId) {
            Post::findOrFail($this->editingId)->update($data);

            $message = 'Post updated successfully.';
            $event = 'post-updated';
        } else {
            Post::create($data);

            $message = 'Post created successfully.';
            $event = 'post-created';
        }

        $this->showModal = false;
        $this->resetForm();
        $this->successMessage = $message;

        $this->dispatch($event);
    }

    public function deletePost(int $id): void
    {
        $this->authorizeAdmin();

        $this->successMessage = null;

        Post::findOrFail($id)->delete();

        $this->successMessage = 'Post deleted successfully.';

        $this->dispatch('post-deleted');
    }

    public function render()
    {
        return view('livewire.posts.manager', [
            'posts' => Post::with('user:id,name')->latest()->get(),
            // Only needed for the Owner dropdown inside the modal.
            'users' => $this->showModal ? User::orderBy('name')->get(['id', 'name']) : collect(),
        ]);
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'userId', 'title', 'content', 'successMessage']);
        $this->resetErrorBag();
    }

    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()?->isAdmin(), 403);
    }
}
