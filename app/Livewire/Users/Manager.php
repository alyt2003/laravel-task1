<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

/**
 * Powers the "Users Management" card on the admin dashboard: add / edit /
 * delete users and the users table itself, all without a full page reload.
 *
 * One modal serves both Add and Edit: $editingId is null when adding and
 * holds the user's id when editing.
 *
 * Dispatches "user-created" / "user-updated" / "user-deleted" after a
 * successful action so sibling components (see TotalUsersCard) can refresh.
 *
 * Every action re-checks that the caller is an admin — Livewire actions are
 * plain HTTP requests to /livewire/update, so they must not rely only on the
 * page's route middleware.
 */
class Manager extends Component
{
    public bool $showModal = false;

    public ?int $editingId = null;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public ?string $successMessage = null;

    public ?string $errorMessage = null;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->editingId)],
            // Required when adding; optional when editing (blank = keep current password).
            'password' => [$this->editingId ? 'nullable' : 'required', 'string', 'min:8'],
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

        $user = User::findOrFail($id);

        $this->resetForm();
        $this->editingId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
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

        if ($this->editingId) {
            $user = User::findOrFail($this->editingId);

            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if (filled($validated['password'] ?? null)) {
                $data['password'] = Hash::make($validated['password']);
            }

            $user->update($data);

            $message = 'User updated successfully.';
            $event = 'user-updated';
        } else {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $message = 'User created successfully.';
            $event = 'user-created';
        }

        $this->showModal = false;
        $this->resetForm();
        $this->successMessage = $message;

        $this->dispatch($event);
    }

    public function deleteUser(int $id): void
    {
        $this->authorizeAdmin();

        $this->successMessage = null;
        $this->errorMessage = null;

        if ($id === auth()->id()) {
            $this->errorMessage = 'You cannot delete your own account while logged in.';

            return;
        }

        User::findOrFail($id)->delete();

        $this->successMessage = 'User deleted successfully.';

        $this->dispatch('user-deleted');
    }

    public function render()
    {
        return view('livewire.users.manager', [
            'users' => User::select('id', 'name', 'email', 'created_at')->get(),
        ]);
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'email', 'password', 'successMessage', 'errorMessage']);
        $this->resetErrorBag();
    }

    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()?->isAdmin(), 403);
    }
}
