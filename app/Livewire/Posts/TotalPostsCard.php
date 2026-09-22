<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * The "Total Posts" stat card. Listens for the events dispatched by
 * Posts\Manager so the count updates the moment a post is added or
 * deleted, with no page reload.
 */
class TotalPostsCard extends Component
{
    #[On('post-created')]
    #[On('post-deleted')]
    public function refresh(): void
    {
        // Re-rendering re-queries the count below — nothing else to do here.
    }

    public function render()
    {
        return view('livewire.posts.total-posts-card', [
            'totalPosts' => Post::count(),
        ]);
    }
}
