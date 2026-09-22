<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * The "Total Users" stat card. Listens for the "user-created" event
 * dispatched by Manager so the count updates the moment a user is added,
 * with no page reload.
 */
class TotalUsersCard extends Component
{
    #[On('user-created')]
    #[On('user-deleted')]
    public function refresh(): void
    {
        // Re-rendering re-queries the count below — nothing else to do here.
    }

    public function render()
    {
        return view('livewire.users.total-users-card', [
            'totalUsers' => User::count(),
        ]);
    }
}
