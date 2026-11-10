<?php

namespace App\Livewire\Admin;

use App\Models\Relawan;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class RelawanManager extends Component
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
    public string $nama = '';
    public string $email = '';
    public string $telepon = '';
    public string $alamat = '';
    public ?string $tanggal_lahir = null;
    public string $pekerjaan = '';
    public string $keahlian = '';
    public string $motivasi = '';
    public string $status = 'approved';
    public $foto;
    public ?string $existingFoto = null;
    public string $formCatatanAdmin = '';

    // Delete modal
    public bool $showDeleteConfirm = false;
    public ?int $deleteId = null;

    protected function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'pekerjaan' => 'nullable|string|max:100',
            'keahlian' => 'nullable|string|max:255',
            'motivasi' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
            'foto' => 'nullable|image|max:2048',
            'formCatatanAdmin' => 'nullable|string',
        ];
    }

    protected array $messages = [
        'nama.required' => 'Nama relawan wajib diisi.',
        'email.required' => 'Email relawan wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'telepon.required' => 'Nomor telepon wajib diisi.',
        'motivasi.required' => 'Motivasi bergabung wajib diisi.',
        'foto.image' => 'File foto harus berupa gambar.',
        'foto.max' => 'Ukuran foto maksimal 2MB.',
    ];

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    public function create(): void
    {
        $this->reset([
            'editId', 'isEditing', 'nama', 'email', 'telepon', 'alamat',
            'tanggal_lahir', 'pekerjaan', 'keahlian', 'motivasi', 'foto',
            'existingFoto', 'formCatatanAdmin'
        ]);
        $this->status = 'approved';
        $this->resetErrorBag();
        $this->showFormModal = true;
    }

    public function edit(int $id): void
    {
        $r = Relawan::findOrFail($id);
        $this->editId = $id;
        $this->isEditing = true;
        $this->nama = $r->nama;
        $this->email = $r->email;
        $this->telepon = $r->telepon;
        $this->alamat = $r->alamat ?? '';
        $this->tanggal_lahir = $r->tanggal_lahir ? $r->tanggal_lahir->format('Y-m-d') : null;
        $this->pekerjaan = $r->pekerjaan ?? '';
        $this->keahlian = $r->keahlian ?? '';
        $this->motivasi = $r->motivasi ?? '';
        $this->status = $r->status;
        $this->existingFoto = $r->foto;
        $this->foto = null;
        $this->formCatatanAdmin = $r->catatan_admin ?? '';

        $this->resetErrorBag();
        $this->showFormModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'nama' => $this->nama,
            'email' => $this->email,
            'telepon' => $this->telepon,
            'alamat' => $this->alamat ?: null,
            'tanggal_lahir' => $this->tanggal_lahir ?: null,
            'pekerjaan' => $this->pekerjaan ?: null,
            'keahlian' => $this->keahlian ?: null,
            'motivasi' => $this->motivasi,
            'status' => $this->status,
            'catatan_admin' => $this->formCatatanAdmin ?: null,
        ];

        if ($this->status === 'approved') {
            $data['approved_at'] = now();
        }

        if ($this->foto) {
            $data['foto'] = $this->foto->store('relawan/foto', 'public');
        }

        if ($this->isEditing) {
            $r = Relawan::findOrFail($this->editId);

            if ($this->foto && $r->foto) {
                Storage::disk('public')->delete($r->foto);
            }

            $r->update($data);
            session()->flash('success', "Data relawan \"{$r->nama}\" berhasil diperbarui.");
        } else {
            $r = Relawan::create($data);
            session()->flash('success', "Relawan baru \"{$r->nama}\" berhasil ditambahkan.");
        }

        $this->showFormModal = false;
        $this->reset([
            'editId', 'isEditing', 'nama', 'email', 'telepon', 'alamat',
            'tanggal_lahir', 'pekerjaan', 'keahlian', 'motivasi', 'foto',
            'existingFoto', 'formCatatanAdmin'
        ]);
    }

    public function openDetail(int $id): void
    {
        $this->selectedId = $id;
        $r = Relawan::find($id);
        $this->catatanAdmin = $r?->catatan_admin ?? '';
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
        $r = Relawan::findOrFail($this->selectedId);
        $r->update([
            'status' => 'approved',
            'catatan_admin' => $this->catatanAdmin ?: null,
            'approved_at' => now(),
        ]);
        session()->flash('success', 'Relawan "' . $r->nama . '" disetujui.');
        $this->closeDetail();
    }

    public function reject(): void
    {
        $r = Relawan::findOrFail($this->selectedId);
        $r->update([
            'status' => 'rejected',
            'catatan_admin' => $this->catatanAdmin ?: 'Ditolak oleh admin.',
        ]);
        session()->flash('success', 'Relawan "' . $r->nama . '" ditolak.');
        $this->closeDetail();
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
        $this->showDeleteConfirm = true;
    }

    public function executeDelete(): void
    {
        if ($this->deleteId) {
            $r = Relawan::findOrFail($this->deleteId);
            if ($r->foto) {
                Storage::disk('public')->delete($r->foto);
            }
            $r->delete();
            session()->flash('success', 'Data relawan berhasil dihapus.');
        }
        $this->showDeleteConfirm = false;
        $this->deleteId = null;
        $this->closeDetail();
    }

    public function render()
    {
        $list = Relawan::query()
            ->when($this->search, fn($q) => $q->where(fn($q2) =>
                $q2->where('nama', 'like', "%{$this->search}%")
                   ->orWhere('email', 'like', "%{$this->search}%")
                   ->orWhere('telepon', 'like', "%{$this->search}%")
            ))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->latest()
            ->paginate(15);

        $selected = $this->selectedId ? Relawan::find($this->selectedId) : null;
        $pendingCount = Relawan::pending()->count();

        return view('livewire.admin.relawan-manager', compact('list', 'selected', 'pendingCount'));
    }
}
