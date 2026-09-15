<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

/**
 * Powers the "Users Management" card on the admin dashboard: the Add New
 * User modal (create only — Edit/Delete keep using the existing
 * Admin\UserController routes/views, untouched) and the users table itself,
 * so a newly created user appears with no full page reload.
 *
 * Dispatches "user-created" after a successful save so sibling components
 * (see TotalUsersCard) can refresh themselves too.
 */
class Manager extends Component
{
    public bool $showModal = false;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public ?string $successMessage = null;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ];
    }

    public function openModal(): void
    {
        $this->reset(['name', 'email', 'password']);
        $this->successMessage = null;
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['name', 'email', 'password']);
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $validated = $this->validate();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset(['name', 'email', 'password']);
        $this->resetErrorBag();
        $this->showModal = false;
        $this->successMessage = 'User created successfully.';

        $this->dispatch('user-created');
    }

    public function render()
    {
        return view('livewire.users.manager', [
            'users' => User::select('id', 'name', 'email', 'created_at')->get(),
        ]);
    }
}
