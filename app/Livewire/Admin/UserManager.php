<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $roleFilter = '';

    // Modal & Form State
    public bool $showForm = false;
    public bool $isEditing = false;
    public ?int $editId = null;

    // Form fields
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'member';
    public bool $is_active = true;
    public bool $email_verified = true;
    public bool $must_change_password = false;

    // Delete modal
    public bool $showDeleteModal = false;
    public ?int $deleteUserId = null;

    public function boot(): void
    {
        abort_unless(auth()->user()?->isSuperAdmin(), 403);
    }

    protected function rules(): array
    {
        $roleValues = array_map(fn($r) => $r->value, UserRole::cases());

        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->editId),
            ],
            'phone' => 'nullable|string|max:20',
            'role' => ['required', Rule::in($roleValues)],
            'is_active' => 'boolean',
            'must_change_password' => 'boolean',
        ];

        if ($this->isEditing) {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        } else {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;
    }

    protected array $messages = [
        'name.required' => 'Nama pengguna wajib diisi.',
        'email.required' => 'Alamat email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email ini sudah terdaftar.',
        'role.required' => 'Pilih role pengguna.',
        'role.in' => 'Role yang dipilih tidak valid.',
        'password.required' => 'Password wajib diisi untuk pengguna baru.',
        'password.min' => 'Password minimal terdiri dari 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingRoleFilter(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->reset([
            'editId', 'isEditing', 'name', 'email', 'phone',
            'password', 'password_confirmation', 'must_change_password'
        ]);
        $this->role = UserRole::Member->value;
        $this->is_active = true;
        $this->email_verified = true;
        $this->resetErrorBag();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $user = User::findOrFail($id);
        $this->editId = $id;
        $this->isEditing = true;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->role = $user->role->value;
        $this->is_active = (bool) $user->is_active;
        $this->email_verified = !is_null($user->email_verified_at);
        $this->must_change_password = (bool) $user->must_change_password;
        $this->password = '';
        $this->password_confirmation = '';
        $this->resetErrorBag();
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        if ($this->isEditing) {
            $user = User::findOrFail($this->editId);

            if ($user->id === auth()->id()) {
                if ($this->role !== UserRole::SuperAdmin->value) {
                    $this->addError('role', 'Anda tidak dapat menurunkan role Super Admin milik Anda sendiri.');
                    return;
                }
                if (! $this->is_active) {
                    $this->addError('is_active', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
                    return;
                }
            }

            $updateData = [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone ?: null,
                'role' => $this->role,
                'is_active' => $this->is_active,
                'must_change_password' => $this->must_change_password,
            ];

            if (!empty($this->password)) {
                $updateData['password'] = Hash::make($this->password);
            }

            if ($this->email_verified && is_null($user->email_verified_at)) {
                $updateData['email_verified_at'] = now();
            } elseif (!$this->email_verified && !is_null($user->email_verified_at)) {
                $updateData['email_verified_at'] = null;
            }

            $user->update($updateData);
            session()->flash('success', "Pengguna \"{$user->name}\" berhasil diperbarui.");
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone ?: null,
                'password' => Hash::make($this->password),
                'role' => $this->role,
                'is_active' => $this->is_active,
                'must_change_password' => $this->must_change_password,
                'email_verified_at' => $this->email_verified ? now() : null,
            ]);

            session()->flash('success', "Pengguna baru \"{$user->name}\" berhasil ditambahkan.");
        }

        $this->showForm = false;
        $this->reset([
            'editId', 'isEditing', 'name', 'email', 'phone',
            'password', 'password_confirmation'
        ]);
    }

    public function toggleActive(int $id): void
    {
        $user = User::findOrFail($id);
        if ($user->id !== auth()->id()) {
            $user->update(['is_active' => !$user->is_active]);
            session()->flash('success', "Status akun \"{$user->name}\" telah diubah.");
        }
    }

    public function confirmDelete(int $id): void
    {
        if ($id === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return;
        }

        $this->deleteUserId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteUser(): void
    {
        if ($this->deleteUserId) {
            $user = User::findOrFail($this->deleteUserId);
            if ($user->id !== auth()->id()) {
                $userName = $user->name;
                $user->delete();
                session()->flash('success', "Pengguna \"{$userName}\" berhasil dihapus.");
            }
        }

        $this->showDeleteModal = false;
        $this->deleteUserId = null;
    }

    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%");
            });
        }

        if ($this->roleFilter) {
            $query->where('role', $this->roleFilter);
        }

        return view('livewire.admin.user-manager', [
            'users' => $query->latest()->paginate(15),
            'roles' => UserRole::cases(),
        ]);
    }
}
