<?php

namespace App\Livewire\Admin;

use App\Mail\MitraApprovedNotification;
use App\Mail\MitraRejectedNotification;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class MitraManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = '';
    public bool $showDetail = false;
    public ?int $selectedId = null;
    public string $catatanAdmin = '';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }

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

        // Auto-create user account for the mitra
        $password = Str::random(10);
        $user = User::create([
            'name' => $mitra->nama_perusahaan,
            'email' => $mitra->email,
            'password' => Hash::make($password),
            'role' => 'mitra',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $mitra->update([
            'status' => 'approved',
            'catatan_admin' => $this->catatanAdmin ?: null,
            'approved_at' => now(),
            'user_id' => $user->id,
        ]);

        // Include password in notification (the Mailable can access $mitra->tempPassword)
        $mitra->tempPassword = $password;

        Mail::to($mitra->email)->send(new MitraApprovedNotification($mitra));

        session()->flash('success', 'Mitra "' . $mitra->nama_perusahaan . '" disetujui. Akun login dibuat & email dikirim.');
        $this->closeDetail();
    }

    public function reject(): void
    {
        $mitra = Mitra::findOrFail($this->selectedId);
        $mitra->update([
            'status' => 'rejected',
            'catatan_admin' => $this->catatanAdmin ?: 'Ditolak oleh admin.',
        ]);

        Mail::to($mitra->email)->send(new MitraRejectedNotification($mitra));

        session()->flash('success', 'Mitra "' . $mitra->nama_perusahaan . '" ditolak.');
        $this->closeDetail();
    }

    public function render()
    {
        $mitraList = Mitra::query()
            ->when($this->search, fn($q) => $q->where(fn($q2) =>
                $q2->where('nama_perusahaan', 'like', "%{$this->search}%")
                   ->orWhere('email', 'like', "%{$this->search}%")
                   ->orWhere('npwp', 'like', "%{$this->search}%")
            ))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->latest()
            ->paginate(15);

        $selected = $this->selectedId ? Mitra::find($this->selectedId) : null;
        $pendingCount = Mitra::pending()->count();

        return view('livewire.admin.mitra-manager', compact('mitraList', 'selected', 'pendingCount'));
    }
}
