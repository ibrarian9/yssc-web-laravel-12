<?php

namespace App\Livewire\Admin;

use App\Enums\JenisMitra;
use App\Enums\UserRole;
use App\Mail\MitraApprovedNotification;
use App\Mail\MitraRejectedNotification;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MitraManager extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public string $filterStatus = '';

    // Detail modal
    public bool $showDetail = false;
    public ?int $selectedId = null;
    public string $catatanAdmin = '';

    // Form Modal (Tambah / Edit)
    public bool $showFormModal = false;
    public bool $isEditing = false;
    public ?int $editId = null;

    // Form fields
    public string $jenis_mitra = 'perusahaan';
    public string $nama_perusahaan = '';
    public string $email = '';
    public string $telepon = '';
    public string $npwp = '';
    public string $deskripsi = '';
    public string $status = 'approved';
    public $logo;
    public ?string $existingLogo = null;
    public $dokumen_npwp;
    public ?string $existingDokumenNpwp = null;
    public $dokumen_legalitas;
    public ?string $existingDokumenLegalitas = null;
    public string $formCatatanAdmin = '';
    public bool $createUserAccount = true;
    public string $userPassword = '';

    // Delete modal
    public bool $showDeleteConfirm = false;
    public ?int $deleteId = null;

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    protected function rules(): array
    {
        $jenisValues = array_map(fn($j) => $j->value, JenisMitra::cases());

        return [
            'jenis_mitra' => ['required', Rule::in($jenisValues)],
            'nama_perusahaan' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('mitra', 'email')->ignore($this->editId),
            ],
            'telepon' => 'required|string|max:25',
            'npwp' => 'nullable|string|max:40',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
            'logo' => 'nullable|image|max:2048',
            'dokumen_npwp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'dokumen_legalitas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'userPassword' => 'nullable|string|min:8',
        ];
    }

    protected array $messages = [
        'nama_perusahaan.required' => 'Nama perusahaan / institusi mitra wajib diisi.',
        'email.required' => 'Email mitra wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email ini sudah terdaftar sebagai mitra.',
        'telepon.required' => 'Nomor telepon mitra wajib diisi.',
        'logo.image' => 'File logo harus berupa gambar.',
        'logo.max' => 'Ukuran logo maksimal 2MB.',
        'dokumen_npwp.max' => 'Dokumen NPWP maksimal 5MB.',
        'dokumen_legalitas.max' => 'Dokumen legalitas maksimal 5MB.',
        'userPassword.min' => 'Password akun minimal 8 karakter.',
    ];

    public function create(): void
    {
        $this->reset([
            'editId', 'isEditing', 'nama_perusahaan', 'email', 'telepon',
            'npwp', 'deskripsi', 'logo', 'existingLogo', 'dokumen_npwp',
            'existingDokumenNpwp', 'dokumen_legalitas', 'existingDokumenLegalitas',
            'formCatatanAdmin', 'userPassword'
        ]);
        $this->jenis_mitra = JenisMitra::Perusahaan->value;
        $this->status = 'approved';
        $this->createUserAccount = true;
        $this->resetErrorBag();
        $this->showFormModal = true;
    }

    public function edit(int $id): void
    {
        $m = Mitra::findOrFail($id);
        $this->editId = $id;
        $this->isEditing = true;
        $this->jenis_mitra = $m->jenis_mitra->value;
        $this->nama_perusahaan = $m->nama_perusahaan;
        $this->email = $m->email;
        $this->telepon = $m->telepon;
        $this->npwp = $m->npwp ?? '';
        $this->deskripsi = $m->deskripsi ?? '';
        $this->status = $m->status;
        $this->existingLogo = $m->logo;
        $this->existingDokumenNpwp = $m->dokumen_npwp;
        $this->existingDokumenLegalitas = $m->dokumen_legalitas;
        $this->formCatatanAdmin = $m->catatan_admin ?? '';
        $this->logo = null;
        $this->dokumen_npwp = null;
        $this->dokumen_legalitas = null;
        $this->createUserAccount = false;
        $this->userPassword = '';

        $this->resetErrorBag();
        $this->showFormModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'jenis_mitra' => $this->jenis_mitra,
            'nama_perusahaan' => $this->nama_perusahaan,
            'email' => $this->email,
            'telepon' => $this->telepon,
            'npwp' => $this->npwp ?: null,
            'deskripsi' => $this->deskripsi ?: null,
            'status' => $this->status,
            'catatan_admin' => $this->formCatatanAdmin ?: null,
        ];

        if ($this->status === 'approved') {
            $data['approved_at'] = now();
        }

        if ($this->logo) {
            $data['logo'] = $this->logo->store('mitra/logo', 'public');
        }

        if ($this->dokumen_npwp) {
            $data['dokumen_npwp'] = $this->dokumen_npwp->store('mitra/npwp', 'local');
        }

        if ($this->dokumen_legalitas) {
            $data['dokumen_legalitas'] = $this->dokumen_legalitas->store('mitra/legalitas', 'local');
        }

        if ($this->isEditing) {
            $m = Mitra::findOrFail($this->editId);

            if ($this->logo && $m->logo) {
                Storage::disk('public')->delete($m->logo);
            }
            if ($this->dokumen_npwp && $m->dokumen_npwp) {
                Storage::disk('local')->delete($m->dokumen_npwp);
            }
            if ($this->dokumen_legalitas && $m->dokumen_legalitas) {
                Storage::disk('local')->delete($m->dokumen_legalitas);
            }

            $m->update($data);
            session()->flash('success', "Data mitra \"{$m->nama_perusahaan}\" berhasil diperbarui.");
        } else {
            // Check user account creation
            $userId = null;
            if ($this->createUserAccount) {
                $existingUser = User::where('email', $this->email)->first();
                if (!$existingUser) {
                    $password = !empty($this->userPassword) ? $this->userPassword : Str::random(10);
                    $newUser = User::create([
                        'name' => $this->nama_perusahaan,
                        'email' => $this->email,
                        'phone' => $this->telepon,
                        'password' => Hash::make($password),
                        'role' => UserRole::Mitra,
                        'is_active' => true,
                        'must_change_password' => false,
                        'email_verified_at' => now(),
                    ]);
                    $userId = $newUser->id;
                } else {
                    $userId = $existingUser->id;
                    $existingUser->update(['role' => UserRole::Mitra]);
                }
            }

            $data['user_id'] = $userId;
            $m = Mitra::create($data);

            session()->flash('success', "Mitra baru \"{$m->nama_perusahaan}\" berhasil ditambahkan.");
        }

        $this->showFormModal = false;
        $this->reset([
            'editId', 'isEditing', 'nama_perusahaan', 'email', 'telepon',
            'npwp', 'deskripsi', 'logo', 'existingLogo', 'dokumen_npwp',
            'existingDokumenNpwp', 'dokumen_legalitas', 'existingDokumenLegalitas',
            'formCatatanAdmin', 'userPassword'
        ]);
    }

    public function openDetail(int $id): void
    {
        $this->selectedId = $id;
        $mitra = Mitra::find($id);
        $this->catatanAdmin = $mitra?->catatan_admin ?? '';
        $this->showDetail = true;
    }

    public function closeDetail(): void
    {
        $this->showDetail = false;
        $this->selectedId = null;
        $this->catatanAdmin = '';
    }

    public function approve(): void
    {
        $mitra = Mitra::findOrFail($this->selectedId);

        $user = $mitra->user;
        $password = Str::random(10);

        if (!$user) {
            $user = User::where('email', $mitra->email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $mitra->nama_perusahaan,
                    'email' => $mitra->email,
                    'phone' => $mitra->telepon,
                    'password' => Hash::make($password),
                    'role' => UserRole::Mitra,
                    'is_active' => true,
                    'must_change_password' => true,
                    'email_verified_at' => now(),
                ]);
            }
        }

        $mitra->update([
            'status' => 'approved',
            'catatan_admin' => $this->catatanAdmin ?: null,
            'approved_at' => now(),
            'user_id' => $user->id,
        ]);

        $mitra->tempPassword = $password;

        try {
            Mail::to($mitra->email)->send(new MitraApprovedNotification($mitra));
        } catch (\Throwable $e) {
            // Log mail failure gracefully
        }

        session()->flash('success', 'Mitra "' . $mitra->nama_perusahaan . '" disetujui. Akun login dibuat.');
        $this->closeDetail();
    }

    public function reject(): void
    {
        $mitra = Mitra::findOrFail($this->selectedId);
        $mitra->update([
            'status' => 'rejected',
            'catatan_admin' => $this->catatanAdmin ?: 'Ditolak oleh admin.',
        ]);

        try {
            Mail::to($mitra->email)->send(new MitraRejectedNotification($mitra));
        } catch (\Throwable $e) {
            // Log mail failure gracefully
        }

        session()->flash('success', 'Mitra "' . $mitra->nama_perusahaan . '" ditolak.');
        $this->closeDetail();
    }

    public function changeStatus(string $newStatus): void
    {
        if ($this->selectedId) {
            $mitra = Mitra::findOrFail($this->selectedId);
            $mitra->update(['status' => $newStatus]);
            if ($mitra->user) {
                $mitra->user->update(['is_active' => ($newStatus === 'approved')]);
            }
            session()->flash('success', "Status mitra diubah menjadi {$newStatus}.");
            $this->closeDetail();
        }
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
        $this->showDeleteConfirm = true;
    }

    public function executeDelete(): void
    {
        if ($this->deleteId) {
            $m = Mitra::findOrFail($this->deleteId);
            if ($m->logo) {
                Storage::disk('public')->delete($m->logo);
            }
            if ($m->dokumen_npwp) {
                Storage::disk('local')->delete($m->dokumen_npwp);
            }
            if ($m->dokumen_legalitas) {
                Storage::disk('local')->delete($m->dokumen_legalitas);
            }
            $m->delete();
            session()->flash('success', 'Data mitra berhasil dihapus.');
        }

        $this->showDeleteConfirm = false;
        $this->deleteId = null;
        $this->closeDetail();
    }

    public function render()
    {
        $mitraList = Mitra::query()
            ->when($this->search, fn($q) => $q->where(fn($q2) =>
                $q2->where('nama_perusahaan', 'like', "%{$this->search}%")
                   ->orWhere('email', 'like', "%{$this->search}%")
                   ->orWhere('npwp', 'like', "%{$this->search}%")
                   ->orWhere('telepon', 'like', "%{$this->search}%")
            ))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->latest()
            ->paginate(15);

        $selected = $this->selectedId ? Mitra::find($this->selectedId) : null;
        $pendingCount = Mitra::pending()->count();

        return view('livewire.admin.mitra-manager', [
            'mitraList' => $mitraList,
            'selected' => $selected,
            'pendingCount' => $pendingCount,
            'jenisOptions' => JenisMitra::cases(),
        ]);
    }
}
