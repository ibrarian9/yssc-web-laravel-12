<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Enums\UserRole;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $roleFilter = '';
    public bool $showForm = false;
    public bool $isEditing = false;
    public ?int $editId = null;
    public string $name = '';
    public string $email = '';
    public string $role = 'guest';
    public bool $is_active = true;

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . ($this->editId ?? 'NULL'),
            'role' => 'required|in:superadmin,admin,member,guest',
        ];
        return $rules;
    }

    public function updatingSearch(): void { $this->resetPage(); }

    public function edit(int $id): void
    {
        $user = User::findOrFail($id);
        $this->editId = $id;
        $this->isEditing = true;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role->value;
        $this->is_active = $user->is_active;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $user = User::findOrFail($this->editId);
        $user->update(['name' => $this->name, 'email' => $this->email, 'role' => $this->role, 'is_active' => $this->is_active]);
        session()->flash('success', 'User berhasil diperbarui.');
        $this->showForm = false;
    }

    public function toggleActive(int $id): void
    {
        $user = User::findOrFail($id);
        if ($user->id !== auth()->id()) {
            $user->update(['is_active' => !$user->is_active]);
        }
    }

    public function render()
    {
        $query = User::query();
        if ($this->search) { $query->where(fn($q) => $q->where('name', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%")); }
        if ($this->roleFilter) { $query->where('role', $this->roleFilter); }
        return view('livewire.admin.user-manager', ['users' => $query->latest()->paginate(15)]);
    }
}
